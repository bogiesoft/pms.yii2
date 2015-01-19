<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Consultant;

/**
 * ConsultantSearch represents the model behind the search form about `app\models\Consultant`.
 */
class ConsultantSearch extends Consultant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consultantid', 'categoryid'], 'integer'],
            [['lectureid', 'varCategory', 'employeeid', 'name', 'residentid', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
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
        $query = Consultant::find();
        $query->joinWith(['category']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['varCategory'] = [
            'asc' => ['ps_category.category' => SORT_ASC],
            'desc' => ['ps_category.category' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'consultantid' => $this->consultantid,
            'categoryid' => $this->categoryid,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'lectureid', $this->lectureid])
            ->andFilterWhere(['like', 'employeeid', $this->employeeid])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'residentid', $this->residentid])
            ->andFilterWhere(['like', 'ps_category.category', $this->varCategory])
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
