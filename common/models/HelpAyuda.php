<?php
use common\behaviors\FileBehavior;
namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%help_ayuda}}".
 *
 * @property int $id
 * @property string $tipo
 * @property int $user_id
 * @property string $fecha_hora
 * @property string $problema
 * @property string $ruta
 * @property string $detalles
 * @property string $respuesta
 * @property string $cerrado
 * @property string $satisfaccion
 * @property string $codocu
 * @property string $fecha_respuesta
 */
class HelpAyuda extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%help_ayuda}}';
    }

     public $dateorTimeFields=[
        'fecha_hora'=>self::_FDATETIME,
         'fecha_respuesta'=>self::_FDATETIME,
       // 'ftermino'=>self::_FDATETIME
    ];    
   public $booleanFields=['cerrado'];
    public $prefijo='67';
    public $usuario='';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['fecha_hora', 'tipo','problema'], 'required'],
            [['detalles', 'respuesta','ticket'], 'string'],
            [['tipo'], 'string', 'max' => 3],
            [['fecha_hora', 'fecha_respuesta'], 'string', 'max' => 19],
            [['problema', 'ruta'], 'string', 'max' => 40],
            //[['cerrado', 'satisfaccion'], 'string', 'max' => 1],
            [['codocu'], 'string', 'max' => 4],
        ];
    }

  public function behaviors()
         {
                return [
		'fileBehavior' => [
			'class' => '\common\behaviors\FileBehavior'
		],
		  'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }  
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'tipo' => Yii::t('base.names', 'Tipo'),
            'user_id' => Yii::t('base.names', 'Usuario'),
            'fecha_hora' => Yii::t('base.names', 'Fecha'),
            'problema' => Yii::t('base.names', 'Problema'),
            'ruta' => Yii::t('base.names', 'Ruta'),
            'detalles' => Yii::t('base.names', 'Detalles'),
            'respuesta' => Yii::t('base.names', 'Respuesta'),
            'cerrado' => Yii::t('base.names', 'Cerrado'),
            'satisfaccion' => Yii::t('base.names', 'Satisfacción'),
            'codocu' => Yii::t('base.names', 'Cod. Doc'),
            'fecha_respuesta' => Yii::t('base.names', 'Fecha Resp'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return HelpAyudaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HelpAyudaQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->ticket=$this->correlativo('ticket');
            $this->user_id=\common\helpers\h::userId();
            $this->codocu='547';
        }
        return parent::beforeSave($insert);
    }
}
