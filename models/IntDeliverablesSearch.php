<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IntDeliverables;

/**
 * IntDeliverablesSearch represents the model behind the search form about `app\models\IntDeliverables`.
 */
class IntDeliverablesSearch extends IntDeliverables
{
    public $intagreement;
    public $extdeliverables;
    public $consultantposition;
    public $projectrate;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intdeliverableid', 'intagreementid', 'extdeliverableid', 'positionid', 'frequency', 'rateid', 'rate'], 'integer'],
            [['description', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
            [['intagreement','extdeliverables','consultantposition','projectrate'],'safe'],
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
        $query = IntDeliverables::find();
        $query->joinWith(['intagreement','extdeliverables','consultantposition','projectrate']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['intagreement'] = [
            'asc'=>['ps_intagreement.description'=>SORT_ASC],
            'desc'=>['ps_intagreement.description'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['extdeliverables'] = [
            'asc'=>['ps_extdeliverables.description'=>SORT_ASC],
            'desc'=>['ps_extdeliverables.description'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['consultantposition'] = [
            'asc'=>['ps_consultantposition.name'=>SORT_ASC],
            'desc'=>['ps_consultantposition.name'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['projectrate'] = [
            'asc'=>['ps_projectrate.role'=>SORT_ASC],
            'desc'=>['ps_projectrate.role'=>SORT_DESC],            
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'intdeliverableid' => $this->intdeliverableid,
            'intagreementid' => $this->intagreementid,
            'extdeliverableid' => $this->extdeliverableid,
            'positionid' => $this->positionid,
            'frequency' => $this->frequency,
            'rateid' => $this->rateid,
            'rate' => $this->rate,
        ]);

        $query->andFilterWhere(['like', 'ps_intdeliverables.description', $this->description])
            ->andFilterWhere(['like', 'ps_intagreement.description', $this->intagreement])
            ->andFilterWhere(['like', 'ps_extdeliverables.description', $this->extdeliverables])
            ->andFilterWhere(['like', 'ps_consultantposition.name', $this->consultantposition])
            ->andFilterWhere(['like', 'ps_projectrate.role', $this->projectrate]);

        return $dataProvider;
    }
}
