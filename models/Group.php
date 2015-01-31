<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_group".
 *
 * @property integer $groupid
 * @property string $name
 * @property string $description
 * @property string $active
 *
 * @property PsGroupaccess[] $psGroupaccesses
 * @property PsGroupaccessdata[] $psGroupaccessdatas
 * @property PsGroupuser[] $psGroupusers
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_group';
    }

    public $varActive;

    public function getactiveText(){
        if ($this->active == "1"){
            return "Yes";
        }else{
            return "No";
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 250],
            [['active'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'groupid' => 'Groupid',
            'name' => 'Name',
            'description' => 'Description',
            'active' => 'Active',
            'varActive' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsGroupaccesses()
    {
        return $this->hasMany(PsGroupaccess::className(), ['groupid' => 'groupid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupaccessdatas()
    {
        return $this->hasMany(GroupAccessData::className(), ['groupid' => 'groupid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsGroupusers()
    {
        return $this->hasMany(PsGroupuser::className(), ['groupid' => 'groupid']);
    }

}
