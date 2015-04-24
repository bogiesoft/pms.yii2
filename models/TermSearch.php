<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Term;

/**
 * TermSearch represents the model behind the search form about `app\models\Term`.
 */
class TermSearch extends Term
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['termid'], 'integer'],
            [['priod', 'kdsem', 'startdate', 'enddate', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
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
        $query = Term::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'termid' => $this->termid,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'priod', $this->priod])
            ->andFilterWhere(['like', 'kdsem', $this->kdsem])
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'date_format(startdate, \'%d-%b-%Y\')', $this->startdate])
            ->andFilterWhere(['like', 'date_format(enddate, \'%d-%b-%Y\')', $this->enddate])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
