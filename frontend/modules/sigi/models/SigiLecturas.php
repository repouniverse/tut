<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_lecturas}}".
 *
 * @property int $id
 * @property int $suministro_id
 * @property int $unidad_id
 * @property string $codepa
 * @property string $mes
 * @property string $flectura
 * @property string $hlectura
 * @property string $lectura
 * @property string $lecturaant
 * @property string $delta
 *
 * @property SigiSuministros $suministro
 */
class SigiLecturas extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_lecturas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['suministro_id', 'unidad_id', 'mes'], 'required'],
            [['suministro_id', 'unidad_id'], 'integer'],
            [['lectura', 'lecturaant', 'delta'], 'number'],
             [['lectura', 'valida_lectura'], 'number'],
            [['codepa'], 'string', 'max' => 12],
            [['mes'], 'string', 'max' => 2],
            [['flectura'], 'string', 'max' => 10],
            [['hlectura'], 'string', 'max' => 5],
            [['suministro_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiSuministros::className(), 'targetAttribute' => ['suministro_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'suministro_id' => Yii::t('sigi.labels', 'Suministro ID'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'codepa' => Yii::t('sigi.labels', 'Codepa'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'flectura' => Yii::t('sigi.labels', 'Flectura'),
            'hlectura' => Yii::t('sigi.labels', 'Hlectura'),
            'lectura' => Yii::t('sigi.labels', 'Lectura'),
            'lecturaant' => Yii::t('sigi.labels', 'Lecturaant'),
            'delta' => Yii::t('sigi.labels', 'Delta'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuministro()
    {
        return $this->hasOne(SigiSuministros::className(), ['id' => 'suministro_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiLecturasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiLecturasQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
      if($insert)
        $this->lecturaant=$this->lastReadNumeric(); 
      if($this->hasChanged('lectura'))
           $this->delta=$this->lectura-$this->lastReadNumeric();        
        RETURN parent::beforeSave($insert);
    }
    
    
    public function rawSuministro(){
        return ($this->isNewRecord)?SigiSuministros::findOne($this->suministro_id):
           $this->suministro ;
    }
   
    
    public function lastReadNumeric(){
        $ll=$this->rawSuministro()->lastRead();
       return (is_null($ll))?0:$ll->lectura;
    }
    
     public function valida_lectura($attribute, $params)
    {
      if($this->lastReadNumeric() > $this->lectura){
          $this->addError('lecura','Este valor es menor que la última lectura {\'ultimalectura\'}',['ultimalectura'=>$this->lastReadNumeric()]);
      }
     } 
}
