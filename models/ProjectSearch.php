<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Project;

/**
 * ProjectSearch represents the model behind the search form about `app\models\Project`.
 */
class ProjectSearch extends Project
{
    public $unit;
    public $customer;
    public $producttype;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectid', 'unitid', 'customerid', 'producttypeid', 'statusid'], 'integer'],
            [['code', 'name', 'description', 'initiationyear', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
            [['unit','customer','producttype','status'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Project::find();
        $query->joinWith(['unit','customer','producttype','status']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $user = \app\models\User::find()->where(['userid' => Yii::$app->user->identity->userid])->one();

        $query->andFilterWhere(['in','ps_project.unitid',$user->accessUnit]);

        $dataProvider->sort->attributes['unit'] = [
            'asc'=>['concat(ps_unit.code," - ",ps_unit.Name)'=>SORT_ASC],
            'desc'=>['concat(ps_unit.code," - ",ps_unit.Name)'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['customer'] = [
            'asc'=>['ps_customer.company'=>SORT_ASC],
            'desc'=>['ps_customer.company'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['producttype'] = [
            'asc'=>['concat(ps_producttype.code," - ",ps_producttype.name)'=>SORT_ASC],
            'desc'=>['concat(ps_producttype.code," - ",ps_producttype.name)'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['status'] = [
            'asc'=>['ps_status.name'=>SORT_ASC],
            'desc'=>['ps_status.name'=>SORT_DESC],            
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'projectid' => $this->projectid,
            'ps_project.unitid' => $this->unitid,
            'ps_project.customerid' => $this->customerid,
            'ps_project.producttypeid' => $this->producttypeid,
            'ps_project.statusid' => $this->statusid,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'ps_project.code', $this->code])
            ->andFilterWhere(['like', 'ps_project.name', $this->name])
            ->andFilterWhere(['like', 'ps_project.description', $this->description])
            ->andFilterWhere(['like', 'date_format(ps_project.initiationyear, \'%d-%b-%Y\')', $this->initiationyear])
            ->andFilterWhere(['like', 'concat(ps_unit.code," - ",ps_unit.Name)', $this->unit])
            ->andFilterWhere(['like', 'ps_customer.company', $this->customer])
            ->andFilterWhere(['like', 'concat(ps_producttype.code," - ",ps_producttype.name)', $this->producttype])
            ->andFilterWhere(['like', 'ps_status.name', $this->status])
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
