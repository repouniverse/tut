<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\staModule;
use frontend\modules\sta\models\StaDocuAlu;
use common\models\masters\Trabajadores;
use Yii;
 use common\helpers\timeHelper;
/**
 * This is the model class for table "{{%sta_talleresdet}}".
 *
 * @property int $id
 * @property int $talleres_id
 * @property string $codalu
 * @property string $fingreso
 * @property string $detalles
 * @property string $codtra
 *
 * @property StaTalleres $talleres
 * @property StaAlu $codalu0
 */
class Talleresdet extends \common\models\base\modelBase
{
    
    const SCENARIO_BATCH='batch';
    const SCENARIO_PSICO='psico';
    const SCENARIO_TUTOR='tutor';
    
    const CONTACTO_SIN_RESPUESTA='danger';
    const CONTACTO_CON_RESPUESTA='warning';
    const CONTACTO_CON_CITA='success';
    const SCENARIO_PSICO_PSICO='mipsico';
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_talleresdet}}';
    }

     public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_BATCH] = ['talleres_id','codalu','codfac'];
        $scenarios[self::SCENARIO_PSICO] = ['codtra_psico'];
        $scenarios[self::SCENARIO_TUTOR] = ['rank_tutor','detalle_tutor'];
        $scenarios[self::SCENARIO_PSICO_PSICO] = ['codtra'];
       // $scenarios[self::SCENARIO_BATCH] = [ 'codcar', 'ap', 'am', 'nombres', 'dni','domicilio','correo','celulares','fijos'];
       // $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['talleres_id', 'codalu'], 'required'],
            [['talleres_id'], 'integer'],
            [['detalles'], 'string'],
            [['rank_psico','rank_tutor'], 'safe'],
            [['codalu'], 'string', 'max' => 14],
            [['fingreso'], 'string', 'max' => 10],
            [['codtra'], 'string', 'max' => 6],
            [['talleres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleres::className(), 'targetAttribute' => ['talleres_id' => 'id']],
            [['codalu'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::className(), 'targetAttribute' => ['codalu' => 'codalu']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'talleres_id' => Yii::t('sta.labels', 'Talleres ID'),
            'codalu' => Yii::t('sta.labels', 'Codalu'),
            'fingreso' => Yii::t('sta.labels', 'Fingreso'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
            'codtra' => Yii::t('sta.labels', 'Codtra'),
            'detalle_tutor' => Yii::t('sta.labels', 'Detalles'),
            'rank_tutor' => Yii::t('sta.labels', 'Calificación'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalleres()
    {
        return $this->hasOne(Talleres::className(), ['id' => 'talleres_id']);
    }
public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    
     public function getDocumentos()
    {
        return $this->hasMany(StaDocuAlu::className(), ['talleresdet_id' => 'id']);
    }
    
     public function getCitas()
    {
        return $this->hasMany(Citas::className(), ['talleresdet_id' => 'id']);
    }
    
     public function getConvocatorias()
    {
        return $this->hasMany(StaConvocatoria::className(), ['talleresdet_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno()
    {
        return $this->hasOne(Alumnos::className(), ['codalu' => 'codalu']);
    }

    /**
     * {@inheritdoc}
     * @return TalleresdetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TalleresdetQuery(get_called_class());
    }
    
    public function lastCita(){
        
    }
    
    public function tallerPsico(){
       return  Tallerpsico::find()->where(
                [
                    'codtra'=>$this->codtra,
                    //'codtra'=>$this->codtra,
                    'talleres_id'=>$this->talleres_id,
                ]
                )->one();
    }
    /*
     * cREA REGISTROS DE DOCUMENTOS 
     */
    public function generaDocumentos(){
        $codes=staModule::docCodes();
        foreach($codes as $code){
            StaDocuAlu::firstOrCreateStatic([
                'talleresdet_id'=>$this->id,
                'codocu'=>$code,
                 'codfac'=>$this->codfac,
                    ]);
        }
        
        
        
        
        
    }
    
    /*
     * fUNCIONQ UE DEVUELVE EL ESTADO DEL ALUMNO 
     * EN FUNCION DE COMO HA RESPONDIDO A LA CONVOCARTORIA 
     * SUCCESS= ALUMNO YA ASISTIO POR LO MENOS A SU ROIEMRA CITA 
     */
    public function statusContact(){
        if($this->hasFirstCita()){
           return self::CONTACTO_CON_CITA; 
        }else{
          if($this->hasFirstAnswer()){
            return self::CONTACTO_CON_RESPUESTA;   
          }else{
            return self::CONTACTO_SIN_RESPUESTA;     
          }   
        }
    }
    
  public function hasFirstCita(){
     return ($this->getCitas()->andWhere(['asistio'=>'1'])->count() > 0)?true:false; 
  }
  
  public function hasFirstAnswer(){
    return($this->getConvocatorias()->andWhere(['resultado'=>'1'])->count()>0)?true:false; 
  }
  
  public function isNotContacted(){
    return(!$this->hasFirstCita() && !$this->hasFirstAnswer())?true:false;
  }
  
  public function inasistencias(){
      
      return $this->citasPasadasQuery()->
              andWhere(['asistio'=>'0'])->
              count();
  }
  
  public function asistencias(){
      
      return $this->citasPasadasQuery()->
              andWhere(['asistio'=>'1'])->
              count();
  }
  
  public function porcentajeAsistencias(){
      $nasistencias=$this->asistencias();
      $totales=$this->citasPasadasQuery()->count();
      if($totales>0)
      return round((100*($nasistencias/$totales)),0);
      return 0;
  }
  
  private function citasPasadasQuery(){
       $ahora=date(timeHelper::formatMysql());
      return $this->getCitas()->
              andWhere(['<','fechaprog',$ahora]);
  }
  
  public function cambiaPsicologo($nuevo){
      $oldScenario=$this->getScenario();
      $this->setScenario(self::SCENARIO_PSICO_PSICO);
      $this->codtra=$nuevo;
      $this->save();
      $this->talleres->sincronizeCant();
      $this->setScenario($oldScenario);
      
  }
}
