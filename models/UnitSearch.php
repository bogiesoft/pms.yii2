<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Unit;

/**
 * UnitSearch represents the model behind the search form about `app\models\Unit`.
 */
class UnitSearch extends Unit
{
    public $bank;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unitid', 'BankId'], 'integer'],
            [['code', 'Name', 'BankAcc'], 'safe'],
            [['bank'],'safe'],
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
        $query = Unit::find();
        $query->joinWith(['bank']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['bank'] = [
            'asc' => ['concat(ps_bank.code," - ",ps_bank.name)' => SORT_ASC],
            'desc' => ['concat(ps_bank.code," - ",ps_bank.name)' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'unitid' => $this->unitid,            
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'ps_unit.code', $this->code])   
            ->andFilterWhere(['like', 'ps_unit.Name', $this->Name])
            ->andFilterWhere(['like', 'concat(ps_bank.code," - ",ps_bank.name)', $this->bank])
            ->andFilterWhere(['like', 'BankAcc', $this->BankAcc])            
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
