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
            [['agreementno', 'description', 'startdate', 'enddate', 'filename', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
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
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'agreementno', $this->agreementno])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'concat(ps_project.code," - ",ps_project.name)', $this->project])
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}

