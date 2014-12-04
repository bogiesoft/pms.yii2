<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proposal;

/**
 * ProposalSearch represents the model behind the search form about `app\models\Proposal`.
 */
class ProposalSearch extends Proposal
{
    public $project;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proposalid', 'projectid'], 'integer'],            
            [['date', 'remark', 'filename', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
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
        $query = Proposal::find();
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
            'proposalid' => $this->proposalid,
            'projectid' => $this->projectid,
            'date' => $this->date,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'remark', $this->remark])            
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'concat(ps_project.code," - ",ps_project.name)', $this->project])
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
