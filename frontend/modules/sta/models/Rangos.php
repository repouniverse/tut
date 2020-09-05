<?php

namespace frontend\modules\sta\models;
use common\helpers\h;
use common\models\masters\Trabajadores;
USE \yii2mod\settings\models\enumerables\SettingType;
use Yii;
use common\helpers\RangeDates;
/**
 * This is the model class for table "{{%sta_rangos}}".
 *
 * @property int $id
 * @property int $talleres_id
 * @property int $dia
 * @property string $hinicio
 * @property string $hfin
 * @property int $tolerancia
 *
 * @property StaTalleres $talleres
 */
class Rangos extends \common\models\base\modelBase 
implements \common\interfaces\rangeInterface
{
    use  \common\traits\timeTrait;
   const SCENARIO_HORAS='horas';
    public $booleanFields=['activo','skipferiado'];
    public $dateorTimeFields=[
        'hinicio'=>self::_FHOUR,
        'hfin'=>self::_FHOUR];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_rangos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['talleres_id', 'dia', 'hinicio', 'hfin', 'tolerancia','nombredia'], 'required'],
            [['talleres_id', 'dia'], 'integer'],
            [['skipferiado','dia'], 'safe'],
            /*['codtra', 'unique', 'targetAttribute' => 
                 ['codtra','dia', 'codperiodo','codfac'],
              'message'=>yii::t('sta.errors',
                      'Esta combinacion de valores {codfac}-{dia}-{codperiodo}-{codtra} ya existe',
                      ['codfac'=>$this->getAttributeLabel('codfac'),
                        'dia'=>$this->getAttributeLabel('dia'),
                          'codperiodo'=>$this->getAttributeLabel('codperiodo'),
                          'codtra'=>$this->getAttributeLabel('codtra')
                          ]
                      )
                ],*/
            [['hinicio','hfin','activo','codtra','codperiodo','codfac','skipferiado'], 'safe','on'=>self::SCENARIO_HORAS],
             [['hinicio','hfin'], 'validateHoras','on'=>self::SCENARIO_HORAS],
            [['hinicio', 'hfin'], 'string', 'max' => 5],
            [['talleres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleres::className(), 'targetAttribute' => ['talleres_id' => 'id']],
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
            'dia' => Yii::t('sta.labels', 'Dia'),
            'hinicio' => Yii::t('sta.labels', 'Hinicio'),
            'hfin' => Yii::t('sta.labels', 'Hfin'),
            'tolerancia' => Yii::t('sta.labels', 'Tolerancia'),
             'skipferiado' => Yii::t('sta.labels', 'Saltar Feriado'),
        ];
    }
    
      public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCENARIO_HORAS] = ['hinicio','hfin','activo','codtra','dia','skipferiado'];
       // $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalleres()
    {
        return $this->hasOne(Talleres::className(), ['id' => 'talleres_id']);
    }
    public function getTrabajadores()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * {@inheritdoc}
     * @return RangosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RangosQuery(get_called_class());
    }
    
    public function validateHoras($attribute, $params)
    {
      $duracionminima= h::getIfNotPutSetting('sta','duracionMinimaRango',3, SettingType::INTEGER_TYPE);
        $diferenciaenhoras=$this->toCarbon('hfin')->diffInHours($this->toCarbon('hinicio'));
        if( $diferenciaenhoras <  $duracionminima and $diferenciaenhoras >=0){
             $this->addError('hinicio', yii::t('base.errors','El rango del horario es muy corto o nulo',
                    ['campo'=>$this->getAttributeLabel('hinicio')]));
        }
        if( $diferenciaenhoras < 0){
             $this->addError('hinicio', yii::t('base.errors','Hora inicio mayor que hora fin',
                    ['campo'=>$this->getAttributeLabel('hinicio')]));
        }
        
    }
 
 /*
  * Devuelve el rango de atencion del dia
  * Recibe un objeto carbon como parametro 
  * devuelve el objeto rango
  */
    
  public function dsdsdsdRange(\Carbon\Carbon $fecha ){
     // $diaWeekOriginal=$fecha->weekDay();
     // $carbonInicio=$fecha->copy()->endOfDay()->subHours(24)->parse;
       //$carbonInicio=$fecha->copy()->parse($this->hinicio);
      // $carbonFinal=$fecha->copy()->parse($this->hfin);
    
     // $carbon = $this->toCarbon('fechaprog');
        $hinicio = $this->hinicio;
        $hfinal = $this->hfin;
        $segundosPasadosInicio = $fecha->copy()->parse($hinicio)
                ->diffInSeconds($fecha->copy()->parse($hinicio)->startOfDay());
        $segundosPasadosFin = $fecha->copy()->parse($hfinal)->diffInSeconds($fecha->copy()->parse($hinicio)->startOfDay());
        $carbonInicio = $fecha->copy()->startOfDay()->addSeconds($segundosPasadosInicio);
        $carbonFinal = $fecha->copy()->startOfDay()->addSeconds($segundosPasadosFin);

      
      
      
      
      
      
      
      
      $rango=New RangeDates([
              $carbonInicio,
            $carbonFinal
        ]);
      RETURN $rango;
  }  
  
 public function beforeSave($insert) {
     if($insert){
        
         $this->clase= \frontend\modules\sta\staModule::CLASE_RIESGO;
        $this->codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
        $this->codfac=$this->talleres->codfac;
        $this->nombredia= \common\helpers\timeHelper::daysOfWeek()[$this->dia];
        $this->tolerancia=0.1;
     }
     return parent::beforeSave($insert);
 }
 
 /*
  * A esta fun solo pasale una fecha (carboN) 
  * y te devuelve el registro mas proximo 
  * se fija en el dia de la semana de CARBON OBVIO
  * @fecha CARBON
  * @CODTRA  PSICOLOGO A CARGO
  */
 public static function firstRangeFromFecha(\Carbon\Carbon $fecha,$codtra){
  $query=self::find()->andWhere(['codtra'=>$codtra]);
  $reg= $query->andWhere(['>=','dia',$fecha->dayOfWeek])->one();
  if(is_null($reg)){//Si no encontro por arriba en tonces puede ser qe sea un sabado 
    $reg= $query->andWhere(['<','dia',$fecha->dayOfWeek])->
          orderBy(['dia'=>SORT_ASC])->one();   // entonces hay que porbar con un menor 
      IF(IS_NULL($reg)){
         return null; 
      }else{
         return $reg; 
      }
    }else{
            return $reg;  
    }
 }
  /*
   * INTERFAC
   */
 public function range($micarbon){
     /*
            * FUNCION dEL TIME TRAIT
            */
     /*$rag=self::RangeFromCarbonAndLimits(
           
           $micarbon,
           $this->hinicio,
           $this->hfin); 
     YII::ERROR($rag->initialDate);
     YII::ERROR($rag->finalDate);*/
   return self::RangeFromCarbonAndLimits(           
           $micarbon,
           $this->hinicio,
           $this->hfin); 
 }
 
 public function rangesToDay($carbon,$arrayWhere=null){
     $queryRangos=$this->find()->select(['hinicio','hfin'])
             ->andWhere(['dia'=>$carbon->dayOfWeek,'activo'=>'1'])->
      orderBy(['hinicio'=>SORT_ASC]);
    // echo $queryCitas->createCommand()->getRawSql();
    if(is_null($arrayWhere)){
        $rangosDia=$queryRangos->All();
    }else{
        $rangosDia=$queryRangos->andWhere($arrayWhere)
            ->All();
    }
    /*Aqui comenzamos a crear el obejto rangeDay*/
        if(count($rangosDia)>0){         
            //$fecha=$citasDia[0]['fechaprog']; //Creamosd el carbons de inciializacion*/   
            $rangodia=New \common\helpers\RangeDay($carbon);
                    foreach($rangosDia as $rango){
                        $rangodia->insertRange($rango->range($carbon));
                            }
                return $rangodia;
        }else{
            return null;
        }
  } 
 
 public function  rangesToWeek(\Carbon\Carbon $carbon,$arrayWhere=null){
     $rangoSemana=New \common\helpers\RangeWeek($carbon);
            $rangeLunes=$this->rangesToDay($rangoSemana->initialDate, $arrayWhere);
            if(!is_null($rangeLunes))
             $rangoSemana->insertRange ($rangeLunes);
             
            $rangeMartes=$this->rangesToDay($rangoSemana->initialDate->copy()->addDay(1), $arrayWhere);
           if(!is_null($rangeMartes))
             $rangoSemana->insertRange ($rangeMartes);  
               
            $rangeMiercoles=$this->rangesToDay($rangoSemana->initialDate->copy()->addDay(2), $arrayWhere);
           if(!is_null($rangeMiercoles))
             $rangoSemana->insertRange ($rangeMiercoles); 

            $rangeJueves=$this->rangesToDay($rangoSemana->initialDate->copy()->addDay(3), $arrayWhere);
           if(!is_null($rangeJueves))
             $rangoSemana->insertRange ($rangeJueves); 
           
           $rangeViernes=$this->rangesToDay($rangoSemana->initialDate->copy()->addDay(4), $arrayWhere);
           if(!is_null($rangeViernes))
             $rangoSemana->insertRange ($rangeViernes); 
           
            $rangeSabado=$this->rangesToDay($rangoSemana->initialDate->copy()->addDay(5), $arrayWhere);
           if(!is_null($rangeSabado))
             $rangoSemana->insertRange ($rangeSabado); 
           
           
            $rangeDomingo=$this->rangesToDay($rangoSemana->initialDate->copy()->addDay(6), $arrayWhere);
           if(!is_null($rangeDomingo))
             $rangoSemana->insertRange ($rangeDomingo); 
           
            
      Return $rangoSemana;
 }
  
}
