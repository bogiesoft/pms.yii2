<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_intdeliverables".
 *
 * @property integer $intdeliverableid
 * @property integer $intagreementid
 * @property integer $extdeliverableid
 * @property string $code
 * @property integer $positionid
 * @property string $description
 * @property integer $frequency
 * @property integer $rateid
 * @property integer $rate
 * @property string $duedate 
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsIntagreement $intagreement
 * @property PsExtdeliverables $extdeliverable
 * @property PsConsultantposition $position
 * @property PsProjectrate $rate0
 */
class IntDeliverables extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_intdeliverables';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intagreementid', 'extdeliverableid', 'code', 'positionid', 'frequency', 'rateid', 'rate', 'description', 'duedate'], 'required'],
            [['intagreementid', 'extdeliverableid', 'positionid', 'frequency', 'rateid', 'rate'], 'integer'],
            [['datein', 'dateup', 'duedate'], 'safe'],
            [['code'], 'string', 'max' => 5],
            [['description'], 'string', 'max' => 250],
            [['userin', 'userup'], 'string', 'max' => 50],
            [['intagreementid', 'code'], 'unique', 'targetAttribute' => ['intagreementid', 'code'], 'message' => 'The combination of Intagreementid and Code has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intdeliverableid' => 'Intdeliverableid',
            'intagreementid' => 'Intagreementid',
            'extdeliverableid' => 'External Deliverable',
            'code' => 'Number',
            'positionid' => 'Consultant Position',
            'description' => 'Deliverable Name',
            'frequency' => 'Frequency',
            'rateid' => 'Rate Unit',
            'rate' => 'Rate',
            'duedate' => 'Due Date', 
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntagreement()
    {
        return $this->hasOne(IntAgreement::className(), ['intagreementid' => 'intagreementid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtdeliverables()
    {
        return $this->hasOne(ExtDeliverables::className(), ['extdeliverableid' => 'extdeliverableid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultantposition()
    {
        return $this->hasOne(ConsultantPosition::className(), ['positionid' => 'positionid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectrate()
    {
        return $this->hasOne(ProjectRate::className(), ['rateid' => 'rateid']);
    }
}
