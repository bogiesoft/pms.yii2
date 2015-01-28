<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SharingValueDepartment;

/**
 * SharingValueSearch represents the model behind the search form about `app\models\SharingValueDepartment`.
 */
class SharingValueSearch extends SharingValueDepartment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sharingvaluedepartmentid', 'projectid', 'departmentid', 'value'], 'integer'],
            [['datein', 'userin', 'dateup', 'userup'], 'safe'],
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
        $query = SharingValueDepartment::find();

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
            'sharingvaluedepartmentid' => $this->sharingvaluedepartmentid,
            'projectid' => $this->projectid,
            'departmentid' => $this->departmentid,
            'value' => $this->value,
            'datein' => $this->datein,
            'dateup' => $this->dateup,
        ]);

        $query->andFilterWhere(['like', 'userin', $this->userin])
            ->andFilterWhere(['like', 'userup', $this->userup]);

        return $dataProvider;
    }
}
