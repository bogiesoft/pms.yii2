<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_extdeliverables".
 *
 * @property integer $extdeliverableid
 * @property integer $extagreementid
 * @property string $code
 * @property string $description
 * @property integer $rate
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsExtagreement $extagreement
 * @property PsIntdeliverables[] $psIntdeliverables
 */
class ExtDeliverables extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_extdeliverables';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extagreementid', 'code'], 'required'],
            [['extagreementid', 'rate'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['code'], 'string', 'max' => 5],
            [['description'], 'string', 'max' => 250],
            [['userin', 'userup'], 'string', 'max' => 50],
            [['extagreementid', 'code'], 'unique', 'targetAttribute' => ['extagreementid', 'code'], 'message' => 'The combination of Extagreementid and Code has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'extdeliverableid' => 'Extdeliverableid',
            'extagreementid' => 'Extagreementid',
            'code' => 'Code',
            'description' => 'Description',
            'rate' => 'Rate',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtagreement()
    {
        return $this->hasOne(ExtAgreement::className(), ['extagreementid' => 'extagreementid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsIntdeliverables()
    {
        return $this->hasMany(IntDeliverables::className(), ['extdeliverableid' => 'extdeliverableid']);
    }
}
