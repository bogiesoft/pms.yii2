<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IntAgreementPayment;

/**
 * IntAgreementPaymentSearch represents the model behind the search form about `app\models\IntAgreementPayment`.
 */
class IntAgreementPaymentSearch extends IntDeliverables
{
    public $consultant;
    public $deliverable;
    public $payment;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intdeliverableid'], 'integer'],
            [['duedate', 'deliverdate', 'consultant', 'deliverable', 'payment'], 'safe'],
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
    public function search($params, $projectid)
    {
        $query = IntDeliverables::find();
        
        $query->joinWith(['intagreement'])
            ->leftJoin('ps_consultant', 'ps_consultant.consultantid = ps_intagreement.consultantid')
            ->leftJoin('ps_extagreement', 'ps_intagreement.extagreementid = ps_extagreement.extagreementid')
            ->leftJoin('ps_intagreementpayment', 'ps_intdeliverables.intdeliverableid = ps_intagreementpayment.intdeliverableid')
            ->leftJoin('ps_project', 'ps_project.projectid = ps_extagreement.projectid');

        if($projectid > 0){
            $query->where(['ps_project.projectid'=>$projectid]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['payment'] = [
            'asc'=>['ps_intagreementpayment.date'=>SORT_ASC],
            'desc'=>['ps_intagreementpayment.date'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['consultant'] = [
            'asc'=>['ps_consultant.name'=>SORT_ASC],
            'desc'=>['ps_consultant.name'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['deliverable'] = [
            'asc'=>['ps_intdeliverables.description'=>SORT_ASC],
            'desc'=>['ps_intdeliverables.description'=>SORT_DESC],            
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'ps_consultant.name', $this->consultant])
            ->andFilterWhere(['like', 'ps_intdeliverables.description', $this->deliverable])
            ->andFilterWhere(['like', 'DATE_FORMAT(duedate, \'%d-%b-%Y\')', $this->duedate])
            ->andFilterWhere(['like', 'DATE_FORMAT(deliverdate, \'%d-%b-%Y\')', $this->deliverdate])
            ->andFilterWhere(['like', 'DATE_FORMAT(ps_intagreementpayment.date, \'%d-%b-%Y\')', $this->payment])
            ;

        return $dataProvider;
    }
}
