<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\staModule;
USE frontend\modules\sta\models\Talleresdet;
use Yii;
 use common\helpers\timeHelper;

/**
 * This is the model class for table "{{%vw_alutaller}}".
 *
 * @property string $ap
 * @property string $am
 * @property string $nombres
 * @property string $codfac
 * @property string $dni
 * @property string $correo
 * @property string $celulares
 * @property string $fijos
 * @property int $id
 * @property string $codalu
 * @property int $talleres_id
 * @property string $fingreso
 * @property string $codtra
 */
class VwAlutaller extends \common\models\base\modelBase
{
    public $extraMethodsToReport=['reportTitulo','reportPrograma','reportPsicologo'];
    
    
    /**
     * {@inheritdoc}
     */
     public $dateorTimeFields=[
        'fecna'=>self::_FDATE,
       
        ];
    public $dateOrTimeFields=['fecna'];
    public static function tableName()
    {
        return '{{%vw_alutaller}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'talleres_id'], 'integer'],
            [['codalu', 'talleres_id'], 'required'],
            [['ap', 'am', 'nombres'], 'string', 'max' => 40],
            [['codfac'], 'string', 'max' => 8],
            [['dni'], 'string', 'max' => 12],
            [['correo'], 'string', 'max' => 54],
            [['celulares'], 'string', 'max' => 23],
            [['fijos', 'codalu'], 'string', 'max' => 14],
            [['fingreso'], 'string', 'max' => 10],
            [['codtra'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ap' => Yii::t('sta.labels', 'Ap'),
            'am' => Yii::t('sta.labels', 'Am'),
            'nombres' => Yii::t('sta.labels', 'Nombres'),
            'codfac' => Yii::t('sta.labels', 'Fac'),
            'dni' => Yii::t('sta.labels', 'DNI'),
            'correo' => Yii::t('sta.labels', 'Correo'),
            'celulares' => Yii::t('sta.labels', 'Celulares'),
            'fijos' => Yii::t('sta.labels', 'Fijos'),
            'id' => Yii::t('sta.labels', 'ID'),
            'codalu' => Yii::t('sta.labels', 'Código'),
            'talleres_id' => Yii::t('sta.labels', 'Talleres ID'),
            'fingreso' => Yii::t('sta.labels', 'Fingreso'),
            'codtra' => Yii::t('sta.labels', 'Psicólogo'),
             'nomcur' => Yii::t('sta.labels', 'Curso'),
             'rank_tutor' => Yii::t('sta.labels', 'Calif'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwAlutallerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwAlutallerQuery(get_called_class());
    }
    
    public function getUrlImage(){
       if($this->hasAttachments()){        
           return $this->files[0]->getUrl();
       }else{
           return staModule::getPathImage($this->codalu);        
       }
    }
    
    public static function claseBase(){
        return 'frontend\modules\sta\models\Talleresdet';
    }
    
    public function getPrimaryKey($asArray = false) {
        return 'id';
        parent::getPrimaryKey($asArray);
        
    }
    /*
     * fUNCIONQ UE DEVUELVE EL ESTADO DEL ALUMNO 
     * EN FUNCION DE COMO HA RESPONDIDO A LA CONVOCARTORIA 
     * SUCCESS= ALUMNO YA ASISTIO POR LO MENOS A SU ROIEMRA CITA 
     */
    public function statusContact(){
        if($this->hasFirstCita()){
           return Talleresdet::CONTACTO_CON_CITA; 
        }else{
          if($this->hasFirstAnswer()){
            return Talleresdet::CONTACTO_CON_RESPUESTA;   
          }else{
            return Talleresdet::CONTACTO_SIN_RESPUESTA;     
          }   
        }
    }
    
    public function getPrograma(){
        return Talleres::find()->where(['id'=>$this->talleres_id])->one();
    }
    
    
  public function getCitas()
    {
        return Citas::find()->where(['talleresdet_id' => $this->id]);
    }
    
     public function getConvocatorias()
    {
        return StaConvocatoria::find()->where(['talleresdet_id' => $this->id]);
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
  
 public function getReportTitulo(){        
      return 'LISTADO DE ALUMNOS POR PSICOLOGO ';
    }
  public function getReportPrograma(){        
      return $this->getPrograma()->descripcion ;
    }
  public function getReportPsicologo(){        
      return \common\models\masters\Trabajadores::find(['codigotra'=>$this->codtra])->one()->fullname() ;
    }
}
