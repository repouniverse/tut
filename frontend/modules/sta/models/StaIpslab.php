<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_ipslab}}".
 *
 * @property int $id
 * @property int $taller_id
 * @property string $ip
 * @property string $activo
 *
 * @property StaTalleres $taller
 */
class StaIpslab extends \common\models\base\modelBase
{
  public $booleanFields=['activo'];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_ipslab}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['taller_id', 'ip'], 'required'],
            [['taller_id'], 'integer'],
                ['ip', 'unique', 'targetAttribute' => ['ip', 'taller_id'],'message'=>yii::t('sta.labels','Esta Pc ya está registrada, no hay problemas')],
         
            [['ip'], 'string', 'max' => 20],
            [['activo'], 'string', 'max' => 1],
            [['taller_id'], 'exist', 'skipOnError' => true, 'targetClass' =>Talleres::className(), 'targetAttribute' => ['taller_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'taller_id' => Yii::t('sta.labels', 'Taller ID'),
            'ip' => Yii::t('sta.labels', 'Ip'),
            'activo' => Yii::t('sta.labels', 'Activo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaller()
    {
        return $this->hasOne(StaTalleres::className(), ['id' => 'taller_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaIpslabQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaIpslabQuery(get_called_class());
    }
}
