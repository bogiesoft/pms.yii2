<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ExtDeliverables;

/**
 * ExtDeliverablesSearch represents the model behind the search form about `app\models\ExtDeliverables`.
 */
class ExtDeliverablesSearch extends ExtDeliverables
{
    public $extagreement;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extdeliverableid', 'extagreementid', 'rate'], 'integer'],
            [['code', 'description', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
            [['extagreement'],'safe'],
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
        $query = ExtDeliverables::find();
        $query->joinWith(['extagreement']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['extagreement'] = [
            'asc'=>['ps_extagreement.description'=>SORT_ASC],
            'desc'=>['ps_extagreement.description'=>SORT_DESC],            
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'extdeliverableid' => $this->extdeliverableid,
            'extagreementid' => $this->extagreementid,
            'rate' => $this->rate,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'ps_extdeliverables.description', $this->description])
            ->andFilterWhere(['like', 'ps_extagreement.description', $this->extagreement])
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
