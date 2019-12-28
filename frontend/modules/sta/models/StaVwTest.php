<?php

namespace frontend\modules\sta\models;

use Yii;
use frontend\modules\sta\traits\testTrait;
use frontend\modules\sta\models\Test;
/**
 * This is the model class for table "{{%vw_sta_test}}".
 *
 * @property string $item
 * @property string $pregunta
 * @property string $codtest
 * @property string $descripcion
 * @property string $opcional
 * @property string $version
 * @property int $nveces
 * @property int $id
 */
class StaVwTest extends \common\models\base\modelBase
{
   use testTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sta_test}}';
    }

    
    public function init(){
        //$this->extraMethods;
       // var_dump(count($this->calificaciones()));die();
        $this->extraMethodsToReport= array_slice(
                $this->extraMethods,
                count($this->calificaciones()));
        $this->extraMethodsToReport= array_merge($this->extraMethodsToReport,
                ['reportCalificaciones']);
        parent::init();
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item', 'pregunta', 'codtest', 'descripcion', 'opcional', 'version'], 'required'],
            [['nveces', 'id'], 'integer'],
            [['item'], 'string', 'max' => 3],
            [['pregunta'], 'string', 'max' => 300],
            [['codtest'], 'string', 'max' => 8],
            [['descripcion'], 'string', 'max' => 40],
            [['opcional'], 'string', 'max' => 1],
            [['version'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item' => Yii::t('app', 'Item'),
            'pregunta' => Yii::t('app', 'Pregunta'),
            'codtest' => Yii::t('app', 'Codtest'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'opcional' => Yii::t('app', 'Opcional'),
            'version' => Yii::t('app', 'Version'),
            'nveces' => Yii::t('app', 'Nveces'),
            'id' => Yii::t('app', 'ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return StaVwTestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaVwTestQuery(get_called_class());
    }
    public function calificaciones(){
      /* echo  Test::find()->select('valor','descripcion')
                ->where(['[[codtest]]'=>$this->codtest])->orderBy('valor ASC')
               ->createCommand()->getRawSql();die();*/
        $data=Test::find()->select('valor','descripcion')
                ->where(['[[codtest]]'=>$this->codtest])->orderBy('valor ASC')
               ->asArray()->all();
      return array_column($data,'valor');
    }
    
    public function getReportCalificaciones(){
        $controller=Yii::$app->controller;
        $nameView= \common\helpers\FileHelper::getShortName($this::className());
        $pathView='/'.$controller->id.'/reports/'.$nameView.'/calificaciones';
      return  $controller->getView()->render($pathView,['model'=>$this]);
    }
}
