<?php

namespace frontend\modules\sta\models;
use common\behaviors\FileBehavior;
use frontend\modules\access\models\modelSensibleAccess;
use Yii;

/**
 * This is the model class for table "{{%sta_examenes}}".
 *
 * @property int $id
 * @property int $citas_id
 * @property string $codtest
 * @property string $detalles
 *
 * @property StaTest $codtest0
 * @property StaCitas $citas
 */
class Examenes extends modelSensibleAccess
{
    /**
     * {@inheritdoc}
     */
    public $dateorTimeFields=['fnotificacion'=>self::_FDATETIME];
    public $booleanFields=['virtual'];
    public static function tableName()
    {
        return '{{%sta_examenes}}';
    }

    
    public function behaviors()
            {
	return [
		
		'fileBehavior' => [
			'class' => FileBehavior::className()
		]
		
                ];
            }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['citas_id', 'codtest'], 'required'],
            [['citas_id'], 'integer'],
             [['fnotificacion','virtual','codfac','reporte_id'],'safe'],
            [['detalles'], 'string'],
            [['codtest'], 'string', 'max' => 8],
            [['codtest'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['codtest' => 'codtest']],
            [['citas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Citas::className(), 'targetAttribute' => ['citas_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'citas_id' => Yii::t('sta.labels', 'Citas ID'),
            'codtest' => Yii::t('sta.labels', 'Codtest'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['codtest' => 'codtest']);
    }
    
    public function getTestTalleres()
    {
     // var_dump($this->cita->tallerdet->id);/*talleres->id);*/die();
        return  StaTestTalleres::find()->where(
                ['codtest' => $this->codtest,
            'taller_id' => $this->cita->talleres_id,
            ])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCita()
    {
        return $this->hasOne(Citas::className(), ['id' => 'citas_id']);
    }
    
    public function getExamenesDet()
    {
        return $this->hasMany(StaExamenesdet::className(), ['examenes_id' => 'id']);
    }
    public function getResultados()
    {
        return $this->hasMany(StaResultados::className(), ['examenes_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ExamenesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExamenesQuery(get_called_class());
    }
    
    public static function findFree()
    {
        return new ExamenesQueryFree(get_called_class());
    }
    
      //yii:error('creando token');
  public function notificaMail(){
      $token=  \common\components\token\Token::create('citas', 'token_examen', null, time()+60*2);
      
   
  }
   
  /*
   * Esta funcion crea los registros detalles del
   * Examen psicologico, creando registros del 
   * la tabl 'examenesdet', copiando de la tabla 'testdet'
   */
  public function creaExamen(){
      $valor=false;
      $detalles=$this->test->testdets;
    //var_dump($this->test);die();
      foreach($detalles as $detalle){
          yii::error('recorreindo '.$detalle->pregunta);
           $attributos=[
          'examenes_id'=>$this->id,
           'codfac'=>$this->codfac,
          'test_id'=>$detalle->id,
          'indicador_id'=>$detalle->indicadorId(),
                   ];
      $valor=StaExamenesdet::firstOrCreateStatic($attributos, StaExamenesdet::SCENARIO_MIN );
       if($valor===false){
           yii::error('fallo');
           $mimodelo=new StaExamenesdet();
           $mimodelo->setScenario(StaExamenesdet::SCENARIO_MIN);
           $mimodelo->setAttributes($attributos);
           $mimodelo->validate();
           yii::error($mimodelo->getErrors());
           break;
       }

      }
     return $valor;
  }  
  
  
  public function npreguntas(){
     return count($this->getExamenesDet()->asArray()->all());
  }
  
 public function porcentajeAvance(){
     $respondidas=$this->getExamenesDet()
             ->andWhere(['not',['valor'=>null]])->count();
     $totales=$this->npreguntas();
     //return random_int(20, 99);
     if($totales>0){
        return round((100*$respondidas/$totales),1); 
     }
     return 0;
 }
  
 public function puntaje(){
     return $this->getExamenesDet()->select('sum(puntaje)')->scalar();
 }
 
 
 
 
 /*
  * rellena los puntajes de todas las respuestas
  * hijas
  */
 public function makePuntaje(){
     $test=$this->test;
     $arrayCalificaciones=$test->arrayRawCalificaciones();unset($test);
    // print_r($arrayCalificaciones);die();
     //echo count($this->examenesDet); die();
     foreach($this->examenesDet as $detalle){
         $detalle->setPuntaje($arrayCalificaciones);
     }
   return true;  
     
 }
 
 public function makeResultados(){
     $valor=true;
  if($this->porcentajeAvance() >=100){
       $this->makePuntaje();
   $detalles=$this->getExamenesDet()
    ->select(['examenes_id','indicador_id','sum(puntaje) as puntajetotal'])
    ->groupBy(['examenes_id','indicador_id'])->asArray()->all();
   yii::error('Sql del RESUMEN');
     yii::error($this->getExamenesDet()
    ->select(['examenes_id','indicador_id','sum(puntaje) as puntajetotal'])
    ->groupBy(['examenes_id','indicador_id'])->createCommand()->getRawSql());
   foreach($detalles as $detalle){
       //$indicador= StaTestindicadores::findOne($detalle['indicador_id']);
       $percentil= StaPercentiles::find()->where([
         'indicador_id'=> $detalle['indicador_id'],
          'puntaje'=>$detalle['puntajetotal']
       ])->one();
       yii::error('Sql del percentil');
       yii::error(StaPercentiles::find()->where([
         'indicador_id'=> $detalle['indicador_id'],
          'puntaje'=>$detalle['puntajetotal']
       ])->createCommand()->getRawSql());
       if(is_null($percentil)){
        yii::error('No se encontró el percentil');   
       }
       //yii::error($detalle['puntajetotal']);
        $attributos=[
          'examen_id'=>$detalle['examenes_id'],
           'indicador_id'=>$detalle['indicador_id'],
           'codfac'=>$this->codfac,
          'puntaje_total'=>$detalle['puntajetotal'],
          'percentil'=>$percentil->percentil,
           'categoria'=>$percentil->categoria, 
           'interpretacion'=>$percentil->indicador->interpretacion(trim($percentil->categoria)),
                   ];
        
        $valor= StaResultados::firstOrCreateStatic(
                $attributos,
                null,
                [ 'examen_id'=>$detalle['examenes_id'],'indicador_id'=>$detalle['indicador_id']]
                );
       if($valor===false){
           yii::error('Fallo y estos son los errores : ');
           $mimodelo=new StaResultados();
           //$mimodelo->setScenario(StaResultados::SCENARIO_MIN);
           $mimodelo->setAttributes($attributos);
           $mimodelo->validate();
           yii::error($mimodelo->getErrors());
           break;
       }
        
   }
   return $valor;
      
  }else{
      return false;
  }
  
 }
 

 
}
