<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ExtAgreement;

/**
 * ExtAgreementSearch represents the model behind the search form about `app\models\ExtAgreement`.
 */
class ExtAgreementSearch extends ExtAgreement
{
    public $project;
    public $unit;
    public $customer;
    public $producttype;
    public $status;
    public $initiationyear;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extagreementid', 'projectid'], 'integer'],
            [['agreementno', 'description', 'startdate', 'enddate', 'filename'], 'safe'],
            [['project','unit','customer','producttype','status','initiationyear'],'safe'],
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
    public function search($params, $projectid = 0)
    {
        $query = ExtAgreement::find();
        $query->joinWith(['project'])
            ->leftJoin('ps_unit', 'ps_project.unitid = ps_unit.unitid')
            ->leftJoin('ps_customer', 'ps_project.customerid = ps_customer.customerid')
            ->leftJoin('ps_producttype', 'ps_project.producttypeid = ps_producttype.producttypeid')
            ->leftJoin('ps_status', 'ps_project.statusid = ps_status.statusid');

        if($projectid > 0){
            $query->where(['ps_extagreement.projectid'=>$projectid]);
        }

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

        $dataProvider->sort->attributes['project'] = [
            'asc'=>['concat(ps_project.code," - ",ps_project.name)'=>SORT_ASC],
            'desc'=>['concat(ps_project.code," - ",ps_project.name)'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['initiationyear'] = [
            'asc'=>['ps_project.initiationyear'=>SORT_ASC],
            'desc'=>['ps_project.initiationyear'=>SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'extagreementid' => $this->extagreementid,
            'projectid' => $this->projectid,
        ]);

        $query->andFilterWhere(['like', 'agreementno', $this->agreementno])
            ->andFilterWhere(['like', 'ps_extagreement.description', $this->description])
            ->andFilterWhere(['like', 'ps_customer.company', $this->customer])
            ->andFilterWhere(['like', 'ps_producttype.name', $this->producttype])
            ->andFilterWhere(['like', 'ps_status.name', $this->status])
            ->andFilterWhere(['like', 'concat(ps_unit.code, \' - \', ps_unit.name)', $this->unit])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'date_format(startdate, \'%d-%b-%Y\')', $this->startdate])
            ->andFilterWhere(['like', 'date_format(enddate, \'%d-%b-%Y\')', $this->enddate])
            ->andFilterWhere(['like', 'date_format(ps_project.initiationyear, \'%d-%b-%Y\')', $this->initiationyear])
            ->andFilterWhere(['like', 'concat(ps_project.code," - ",ps_project.name)', $this->project]);

        return $dataProvider;
    }
}

