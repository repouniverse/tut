<?php

namespace frontend\modules\avisos\models;

use Yii;
use common\helpers\h;
/**
 * This is the model class for table "{{%avisos_tablon}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $finicio
 * @property string $ftermino
 * @property string $texto
 * @property string $texto_interno
 * @property string $esevento
 * @property string $activo
 * @property int $periodo
 * @property int $user_admin
 */
class AvisosTablon extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%avisos_tablon}}';
    }
public $booleanFields=['esevento', 'activo'];
 public $dateorTimeFields=[
        //'fechaprog'=>self::_FDATETIME,
         'finicio'=>self::_FDATETIME,
        'ftermino'=>self::_FDATETIME
    ];
 public function behaviors()
         {
                return [
		
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
       
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['finicio', 'ftermino'], 'required'],
            [['user_id', 'periodo', 'user_admin'], 'integer'],
            [['texto', 'texto_interno'], 'string'],
            [['finicio', 'ftermino'], 'string', 'max' => 19],
            //[['esevento', 'activo'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'user_id' => Yii::t('base.names', 'User ID'),
            'finicio' => Yii::t('base.names', 'Finicio'),
            'ftermino' => Yii::t('base.names', 'Ftermino'),
            'texto' => Yii::t('base.names', 'Texto'),
            'texto_interno' => Yii::t('base.names', 'Texto Interno'),
            'esevento' => Yii::t('base.names', 'Esevento'),
            'activo' => Yii::t('base.names', 'Activo'),
            'periodo' => Yii::t('base.names', 'Periodo'),
            'user_admin' => Yii::t('base.names', 'User Admin'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AvisosTablonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AvisosTablonQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        $this->user_id=h::userId();
        $this->user_admin=h::userId(h::gsetting('avisos','userAdministrador'));
        return parent::beforeSave($insert);
    }
    
    
    public function isMyAviso(){
        return ($this->user_id==h::userId());
    }
    
    public function IAmAdminThisAviso(){
        return (h::userId()==h::userId(h::gsetting('avisos','userAdministrador')));
    }
    
    public function IsCurrent(){
        return (self::CarbonNow()->between(
                $this->toCarbon('finicio'),
                 $this->toCarbon('ftermino')
                )  && $this->activo);
    }
}
