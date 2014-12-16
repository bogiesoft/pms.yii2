<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CostingApproval;

/**
 * CostingApprovalSearch represents the model behind the search form about `app\models\CostingApproval`.
 */
class CostingApprovalSearch extends CostingApproval
{
    public $project;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['costingapprovalid', 'projectid'], 'integer'],
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
    public function search($params, $projectid = 0)
    {
        $query = CostingApproval::find();
        $query->joinWith(['project'])
            ->where(['ps_costingapproval.projectid'=>$projectid])
            ->orderBy([
                    'date'=> SORT_DESC,
                ]);

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
            'costingapprovalid' => $this->costingapprovalid,
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
