<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IntAgreement;

/**
 * IntAgreementSearch represents the model behind the search form about `app\models\IntAgreement`.
 */
class IntAgreementSearch extends IntAgreement
{
    public $extagreement;
    public $consultant;
    public $department;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intagreementid', 'extagreementid', 'consultantid', 'departmentid'], 'integer'],
            [['description', 'startdate', 'enddate', 'filename', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
            [['extagreement','consultant','department'],'safe'],
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
        $query = IntAgreement::find();
        $query->joinWith(['extagreement','consultant','department'])
            ->where(['ps_extagreement.projectid'=>$projectid]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['extagreement'] = [
            'asc'=>['ps_extagreement.description'=>SORT_ASC],
            'desc'=>['ps_extagreement.description'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['consultant'] = [
            'asc'=>['ps_consultant.name'=>SORT_ASC],
            'desc'=>['ps_consultant.name'=>SORT_DESC],            
        ];

        $dataProvider->sort->attributes['department'] = [
            'asc'=>['ps_department.name'=>SORT_ASC],
            'desc'=>['ps_department.name'=>SORT_DESC],
        ];  

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'intagreementid' => $this->intagreementid,
            'extagreementid' => $this->extagreementid,
            'consultantid' => $this->consultantid,
            'departmentid' => $this->departmentid,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'ps_intagreement.description', $this->description])
            ->andFilterWhere(['like', 'ps_intagreement.filename', $this->filename])
            ->andFilterWhere(['like', 'ps_extagreement.description', $this->extagreement])
            ->andFilterWhere(['like', 'ps_consultant.name', $this->consultant])
            ->andFilterWhere(['like', 'ps_department.name', $this->department])
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
