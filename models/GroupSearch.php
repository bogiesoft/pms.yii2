<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Group;

/**
 * GroupSearch represents the model behind the search form about `app\models\Group`.
 */
class GroupSearch extends Group
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupid'], 'integer'],
            [['name', 'description', 'active','varActive'], 'safe'],
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
        $query = Group::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['varActive'] = [
            'asc' => ['active' => SORT_ASC],
            'desc' => ['active' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'groupid' => $this->groupid,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'active', $this->varActive != "" ? strtolower($this->varActive) == "yes" ? '1' : '0' : ""]);

        return $dataProvider;
    }
}
