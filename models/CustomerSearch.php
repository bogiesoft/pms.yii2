<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerid', 'countryid', 'partnertypeid'], 'integer'],
            [['company', 'dayofjoin', 'npwp', 'phone', 'fax', 'address', 'city', 'state', 'webpage', 'varPartnertype'], 'safe'],
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
        $query = Customer::find();
        $query->joinWith(['partnertype']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['varPartnertype'] = [
            'asc' => ['ps_partnertype.name' => SORT_ASC],
            'desc' => ['ps_partnertype.name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'customerid' => $this->customerid,
            'dayofjoin' => $this->dayofjoin,
            'countryid' => $this->countryid,
            'partnertypeid' => $this->partnertypeid,
        ]);

        $query->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'npwp', $this->npwp])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'webpage', $this->webpage])
            ->andFilterWhere(['like', 'ps_partnertype.name', $this->varPartnertype]);

        return $dataProvider;
    }
}
