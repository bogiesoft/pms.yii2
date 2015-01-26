<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ExtAgreementPayment;
use app\models\ExtDeliverables;

/**
 * ExtAgreementPaymentSearch represents the model behind the search form about `app\models\ExtAgreementPayment`.
 */
class ExtAgreementPaymentSearch extends ExtDeliverables
{
    public $customer;
    public $deliverable;
    public $payment;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extdeliverableid'], 'integer'],
            [['duedate', 'deliverdate','customer','deliverable','payment'], 'safe'],
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
        $query = ExtDeliverables::find();

        $query->joinWith(['extagreement'])
        ->leftJoin('ps_project', 'ps_project.projectid = ps_extagreement.projectid')
        ->leftJoin('ps_customer', 'ps_project.customerid = ps_customer.customerid')
        ->leftJoin('ps_extagreementpayment', 'ps_extdeliverables.extdeliverableid = ps_extagreementpayment.extdeliverableid');

        if($projectid > 0){
            $query->where(['ps_project.projectid'=>$projectid]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['customer'] = [
            'asc'=>['ps_customer.company'=>SORT_ASC],
            'desc'=>['ps_customer.company'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['deliverable'] = [
            'asc'=>['concat(ps_extdeliverables.code, \' - \', ps_extdeliverables.description)'=>SORT_ASC],
            'desc'=>['concat(ps_extdeliverables.code, \' - \', ps_extdeliverables.description)'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['payment'] = [
            'asc'=>['ps_extagreementpayment.date'=>SORT_ASC],
            'desc'=>['ps_extagreementpayment.date'=>SORT_DESC],            
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'ps_customer.name', $this->customer])
            ->andFilterWhere(['like', 'concat(ps_extdeliverables.code, \' - \', ps_extdeliverables.description)', $this->deliverable])
            ->andFilterWhere(['like', 'DATE_FORMAT(duedate, \'%d-%b-%Y\')', $this->duedate])
            ->andFilterWhere(['like', 'DATE_FORMAT(deliverdate, \'%d-%b-%Y\')', $this->deliverdate])
            ->andFilterWhere(['like', 'DATE_FORMAT(ps_extagreementpayment.date, \'%d-%b-%Y\')', $this->payment])
            ;

        return $dataProvider;
    }
}
