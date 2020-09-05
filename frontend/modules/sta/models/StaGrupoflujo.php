<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\components\Indicadores;
use Yii;

/**
 * This is the model class for table "{{%sta_grupoflujo}}".
 *
 * @property int $id
 * @property string $desgrupo
 * @property int $peso
 * @property string $clase
 * @property string $codperiodo
 */
class StaGrupoflujo extends \common\models\base\modelBase
{
     public $booleanFields=['evaluacion','esevento'];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_grupoflujo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peso'], 'integer'],
            [['desgrupo'], 'string', 'max' => 40],
            [['clase'], 'string', 'max' => 1],
            [['codperiodo'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.labels', 'ID'),
            'desgrupo' => Yii::t('base.labels', 'Desgrupo'),
            'peso' => Yii::t('base.labels', 'Peso'),
            'clase' => Yii::t('base.labels', 'Clase'),
            'codperiodo' => Yii::t('base.labels', 'Codperiodo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return StaGrupoflujoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaGrupoflujoQuery(get_called_class());
    }
    
    public function porcAvance($codperiodo=null,$codfac=null,$codtra=null){
       
        /*Caluclando el porcentaje de la evaluaion inicial*/
$totalAlumnos= Indicadores::ntotalAlumnosPrograma($codperiodo,$codfac,$codtra);





if($totalAlumnos==0)
               return 0;
        /*Si s e trata de una evañluacion*/
        if($this->esevento && $this->evaluacion){
             $exp= Indicadores::expresionColumna();
              $query=\frontend\modules\sta\models\StaResumenasistencias::
                     find()->where(['codperiodo'=> Indicadores::codperiodo($codperiodo)]);
             if(!is_null($codfac)){
                    $query->andWhere(['codfac'=>$codfac]);
                }
            if(!is_null($codtra)){
                    $query->andWhere(['codtra'=>$codtra]);
                }
            $examenes=$query->select(['count(c_1) as nexam'])->andWhere($exp)->count();
            $informes=$query->select(['count(n_informe) as ninforme'])->andWhere(['>=','n_informe',3])->count();
 
                $examenes1=$query->select(['count(ev_f) as nexam'])->andWhere(['not',['ev_f'=>null]])->count();
                $informes1=$query->select(['count(n_informe) as ninforme'])->andWhere(['>=','n_informe',3])->count();
 
             if($this->orden ==1 ){
                /* echo "Total alumnos ".$totalAlumnos."<br>";
                 echo "Informes ".$informes."<br>";
                  echo "Examenes ".$examenes."<br>";*/
                 return round(($examenes/$totalAlumnos+$informes*2/$totalAlumnos)/3,3);
           
             }else{
                return round(($examenes1/$totalAlumnos+$informes1*2/$totalAlumnos)/3,3);
            
             }
               
        }else{
            $idsFlujos=StaFlujo::find()->select(['actividad'])->
           andWhere(['gactividad'=>$this->id])->column();
           $queryCitas=Citas::find()->andWhere(['flujo_id'=>$idsFlujos,
               'asistio'=>'1','activo'=>'1']);
             if(!is_null($codfac)){
                    $queryCitas->andWhere(['codfac'=>$codfac]);
                }
            if(!is_null($codtra)){
                    $queryCitas->andWhere(['codtra'=>$codtra]);
                }
           $ncitas=$queryCitas->count();
            /*echo "Total citas hechas ".$ncitas."<br>";
                 echo "Total citas por hacer ".$totalAlumnos*$this->nsesiones."<br>";
              echo "Total alumnos  ".$totalAlumnos."<br>";
              echo "n esiosnes  ".$this->nsesiones."<br>";*/
         if($this->nsesiones==0)return 0;
          return round($ncitas/($totalAlumnos*$this->nsesiones),3);
            
        }
     }
     
   public static function pesoTotal($codperiodo=null){
       $queryPeso=self::find()->select(['sum(peso) as speso'])->where([
         'codperiodo'=> Indicadores::codperiodo($codperiodo)
               ]
               );
       return $queryPeso->scalar();
   }
   
   public static function porcTotal($codperiodo,$codfac=null,$codtra=null){
      $registros= self::find()->where([
         'codperiodo'=> $codperiodo
               ])->all();
      $sumatoria=0;
      foreach($registros as $registro){
          $sumatoria+=$registro->peso*$registro->porcAvance($codperiodo, $codfac,$codtra);
      }
      return round($sumatoria/self::pesoTotal($codperiodo),3);
   }
   
}


