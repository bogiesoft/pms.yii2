<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_term_tbl".
 *
 * @property integer $termid
 * @property string $priod
 * @property string $kdsem
 * @property string $startdate
 * @property string $enddate
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 */
class Term extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_term_tbl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['priod', 'kdsem', 'startdate', 'enddate'], 'required'],
            [['startdate', 'enddate', 'datein', 'dateup'], 'safe'],
            [['priod'], 'string', 'max' => 4],
            [['kdsem'], 'string', 'max' => 1],
            [['userin', 'userup'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'termid' => 'Term ID',
            'priod' => 'Period',
            'kdsem' => 'Term',
            'startdate' => 'Start Date',
            'enddate' => 'End Date',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }
    
    public function getStartDateText(){
        return date("d-M-Y", strtotime($this->startdate));
    }

    public function getEndDateText(){
        return date("d-M-Y", strtotime($this->enddate));
    }
}
