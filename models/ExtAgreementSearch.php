<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ExtAgreement;

/**
 * ExtAgreementSearch represents the model behind the search form about `app\models\ExtAgreement`.
 */
class ExtAgreementSearch extends ExtAgreement
{
    public $project;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extagreementid', 'projectid'], 'integer'],
            [['agreementno', 'description', 'startdate', 'enddate', 'filename', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
            [['project'],'safe'],
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
        $query = ExtAgreement::find();
        $query->joinWith(['project']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['project'] = [
            'asc'=>['concat(ps_project.code," - ",ps_project.name)'=>SORT_ASC],
            'desc'=>['concat(ps_project.code," - ",ps_project.name)'=>SORT_DESC],            
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'extagreementid' => $this->extagreementid,
            'projectid' => $this->projectid,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'agreementno', $this->agreementno])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'concat(ps_project.code," - ",ps_project.name)', $this->project])
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
