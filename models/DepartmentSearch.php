<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Department;

/**
 * DepartmentSearch represents the model behind the search form about `app\models\Department`.
 */
class DepartmentSearch extends Department
{
    public $faculty;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['departmentid', 'facultyid'], 'integer'],
            [['name', 'datein', 'userin', 'dateup', 'userup'], 'safe'],
            [['faculty'],'safe'],
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
        $query = Department::find();
        $query->joinWith(['faculty']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['faculty'] = [
            'asc'=>['concat(ps_faculty.code," - ",ps_faculty.name)'=>SORT_ASC],
            'desc'=>['concat(ps_faculty.code," - ",ps_faculty.name)'=>SORT_DESC],            
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'departmentid' => $this->departmentid,
            'facultyid' => $this->facultyid,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        
        $query->andFilterWhere(['like', 'ps_department.name', $this->name])
            ->andFilterWhere(['like', 'concat(ps_faculty.code, " - ",ps_faculty.name)', ($this->faculty)])
            ->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
