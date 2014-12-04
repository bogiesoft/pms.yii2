<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProjectRate;

/**
 * ProjectRateSearch represents the model behind the search form about `app\models\ProjectRate`.
 */
class ProjectRateSearch extends ProjectRate
{
    public $mindunit;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rateid', 'mindunitid', 'rate'], 'integer'],
            [['role', 'description', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
            [['mindunit'],'safe'],
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
        $query = ProjectRate::find();
        $query->joinWith(['mindunit']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['mindunit'] = [
            'asc' => ['ps_mindunit.name' => SORT_ASC],
            'desc' => ['ps_mindunit.name' => SORT_DESC],            
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'rateid' => $this->rateid,
            'mindunitid' => $this->mindunitid,
            'rate' => $this->rate,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'ps_mindunit.name', $this->mindunit])
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
