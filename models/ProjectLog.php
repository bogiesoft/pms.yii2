<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_projectlog".
 *
 * @property integer $projectlogid
 * @property integer $projectid
 * @property string $date
 * @property string $status
 * @property string $remark
 * @property string $datein
 * @property string $userin
 */
class ProjectLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_projectlog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectid', 'date', 'status', 'remark'], 'required'],
            [['projectid'], 'integer'],
            [['date', 'datein'], 'safe'],
            [['status'], 'string', 'max' => 100],
            [['remark'], 'string', 'max' => 500],
            [['userin'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'projectlogid' => 'Projectlogid',
            'projectid' => 'Projectid',
            'date' => 'Date',
            'status' => 'Status',
            'remark' => 'Remark',
            'datein' => 'Datein',
            'userin' => 'Userin',
        ];
    }
}
