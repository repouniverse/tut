<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%vw_sta_examenes}}".
 *
 * @property int $idexamen
 * @property int $citas_id
 * @property string $detalles
 * @property string $codfac
 * @property int $user_id
 * @property string $virtual
 * @property string $fnotificacion
 * @property int $id
 * @property int $test_id
 * @property int $examenes_id
 * @property int $valor
 * @property string $item
 * @property string $pregunta
 * @property string $grupo
 * @property string $desdocu
 * @property string $codtest
 * @property string $descripcion
 * @property string $opcional
 * @property string $codocu
 * @property int $reporte_id
 * @property int $nveces
 */
class VwStaExamenes extends \common\models\base\modelBase
{
   public $extraMethodsToReport=['reportCalificaciones'];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sta_examenes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idexamen', 'citas_id', 'user_id', 'id', 'test_id', 'examenes_id', 'valor', 'reporte_id', 'nveces'], 'integer'],
            [['citas_id', 'test_id', 'examenes_id', 'item', 'pregunta', 'grupo', 'desdocu', 'codtest', 'descripcion', 'opcional'], 'required'],
            [['detalles'], 'string'],
            [['codfac', 'codtest'], 'string', 'max' => 8],
            [['virtual', 'opcional'], 'string', 'max' => 1],
            [['fnotificacion'], 'string', 'max' => 20],
            [['item', 'codocu'], 'string', 'max' => 3],
            [['pregunta'], 'string', 'max' => 300],
            [['grupo'], 'string', 'max' => 2],
            [['desdocu'], 'string', 'max' => 60],
            [['descripcion'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idexamen' => Yii::t('sta.labels', 'Idexamen'),
            'citas_id' => Yii::t('sta.labels', 'Citas ID'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
            'codfac' => Yii::t('sta.labels', 'Codfac'),
            'user_id' => Yii::t('sta.labels', 'User ID'),
            'virtual' => Yii::t('sta.labels', 'Virtual'),
            'fnotificacion' => Yii::t('sta.labels', 'Fnotificacion'),
            'id' => Yii::t('sta.labels', 'ID'),
            'test_id' => Yii::t('sta.labels', 'Test ID'),
            'examenes_id' => Yii::t('sta.labels', 'Examenes ID'),
            'valor' => Yii::t('sta.labels', 'Valor'),
            'item' => Yii::t('sta.labels', 'Item'),
            'pregunta' => Yii::t('sta.labels', 'Pregunta'),
            'grupo' => Yii::t('sta.labels', 'Grupo'),
            'desdocu' => Yii::t('sta.labels', 'Desdocu'),
            'codtest' => Yii::t('sta.labels', 'Codtest'),
            'descripcion' => Yii::t('sta.labels', 'Descripcion'),
            'opcional' => Yii::t('sta.labels', 'Opcional'),
            'codocu' => Yii::t('sta.labels', 'Codocu'),
            'reporte_id' => Yii::t('sta.labels', 'Reporte ID'),
            'nveces' => Yii::t('sta.labels', 'Nveces'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwStaExamenesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwStaExamenesQuery(get_called_class());
    }
     public static function findFree()
    {
        return new VwStaExamenesQueryFree(get_called_class());
    }
    
    public function getTest(){
        return Test::findOne($this->codtest);
    }
    
    public function getReportCalificaciones(){  
       $controller=Yii::$app->controller;
        $nameView= \common\helpers\FileHelper::getShortName($this::className());
        $pathView='/'.$controller->id.'/reports/'.$nameView.'/calificaciones';
      return  $controller->getView()->render($pathView,['model'=>$this]);
    }
    
}
