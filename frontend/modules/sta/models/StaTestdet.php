<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_testdet}}".
 *
 * @property int $id
 * @property string $codtest
 * @property string $item
 * @property string $grupo
 * @property string $pregunta
 * @property string $detalles
 *
 * @property StaTest $codtest0
 */
class StaTestdet extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public $booleanFields=['inversa'];
    
    public static function tableName()
    {
        return '{{%sta_testdet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtest', 'item', 'grupo', 'pregunta'], 'required'],
            [['detalles'], 'string'],
             [['inversa'], 'safe'],
            [['codtest'], 'string', 'max' => 8],
            [['item'], 'string', 'max' => 3],
            [['grupo'], 'string', 'max' => 2],
            [['pregunta'], 'string', 'max' => 300],
            [['codtest'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['codtest' => 'codtest']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codtest' => Yii::t('app', 'Codtest'),
            'item' => Yii::t('app', 'Item'),
            'grupo' => Yii::t('app', 'Grupo'),
            'pregunta' => Yii::t('app', 'Pregunta'),
            'detalles' => Yii::t('app', 'Detalles'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['codtest' => 'codtest']);
    }

    /**
     * {@inheritdoc}
     * @return StaTestdetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaTestdetQuery(get_called_class());
    }
    /*
     * Calcula el puntaje de la pregunta 
     * recibe como parametros  la respueta y el 
     * array unidimensional de calificaciones [0,1,2,3,4,5,6,7]
     * del examen
     */
    public function puntaje($respuesta,$arrayCalificaciones){
        if($this->inversa){
           // echo "fue inversa<br>";
            $array2=$arrayCalificaciones;
            rsort($array2);
            $arrayTotal= array_combine($arrayCalificaciones, $array2);
          return  $arrayTotal[$respuesta];
          
        }else{
            return $respuesta;
        }
        /*echo "respuesta ".$respuesta."<br>";
            echo "ID ".$this->id."<br>";
            echo "INDICE ".array_search($respuesta,$arrayCalificaciones)."<br>";
            echo "RESULTADO ".$arrayCalificaciones[array_search($respuesta,$arrayCalificaciones)]."<br>";
         */   
       
        
    }
    
    public function indicadorId(){
       return $this->test->indicadorId($this->grupo);
    }
}
