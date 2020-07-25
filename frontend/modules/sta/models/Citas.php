<?php
namespace frontend\modules\sta\models;
use common\traits\timeTrait;
use common\behaviors\AccessDownloadBehavior;
use Yii;
use common\interfaces\rangeInterface;
use common\helpers\RangeDates;
use common\helpers\h;
use common\models\masters\Trabajadores;
use frontend\modules\sta\staModule;
use frontend\modules\sta\models\Rangos;
use common\helpers\timeHelper;
use common\behaviors\FileBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%sta_citas}}".
 *
 * @property int $id
 * @property int $talleresdet_id
 * @property int $talleres_id
 * @property string $$maximafechafechaprog
 * @property string $codtra
 * @property string $finicio
 * @property string $ftermino
 * @property string $fingreso
 * @property string $detalles
 * @property string $codaula
 * @property int $nalumnos
 * @property string $fregistro
 * @property string $calificacion
 *
 * @property StaTalleresdet $talleresdet
 * @property StaTalleres $talleres
 * @property Trabajadores $codtra0
 * @property StaExamenes[] $staExamenes
 */
class Citas extends \common\models\base\modelBase implements rangeInterface {
    /* public $nombreAlumno='';
      public $nombrePrograma='';
      public $nombrePsicologo='';
      public $nombreFacultad='';
      public $numeroPrograma=''; */

    public $prefijo = '7';

    const SCE_CREACION_BASICA = 'crea_basica';
    const SCENARIO_ASISTIO = 'asistio';
    const SCENARIO_PSICO = 'psico';
    const SCENARIO_ACTIVO = 'activo';
    const SCENARIO_REPROGRAMA = 'reprograma';

    use timeTrait;

    public $dateorTimeFields = [
        'fechaprog' => self::_FDATETIME,
        'finicio' => self::_FDATETIME,
        'ftermino' => self::_FDATETIME
    ];
    public $secretFields = [
        'detalles_indicadores' => [
            'view' => [
                staModule::PROFILE_ADMIN,
                staModule::PROFILE_ASISTENTE,
                staModule::PROFILE_AUTORIDAD,
                staModule::PROFILE_INVITADO,
                staModule::PROFILE_PSICOLOGO,
                staModule::PROFILE_TUTOR_ACADEMICO,
            ],
            'edit' => [staModule::PROFILE_PSICOLOGO],
        ],
        'detalles_tareas_pend' => [
            'view' => [
                staModule::PROFILE_ASISTENTE,
                staModule::PROFILE_AUTORIDAD,
                staModule::PROFILE_PSICOLOGO,
            ],
            'edit' => [staModule::PROFILE_ASISTENTE,
                staModule::PROFILE_AUTORIDAD,
                staModule::PROFILE_PSICOLOGO,],
        ],
        'detalles_secre' => [
            'view' => [
                staModule::PROFILE_PSICOLOGO,
            ],
            'edit' => [staModule::PROFILE_PSICOLOGO],
        ],
        'detalles' => [
            'view' => [
                staModule::PROFILE_AUTORIDAD,
                staModule::PROFILE_PSICOLOGO,
            ],
            'edit' => [staModule::PROFILE_PSICOLOGO],
        ],
    ];
    public $booleanFields = ['asistio', 'activo', 'masivo'];

    public function behaviors() {
        return [
            'AccessDownloadBehavior' => [
                'class' => AccessDownloadBehavior::className()
            ],
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_CREACION_BASICA] = ['talleres_id', 'talleresdet_id', 'duracion', 'fechaprog', 'codfac', 'codtra', 'asistio', 'masivo', 'flujo_id', 'codaula', 'codocu'];
        $scenarios[self::SCENARIO_ASISTIO] = ['asistio'];
        $scenarios[self::SCENARIO_PSICO] = ['codtra'];
        $scenarios[self::SCENARIO_ACTIVO] = ['activo'];
        $scenarios[self::SCENARIO_REPROGRAMA] = ['fechaprog', 'duracion', 'finicio', 'ftermino', 'codtra'];
        return $scenarios;
    }

    /*
     * PARAMETRO FECHA SOLO PARA CUMPLIR LE FORAMTO DE LA INTERFAZ
     */

    public function range($fecha = null) {
        // $this->resolveDuration();
       
        if(!is_null($this->finicio) && !is_null($this->ftermino)){
          $carbon1 = $this->toCarbon('finicio');
          $carbon2 = $this->toCarbon('ftermino');  
        }else{
             $carbon1 = $this->toCarbon('fechaprog');
             $carbon2=$carbon1->copy()->addMinutes($this->duracion);
            
        }
        
        RETURN New RangeDates([
            $carbon1,$carbon2
           // $carbon1->copy()->addMinutes($this->duracion)
        ]);
    }

    /*
     * Retorna una cadena con la fecha tope del dia
     * por ejemplo 
     * 25/08/2019 14:55 
     * retorna   
     * 2019-08-25 23:59:59
     * Esto para comparar en sentencias SQL
     */

    public function beginDay() {
        return $this->toCarbon('fechaprog')->endOfDay()->subDay()->format(
                        h::gsetting('timeBD', 'datetime')
        );
    }

    /*
     * Retorna una cadena con la fecha tope del dia
     * por ejemplo 
     * 25/08/2019 14:55 
     * retorna   
     * 2019-08-25 23:59:59
     * Esto para comparar en sentencias SQL
     */

    public function endDay() {
        return $this->toCarbon('fechaprog')->endOfDay()->format(
                        h::gsetting('timeBD', 'datetime')
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%sta_citas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['talleresdet_id', 'talleres_id', 'codtra', 'fechaprog', 'finicio', 'ftermino', 'flujo_id'], 'required'],
                [['talleresdet_id', 'talleres_id', 'duracion'], 'integer'],
                [['detalles'], 'string'],
                [['detalles_secre', 'detalles_tareas_pend', 'detalles_indicadores', 'duracion', 'codfac', 'asistio', 'activo', 'numero', 'masivo'], 'safe'],
                [['fechaprog', 'finicio', 'ftermino'], 'string', 'max' => 19],
                ['fechaprog', 'validateDispo'],
                [['masivo', 'flujo_id', 'codaula', 'codocu', 'clase'], 'safe'],
                [['codtra'], 'string', 'max' => 6],
                [['fingreso', 'codaula'], 'string', 'max' => 10],
                [['fechaprog', 'duracion', 'finicio', 'ftermino'], 'safe', 'on' => self::SCENARIO_REPROGRAMA],
            // [['calificacion'], 'string', 'max' => 1],
            [['talleresdet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleresdet::className(), 'targetAttribute' => ['talleresdet_id' => 'id']],
                [['talleres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleres::className(), 'targetAttribute' => ['talleres_id' => 'id']],
                [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'talleresdet_id' => Yii::t('sta.labels', 'Talleresdet ID'),
            'talleres_id' => Yii::t('sta.labels', 'Talleres ID'),
            'fechaprog' => Yii::t('sta.labels', 'F Prog'),
            'codtra' => Yii::t('sta.labels', 'Psicólogo'),
            'finicio' => Yii::t('sta.labels', 'F inic'),
            'ftermino' => Yii::t('sta.labels', 'F term'),
            'fingreso' => Yii::t('sta.labels', 'Fingreso'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
            'codaula' => Yii::t('sta.labels', 'Codaula'),
            'detalles_indicadores' => Yii::t('sta.labels', 'Indicador trabajado'),
            'detalles_tareas_pend' => Yii::t('sta.labels', 'Observaciones'),
            'detalles_secre' => Yii::t('sta.labels', 'Datos relevantes'),
            'detalles' => Yii::t('sta.labels', 'Actividades realizadas'),
            'flujo_id' => Yii::t('sta.labels', 'Etapa'),
                //'calificacion' => Yii::t('sta.labels', 'Calificacion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTallerdet() {
        /* echo  $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id'])->createCommand()
          ->getRawSql();die(); */
        return $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaller() {
        return $this->hasOne(Talleres::className(), ['id' => 'talleres_id']);
    }

    public function getFlujo() {
        return $this->hasOne(StaFlujo::className(), ['id' => 'flujo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsicologo() {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamenes() {
        return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }

    public function getLog() {
        return $this->hasMany(StaCitaLog::className(), ['citas_id' => 'id']);
    }

    public function getIndicadores() {
        return $this->hasMany(StaCitaIndicadores::className(), ['citas_id' => 'id']);
    }
    

    /**
     * {@inheritdoc}
     * @return CitasQuery the active query used by this AR class.
     */
    public static function find() {
        return new \frontend\modules\sta\components\ActiveQueryCitas(get_called_class());
    }

    public static function findFree() {
        return new CitasQueryFree(get_called_class());
    }

    public function beforeSave($insert) {
       // yii::error('funcion beforeSave  '.date('Y-m-d H:i:s'));
        if ($insert) {
            $this->resolveDuration();
            $this->codocu = '150';
            $this->clase = \frontend\modules\sta\staModule::CLASE_RIESGO;
            if (is_null($this->asistio) or $this->asistio == '0')
                $this->asistio = false;
            $this->activo = true;
            $this->numero = $this->correlativo('numero', 8);
        }

        //$this->resolveDuration();
        return parent::beforeSave($insert);
    }

    private function validateFieldTalleres() {
        if (empty($this->talleres_id))
            throw new \yii\base\Exception(Yii::t('base.errors', 'El campo \'talleres_id\' está vacío'));
    }

    /*
     * SE ASREGURA DE QUE DURACION SIEMPRE TENGIA UN VALOR RAZOBNABLE Y NO SE A NULO
     */

    private function resolveDuration() {
        if ($this->hasBothDates()) {
            $this->duracion = $this->toCarbon('ftermino')->
                    diffInMinutes($this->toCarbon('finicio'));
        } else {
            //yii::error('buscanco');
            // $this->validateFieldTalleres();
            $stringHora = $this->tallerProg()->duracioncita;
            //yii::error('stringhora : '.$stringHora);            
            $hora = (integer) substr($stringHora, 0, 2);
            $minuto = (integer) substr($stringHora, 3, 2);
            $carbonF = $this->toCarbon('fechaprog')->hour(0)->minute(0);
            $carbonD = $carbonF->copy();
            $carbonD->hour($hora)->minute($minuto);
            //yii::error('El caroon final es : '.$carbonD);
            $this->duracion = $carbonD->diffInMinutes($carbonF);
            $this->finicio = $this->fechaprog;
            $this->ftermino = $this->toCarbon('fechaprog')->addMinutes($this->duracion)->format($this->formatToCarbon(self::_FDATETIME));
        }
    }

    /* Funcionque verifica que tiene ambas fechas llenas 
     *  finicio  y ftermino      
     *      */

    private function hasBothDates() {
        return (!$this->withoutFinicio() && !empty($this->ftermino));
    }

    /* ActiveQuery para filtrar 
     * las citas del dia */

    public function citasActiveQueryForDay() {
        return $this->find()->andWhere(['>', 'fechaprog', $this->beginDay()])->
                        andWhere(['<=', 'fechaprog', $this->endDay()]);
    }

    /*
     * funcion npar aver si el psicolog esta disponibleo se cruiza */

    public function isFreeForPsico() {
        //Si no esta dentro de ningun rango del tutor ese dia esta libre 
        return !$this->isRangeInOtherGroupRanges($this->range(), $this->rangesInDayByTutor());
    }

    /* funcion para verificar la siponibilida de una s citas
     * 
     * 1) Verificar que esta dentro del rango de la jornada
     * es decir compara con el range de Talleres   9:00  17::00
     * 
     * 2)Verificar la dsponibilidad del horario con las citas ya establecidas
     * 
     * 
     *  */

    public function verifyDispoCita($fecha) {
        if ($fecha instanceof RangeDates) {
            if ($this->isRangeIntoOtherRange($this->range(), $fecha)) {
                $this->addError('fechaprog', yii::t('La cita no está dentro de las jornada establecida'));
                return false;
            }
        } elseIf ($fecha instanceof \Carbon\Carbon) {
            return false;
        } else {
            if (!$this->isInJourney($fecha))
                return false;
        }



        /*
         * Ahora verificamos que el Tutor tiene disponiiblidad ese dia
         */
        $rangos = $this->rangesInDayByTutor($fecha);
        $seTraslapa = false;
        foreach ($rangos as $rango) {
            if ($this->isRangeIntoOtherRange($this->range(), $rango)) {
                $this->addError('fechaprog', yii::t('El tutor \'{tutor}\' ya tiene asignado una cita en el rango \'{fecha1}\' - \'{fecha2}\' ', [
                            'tutor' => $this->codtra,
                            'fecha1' => $rango->initialDate->format(h::gsetting('timeBD', 'datetime')),
                            'fecha2' => $rango->finalDate->format(h::gsetting('timeBD', 'datetime')),
                ]));
                $seTraslapa = true;
                break;
            }
        }
        if ($seTraslapa)
            return !$seTraslapa;

        /*
         * Ahora verificamos que el Aula tiene disponiiblidad ese dia
         */

        $rangos = $this->rangesInDayByAula($fecha);
        $seTraslapa = false;
        foreach ($rangos as $rango) {
            if ($this->isRangeIntoOtherRange($this->range(), $rango)) {
                $this->addError('fechaprog', yii::t('El Aula \'{aula}\' ya tiene asignado una cita en el rango \'{fecha1}\' - \'{fecha2}\' ', [
                            'aula' => $this->codaula,
                            'fecha1' => $rango->initialDate->format(h::gsetting('timeBD', 'datetime')),
                            'fecha2' => $rango->finalDate->format(h::gsetting('timeBD', 'datetime')),
                ]));
                $seTraslapa = true;
                break;
            }
        }
        if ($seTraslapa)
            return !$seTraslapa;

        return true;
    }

    /*
     * Verifica que esta dentro del rango de la jornada 
     */

    public function isInJourney() {
        yii::error('funcion isInJourney  '.date('Y-m-d H:i:s'));
        yii::error($this->getOldAttributes());
        yii::error($this->attributes);
       // try {
         yii::error(' codtra es   ',__FUNCTION__); 
          yii::error($this->codtra,__FUNCTION__); 
       
            $registroRango = $this->horarioToday($this->codtra); //->Range($this->toCarbon('fechaprog'));
       // } catch (Exception $ex) {
            if(is_null($registroRango)){
                 yii::error(' el rango es nul  ',__FUNCTION__); 
               $this->addError('fechaprog', yii::t('sta.errors', 'Fecha de programación fuera del intervalo permitido'));
               yii::error(' se agrega el error a la cita  ',__FUNCTION__); 
               return false; 
            }
            
        //}
       // var_dump($registroRango->attributes);die();
        $carbon = $this->toCarbon('fechaprog');
        $hinicio = $registroRango->hinicio;
        $hfinal = $registroRango->hfin;
        $segundosPasadosInicio = $carbon->copy()->parse($hinicio)
                ->diffInSeconds($carbon->copy()->parse($hinicio)->startOfDay());
        $segundosPasadosFin = $carbon->copy()->parse($hfinal)->diffInSeconds($carbon->copy()->parse($hinicio)->startOfDay());
        $carbonInicio = $carbon->copy()->startOfDay()->addSeconds($segundosPasadosInicio);
        $carbonFinal = $carbon->copy()->startOfDay()->addSeconds($segundosPasadosFin);

      /* if (h::userId() == 7) {
            echo $carbonInicio->format('Y-m-d H:i:s') . "<br>";
            echo $carbonFinal->format('Y-m-d H:i:s'). "<br>";
            $rango=$this->range();
            echo $rango->dates[0]->format('Y-m-d H:i:s'). "<br>";
            echo $rango->dates[1]->format('Y-m-d H:i:s'). "<br>";
            //var_dump($this->range());
           
        }*/
  yii::error('pasando otras',__FUNCTION__); 

        if ($this->isRangeIntoOtherRange(
                        $this->range(), New RangeDates([$carbonInicio, $carbonFinal])
                )) {
            /* $this->addError('fechaprog',
              yii::t('sta.errors','La cita no está dentro del horario predefinido; revise su horario de atención'));
             */
            yii::error('compronado rangos',__FUNCTION__); 
            return TRUE;
        }
        yii::error('llegando alfinal',__FUNCTION__); 
        return FALSE;
    }

    /* DEVUELVE el grupo de rangos en ese dia */

    private function rangesInDay($fecha) {
        $rowsCitas = $this->citasActiveQueryForDay()->
                andWhere(['codaula' => $this->codaula])->andWhere(['codtra' => $this->codtra])->
                all();
        $rangos = [];
        foreach ($rowCitas as $row) {
            $rangos[] = $row->range();
        }
        return $rangos;
    }

    /*
     * Verifica que el dia de la cita 
     * esta dentro de los dias aprobados en el programa
     * ademas valida si es sferiado feriado 
     */

    public function esFeriado() {
        ///ECHO "AQUI";DIE();

        if ($this->isHolyDay($this->toCarbon('fechaprog'))) {
            // ECHO "Sie s feriado ";DIE();
            // $this->addError('fechaprog',yii::t('sta.errors','El día programado es no laborable'));
            if($this->horarioToday()->skipferiado){
                return false;
            }else{
               return true; 
            }
            
        } else {
            // ECHO "NO es hliday ";DIE(); 
        }
        return false;
    }

    /* DEVUELVE el grupo de rangos en ese dia coupados por el tutor
     * OJO NOS E FILTRA  talleres_id porque un turor puede participar 
     * en mas de un programa, el filtro es general en toda la universidad 
     *  */

    private function rangesInDayByTutor() {
        $rowsCitas = $this->citasActiveQueryForDay()->
                andWhere(['codtra' => $this->codtra])->
                all();
        $rangos = [];
        foreach ($rowsCitas as $row) {
            $rangos[] = $row->range();
        }
        return $rangos;
    }

    /* DEVUELVE el grupo de rangos en ese dia coupados por el aula
     * Ojo aqui si se filtra por taller porque para cada taller existe 
     * un grupo de aulas unico
     *  */

    private function rangesInDayByAula($fecha) {
        $rowsCitas = $this->citasActiveQueryForDay()->
                andWhere(['talleres_id' => $this->talleres_id])->
                andWhere(['codaula' => $this->codaula])->
                all();
        $rangos = [];
        foreach ($rowCitas as $row) {
            $rangos[] = $row->range();
        }
        return $rangos;
    }

    public function tallerProg() {
        if (!$this->isNewRecord) {
            return $this->taller;
        } else {
            return Talleres::findOne($this->talleres_id);
        }
    }

    public function createBasic($campos) {
        $oldScenario = $this->getScenario();
        $this->setScenario(self::SCE_CREACION_BASICA);
        $this->setAttributes($campos);
        $this->save();
        $this->setScenario($oldScenario);
        return $this->getErrors($attribute);
    }

    /*
     * Genera un evento FullCalendar 
     * com los datos del mismo registro
     */

    public function evento() {
        $tallerdet = $this->tallerdet;
        /* $sufijo= substr(strrev($this->codtra),0,2);
          $caracter1=substr($sufijo,0,1);
          $caracter2=substr($sufijo,1,1);
          $color='#'.$caracter1.'cb85'.$caracter2; */
        if (is_object($tallerdet)) {
            $title = $tallerdet->codalu;
        } else {
            $title = '------';
        }
        //echo $this->id;die();
        $formatDB = h::gsetting(self::_FORMATBD, self::_FDATETIME); // = "Y-m-d H:i:s"
        return [
            'id' => $this->id,
            'title' => $title,
            'start' => $this->swichtDate('fechaprog', false),
            'end' => date($formatDB, strtotime($this->swichtDate('fechaprog', false)) + 60 * $this->duracion),
            'color' => '#5cb85c',
            'codtra' => $this->codtra
        ];
    }

    public function citasPendientes() {


        $horas = h::gsetting('sta', 'nhorasreprogramacion');
        $limite = self::CarbonNow()->subHours($horas)->format(timeHelper::formatMysql());
        return static::find()->
                        andWhere(['>=', 'fechaprog', $limite])
                        ->andWhere([
                            /* 'talleres_id'=>$this->talleres_id, */
                            'codtra' => $this->codtra,
                            'masivo' => '0',
                            'asistio' => '0',
                        ])->all();


        return Citas::find()->andWhere(
                        [/* 'talleres_id'=>$this->talleres_id, */
                            'codtra' => $this->codtra,
                        //'asistio'=> '0',
                ])->andWhere(['>', 'fechaprog', $this->CarbonNow()->endOfDay()->subWeek()->subWeek()->format(
                            h::gsetting('timeBD', 'datetime')
            )])->all();
    }

    public function eventosPendientes() {
        $eventos = [];
        ///$citas= $this->citasPendientes();
        // $eventos=[];
        $citas = $this->citasPendientesQuery()->all();
        //var_dump($citas);die();
        foreach ($citas as $cita) {
            $eventos[] = $cita->evento();
        }
        return $eventos;
    }

    public function citasPendientesQuery() {
        $horas = h::gsetting('sta', 'nhorasreprogramacion');
        $limite = self::CarbonNow()->subHours($horas)->format(timeHelper::formatMysql());

        return static::find()->
                        andWhere(['>=', 'fechaprog', $limite])->andWhere(['codfac' => $this->codfac])
                        ->andWhere([
                            /* 'talleres_id'=>$this->talleres_id, */
                            // 'codtra'=>$this->codtra,
                            //'masivo'=>'0',
                            'asistio' => '0',
        ]);
    }

    public function putColorThisCodalu($events, $codalu, $color = "#ff0000") {
        // $codalu=$this->tallerdet->codalu;
        $tutores = array_unique(array_column($events, 'codtra'));

        $colores = ['#31B404', '#FFBF00', '#AEB404', '#848484', '#084B8A', '#071418'];
        $colores = array_slice($colores, 0, count($tutores));
        //yii::error($tutores,__FUNCTION__);
        //yii::error($colores);
        $colores = array_combine($tutores, $colores);

        //$codtraaux='';
        foreach ($events as $index => $event) {
            if (trim(strtoupper($codalu)) == trim(strtoupper($event['title']))) {
                $events[$index]['color'] = $color;
            } else {
                $events[$index]['color'] = $colores[$event['codtra']];
            }
        }
        return $events;
    }

    /* Ubica la cita inmediatamente superior
     * en tiempo , segun el alumno
     * Return : id de la siguiente cita
     */

    public function nextCitaByStudent() {
        /* echo $this->find()->select('id')->andWhere([
          'talleresdet_id'=>$this->talleresdet_id,
          ])->andWhere(['>','fechaprog',$this->fechaprog])->
          orderBy('fechaprog ASC')->createCommand()->getRawSql();
          die(); */
        return $this->find()->select('id')->andWhere([
                            'talleresdet_id' => $this->talleresdet_id,
                        ])->andWhere(['>', 'fechaprog', $this->swichtDate('fechaprog', false)])->
                        orderBy('fechaprog ASC')->limit(1)->scalar();
    }

    public function previousCitaByStudent() {
        /* echo $this->find()->select('id')->where([
          'talleresdet_id'=>$this->talleresdet_id,
          ])->andWhere(['<','fechaprog',$this->fechaprog])->
          orderBy('fechaprog DESC')->createCommand()->getRawSql();
          die(); */
        return $this->find()->select('id')->andWhere([
                            'talleresdet_id' => $this->talleresdet_id,
                        ])->andWhere(['<', 'fechaprog', $this->swichtDate('fechaprog', false)])
                        ->orderBy('fechaprog DESC')->limit(1)->
                        scalar();
    }

    public function lastCitaByStudent() {
        $maximafecha = $this->find()->select('max(fechaprog)')->andWhere([
                    'talleresdet_id' => $this->talleresdet_id,
                ])->scalar();
        if ($maximafecha === false)
            return $maximafecha;
        return $this->find()->select('id')->andWhere([
                    'talleresdet_id' => $this->talleresdet_id,
                ])->andWhere(['fechaprog' => $maximafecha])->scalar();
    }

    public function firstCitaByStudent() {
        $minimafecha = $this->find()->select('min(fechaprog)')->andWhere([
                    'talleresdet_id' => $this->talleresdet_id,
                ])->scalar();
        if ($minimafecha === false)
            return $minimafecha;
        return $this->find()->select('id')->andWhere([
                    'talleresdet_id' => $this->talleresdet_id,
                ])->andWhere(['fechaprog' => $minimafecha])->scalar();
    }

    public function breadCrumbsByStudent() {
        return [
            yii::t('sta.labels', 'Primera cita') => $this->firstCitaByStudent(),
            yii::t('sta.labels', 'Cita Previa') => $this->previousCitaByStudent(),
            yii::t('sta.labels', 'Siguiente Cita') => $this->nextCitaByStudent(),
            yii::t('sta.labels', 'Ultima cita') => $this->lastCitaByStudent(),
        ];
    }

    public function providerByAlumno() {
        
    }

    /*
     * Funcion que genera el bando de preguntas 
     * dentro de esta cita 
     * 
     */

    public function generaExamenes() {
        $valor = false;
        foreach ($this->examenes as $examen) {
            $valor = $examen->creaExamen();
            if ($valor == false) {
                break;
            }
        }
        return $valor;
    }

    /*
     * Funcion que devuelve los dataprovidesr de las preguntas 
     * de los examenes
     */

    public function providersExamenes() {
        $proveedores = [];
        //var_dump($this->codExamenes());die();
        foreach ($this->codExamenes() as $codexamen) {
            $proveedores[$codexamen] = VwStaExamenesSearch::searchByExamenCode($this->id, $codexamen);
        }

        return $proveedores;
    }

    public function codExamenes() {
        return array_column(Examenes::findFree()->select(['codtest'])
                        ->where(['citas_id' => $this->id])->asArray()->all(), 'codtest');
    }

    public function numeroPreguntas() {
        $ids = (new \yii\db\Query())
                        ->select('id')
                        ->from('{{%sta_examenes}}')
                        ->where(['citas_id' => $this->id])->column();

        return (new \yii\db\Query())
                        ->select('count(*)')
                        ->from('{{%sta_examenesdet}}')
                        ->where(['examenes_id' => $ids])->scalar();
    }

    public function canInactivate() {
        return (!$this->hasChilds() && !$this->asistio && !$this->isVencida()) ? true : false;
    }

    public function canChangeAsistio() {
        //Debe de estar en el presente o pasado 
        if ($this->isVencida()) {
            $this->addError('asistio', yii::t('sta.errors', 'Esta cita ya está vencida'));
            return false;
        }
        if ($this->toCarbon('finicio')->greaterThan(self::CarbonNow()->addHours(1))) {
            $this->addError('asistio', yii::t('sta.errors', 'La fecha de inicio está en el futuro'));
            return false;
        }

        return true;
    }

    public function canChangeFalto() {
        //Debe de estar en el presente o pasado 
        if ($this->canChangeAsistio()) {
            if ($this->hasExamenes()) {
                $this->addError('asistio', yii::t('sta.errors', 'La cita tiene evaluaciones'));
                return false;
            }
            if ($this->flujo->esevento) {
                $this->addError('asistio', yii::t('sta.errors', 'La cita es parte de un evento'));
                return false;
            }
            if ($this->getIndicadores()->count() > 0) {
                $this->addError('asistio', yii::t('sta.errors', 'La cita tiene Indicadores, usted ya trabajó con el alumno'));
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function hasExamenes() {
        return ($this->getExamenes()->count() > 0) ? true : false;
    }

    /* Si tiene el banoc de preguntyas comleto */

    public function hasCompletePreguntas() {
        $completo = true;
        foreach ($this->examenes as $examen) {
            if ($examen->getExamenesDet()->count() == 0) {
                $complete = false;
                break;
            }
        }
        return $completo;
        //return $this->isBateriaCompleta();
    }

    public function withoutFinicio() {
        /* return ($this->finicio== \common\helpers\timeHelper::getDateTimeInitial() or 
          empty($this->finicio))?true:false; */
    }

    public function isInPast() {
        return $this->toCarbon('fechaprog')->lessThanOrEqualTo(self::CarbonNow());
    }

    public function isVencida() {
        if ($this->flujo_id == 1) {
            $horas = 1500;
        } else {
            $horas = h::gsetting('sta', 'nhorasreprogramacion');
        }

        return $this->toCarbon('fechaprog')->lessThanOrEqualTo(self::CarbonNow()->subHours($horas));
    }

    /*
     * Reporgarma la cita 
     * fechatermino: cadena en formato Y-m-d
     * fechainicio : cadena en formato Y-m-d
     */

    public function reprograma($fechaInicio, $fechaTermino = null) {
        // yii::error($this->asistio);
        //yii::error($this->isVencida());
        $oldFecha = $this->fechaprog;

        /* Si  se trata de un evento no se puede reprogramar */
        if ($this->flujo->esevento) {
            $this->addError('fechaprog', yii::t('sta.errors', 'Esta cita no puede reprogramarse, se trata de una cita dentro de un evento'));
            return false;
        }
        if (!$this->asistio && !$this->isVencida()) {
            // if(true){  
            if (!($fechaInicio instanceof \Carbon\Carbon)) {
                $CfechaInicio = \Carbon\Carbon::createFromFormat(\common\helpers\timeHelper::formatMysql(), $fechaInicio);
            } else {
                $CfechaInicio = $fechaInicio;
            }
            if (!is_null($fechaTermino)) {
                $CfechaTermino = \Carbon\Carbon::createFromFormat(\common\helpers\timeHelper::formatMysql(), $fechaTermino);
                $this->duracion = $CfechaTermino->diffInMinutes($CfechaInicio);
            }
            //var_dump($CfechaInicio->format($this->formatToCarbon(self::_FDATETIME)));die();

            $codigotra = $this->taller->psicologoPorDia($CfechaInicio);
             //Si no encuentra turno ese dia coger el pisocolo por defecto 
            if(is_null($codigotra)){
                $profile=h::user()->profile;
                    if($profile->tipo== \frontend\modules\sta\staModule::PROFILE_PSICOLOGO){
                       $codigotra = $profile->codtra; 
                    }else{
                       $codigotra = $this->tallerdet->codtra;   
                    }
            }
              
             

            $this->fechaprog = $CfechaInicio->format($this->formatToCarbon(self::_FDATETIME));
            $this->finicio = $this->fechaprog;
            $this->codtra = $codigotra;
            $this->ftermino = $CfechaInicio->addMinutes($this->duracion)->format($this->formatToCarbon(self::_FDATETIME));
            $oldScenario = $this->getScenario();



            $this->setScenario(self::SCENARIO_REPROGRAMA);
            $this->registraLog($oldFecha);
            $grabo = $this->save();

            if (h::gsetting('sta', 'notificacitasmail')) {
                $this->enviacorreo(false); //notiifcacion depreprogramcion
            }
            if (!$grabo) {
                $this->addError('fechaprog', yii::t('sta.errors', $this->getFirstError()));
                return false;
            }
            $this->setScenario($oldScenario);
            return $grabo;
        } else {
            if ($this->isVencida())
                $this->addError('fechaprog', yii::t('sta.errors', 'La cita se encuentra en el pasado, es mejor que cree una nueva'));
            if ($this->asistio)
                $this->addError('fechaprog', yii::t('sta.errors', 'Esta cita ya tiene asistencia'));

            return false;
        }
    }

    public function validateDispo($attribute, $params) {
        //yii::error('funcion validatedispo  '.date('Y-m-d H:i:s'));
        /* lA FECHA NOPÙED ECAER EN UNDOMINGO O  FERIADO */
        IF ($this->esFeriado()) {
            $this->addError('fechaprog', yii::t('sta.errors', 'La fecha se encuentra en un día no laborable'));
            RETURN;
        }
        /* Fecha de inicio no pued ser mayoa fecha final */
        if (!$this->isNewRecord) {
            if ($this->toCarbon('finicio')->greaterThan($this->toCarbon('ftermino'))) {
                $this->addError('finicio', yii::t('sta.errors', 'La fecha de inicio es mayor que la fecha de termino '));
                RETURN;
            }
        }
        /* if($this->toCarbon('finicio')->greaterThan($this->toCarbon('ftermino'))){
          $this->addError('finicio',yii::t('sta.errors','La fecha de inicio es mayor que la fecha de termino '));
          RETURN;
          } */

        /* No puedne crearse ni reporgramarse citas en el pasado */
        if ($this->isNewRecord && $this->toCarbon('fechaprog')->lt(self::CarbonNow()->subSeconds(10))) {

            /* PERO HAY UNA EXCEPCION CON LAS CITAS DE LOS EVENTOS 
             * QUE CONRLAN ASISTENCIA EXTEMPORANEAMENTE
             */
            IF (!$this->flujo->esevento) {
                $this->addError('fechaprog', yii::t('sta.errors', 'La fecha programada está en el pasado'));
            }
            RETURN;
        }

        if (!$this->isNewRecord && $this->hasChanged('finicio')) {
            $horas = h::gsetting('sta', 'nhorasreprogramacion');
            $horas = round($horas / 4, 0);
            if (!$this->toCarbon('finicio')->
                            between($this->toCarbon('fechaprog')->subHours($horas), $this->toCarbon('fechaprog')->addHours($horas)))
                $this->addError('finicio', yii::t('sta.errors', 'La fecha de inicio tiene diferencia mayor a {horas} horas , respecto a la fecha programada', ['horas' => $horas]));
        }

        /* if(!$this->isNewRecord){

          if($this->toCarbon('finicio')->lt($this->toCarbon('fechaprog')->subHours(1)))
          $this->addError('finicio',yii::t('sta.errors','La fecha de inicio debe ser mayor que la fecha de programacion'));

          }else{
          if($this->isVencida() && !$this->masivo){ //Las Citas de eventos o masivad , si pueden
          //crearse con fechas atrasadas , en especial en los cierres de eventos
          $horasAtraso=self::CarbonNow()->diffInHours($this->toCarbon('fechaprog'));
          $this->addError('fechaprog',yii::t('sta.errors','La fecha programada se encuentra {atraso} horas atrasadas, la tolerancia es {horas}',['atraso'=>$horasAtraso,'horas'=>h::gsetting('sta', 'nhorasreprogramacion')]));
          }
          }
         * */

        //if($this->isVencida())
        //$this->addError('fechaprog',yii::t('sta.errors','La cita se encuentra en el pasado, es mejor que cree una nueva')); 
        //if($this->asistio)
        //$this->addError('fechaprog',yii::t('sta.errors','Esta cita ya tiene asistencia')); 
        if ($this->isNewRecord && !$this->isInJourney())
            $this->addError('ftermino', yii::t('sta.errors', 'Está fuera del horario predefinido, revise los horarios de atención o modifique los horarios de esta cita'));
    
        if (!$this->isNewRecord && ($this->hasChanged('fechaprog')
            or $this->hasChanged('finicio') or $this->hasChanged('ftermino') )){
           
            if(!$this->isInJourney()){
               
               $this->addError('ftermino', yii::t('sta.errors', 'Está fuera del horario predefinido, revise los horarios de atención o modifique los horarios de esta cita'));
      
            }
           
        }
            
        
      }

    //$this->isInJourney();
    //if($this->isInPast())
    // $this->addError('fechaprog',yii::t('sta.errors','La fecha de inicio se encuentra en el pasado'));





    public function agregaBateria($codbateria) {
        $pruebas = Test::find()->where(['codbateria' => $codbateria])->orderBy('orden asc')->all();
        foreach ($pruebas as $prueba) {
            $this->addTest($prueba->codtest);
        }
        $this->generaExamenes();
    }

    private function addTest($codtest) {
        $attributes = [
            'citas_id' => $this->id,
            'codtest' => $codtest,
            'codfac' => $this->codfac,
            'user_id' => h::userId(),
            'reporte_id' => staModule::REPORTE_TEST,
            'virtual' => '1',
            'status' => Aluriesgo::FLAG_NORMAL,
            'flujo_id' => $this->flujo_id,
        ];
        $verifyAttributes = ['citas_id' => $this->id,
            'codtest' => $codtest,];
        Examenes::firstOrCreateStatic($attributes, null, $verifyAttributes);
    }

    public function examenesId($idCita = null) {
        if (is_null($idCita)) {
            $idCita = $this->id;
        }
        return Examenes::find()->select(['id'])
                        ->andWhere(['citas_id' => $idCita])->column();
    }

    /*
     * Verifiac que todas las preguntas de los 
     * examens ya han sido contestadas
     * YA NO HAY NECEISDAD DE NOTIFICAR
     * por correo */

    public function isBateriaCompleta() {
        /* var_dump(StaExamenesdet::find()->andWhere(['valor'=>null])->
          andWhere(['examenes_id'=>$this->examenesId()])->createCommand()->getRawSql());die();
          /*yii::error(StaExamenesdet::find()->andWhere(['valor'=>null])->
          andWhere(['examenes_id'=>$this->examenesId()])->createCommand()->getRawSql());
         */return !StaExamenesdet::find()->andWhere(['valor' => null])->
                        andWhere(['examenes_id' => $this->examenesId()])->exists();
    }

    /* Verifica que el alumno ya ha rendido alguna prueba 
      en una cita anterior en el periodo actual
      devuelve el id de la cita , si no encuentra nada devuelve false */
/*
    public function lastCitaWithExamen() {
        //$currentCodper=StaModule::getCurrentPeriod();
        //$codper=$this->talleresdet->taller->codperiodo;
        //SACANDO LOS TALLERES ID DE ESTE PERIODO
        //Sacando el id de las otras citas de este alumno ene ste periodo
       // $IdsEvaluaciones=StaFlujo::idsFlujosEvaluaciones();
        
        $citasId = self::find()->select(['id'])->andwhere(['talleresdet_id' => $this->talleresdet_id])
                        ->andWhere(['<>', 'id', $this->id])->column();
        
        return Examenes::find()->select(['citas_id'])->andWhere(['citas_id' => $citasId,'flujo_id'=>$this->flujo_id])->orderBy('citas_id DESC')->scalar();
    }
*/
    /*
     * Ejecuta los resultados 
     * segun las respuestas
     */

    public function makeResultados() {
        $codperiodo = $this->tallerdet->talleres->codperiodo;
        foreach ($this->examenes as $examen) {
            $examen->makeResultados($codperiodo);
        }
        return true;
    }

    public function marcadorStatus() {
        if (!$this->isVencida()) { //futuro
            if ($this->asistio) {
                return ['success' => Yii::t('sta.labels', 'EFECTUADA')];
            } else {
                return ['warning' => Yii::t('sta.labels', 'PROGRAMADA')];
            }
        } else { //presenet y pasado
            if ($this->asistio) {
                return ['success' => Yii::t('sta.labels', 'EFECTUADA')];
            } else {
                return ['danger' => Yii::t('sta.labels', 'VENCIDA')];
            }
        }
    }

    public function eliminaCita() {
        $this->clearErrors();
        $this->setScenario(self::SCENARIO_ACTIVO);
        $this->activo = false;
        if ($this->asistio) {
            $this->addError('asistio', yii::t('sta.errors', 'Esta cita ya tiene asistencia'));
            return $this->getErrors();
            ;
        }
        if ($this->isVencida()) {
            $this->addError('fechaprog', yii::t('sta.errors', 'Esta cita ya está vencida'));
            return $this->getErrors();
        }
        $this->save();
        return $this->getErrors();
    }

    public function notificaCorreoExamen() {
        $mensajes = [];
        $alumno = $this->tallerdet->alumno;
        $token = \common\components\token\Token::create('citas', 'token_' . $this->id, null, time());
        $link = Url::to(['/sta/citas/examen-banco', 'id' => $this->id, 'token' => $token->token], true);
        $mailer = new \common\components\Mailer();
        $message = new \yii\swiftmailer\Message();
        $message->setSubject('Evaluación Psicológica - Tutoría')
                ->setFrom([\common\helpers\h::gsetting('mail', 'userservermail') => 'Oficina Tutoría Psicológica UNI'])
                ->setTo($alumno->correo)
                ->SetHtmlBody("Buenas Tardes   " . $alumno->fullName() . " <br>"
                        //->SetHtmlBody("Buenas Tardes   ALUMNO XXXX XXX XXXX  <br>"     
                        . "La presente es para notificarle que tienes "
                        . "una examen VIRTUAL programado. <br> Presiona el siguiente link "
                        . "para acceder a la prueba: <br>"
                        . "    <a  href=\"" . $link . "\" >Presiona aquí </a>");

        try {

            $result = $mailer->send($message);
            return true;
            $mensajes['success'] = 'Se envió el correo, invitando al examen, el Alumno tiene que responder ';
        } catch (\Swift_TransportException $Ste) {
            $mensajes['error'] = $Ste->getMessage();
        }
        return $mensajes;
    }

    public function enviacorreo($nueva = true) {
        if ($nueva) {
            $verbo = Yii::t('sta.labels', 'PROGRAMADA');
        } else {
            $verbo = Yii::t('sta.labels', 'REPROGRAMADA');
        }
        $validator = new \yii\validators\EmailValidator();
        $mailer = new \common\components\Mailer();
        $message = new \yii\swiftmailer\Message();
        $alumno = $this->tallerdet->alumno;
        //$psicologo=$this->tallerdet->trabajador;
        $correo = $alumno->correo;
        if ($validator->validate($correo)) {
            $nombrealumno = $alumno->fullName();
            // $psicologo=$this->tallerdet->trabajador->fullName();
            $message->setSubject('CITA ' . $verbo . ' ' . $this->numero)
                    ->setFrom([h::gsetting('mail', 'userservermail') => 'Oficina de Tutoría Psicológica UNI'])
                    ->setTo($correo)
                    ->SetHtmlBody("Buenas Tardes :" . $nombrealumno . " <br>"
                            . "La presente es para notificarle que tienes "
                            . "una cita  " . strtolower($verbo) . " por la OFICINA DE TUTORÍA PSICOLÓGICA. De tu facultad<br> "
                            . "Cuándo : " . $this->fechaprog . "<br>"
                            // . "Profesional a Cargo :  ".$psicologo."  <br><br>"
                            . "Contamos con tu valioso tiempo <br>"
                            . "Muchas Gracias por tu atención.");
            $repsonderA = $this->taller->listMailsFromTutores();
            if (count($repsonderA) > 0) {
                /*
                 * Borrar esta linea si hay algun error
                 */
                $message->setReplyTo($repsonderA);
                /*
                 * Din de la iena a borar
                 */
            }


            try {

                $result = $mailer->send($message);
                return true;
                //$mensajes['success']='Se envió el correo,  ';
            } catch (\Swift_TransportException $Ste) {
                return false;
            }
        }
    }

    /*
     * TipoProfile h::user()->profile->tipo;
     */

    public function isVisibleField($campo, $tipoProfile) {
        $AFields = $this->secretFields;
        //$tipo=h::user()->profile->tipo;
        if (in_array($campo, array_keys($AFields))) {
            if (in_array($tipoProfile, $AFields[$campo]['view'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function isEditableField($campo, $tipoProfile) {
        $AFields = $this->secretFields;
        //$tipo=h::user()->profile->tipo;
        if (in_array($campo, array_keys($AFields))) {
            if (in_array($tipoProfile, $AFields[$campo]['edit'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function previousWithoutEvento() {
        /* var_dump(static::find()->andWhere(['talleresdet_id'=>$this->talleresdet_id,
          'masivo'=>'0'])->
          andWhere(['<','fechaprog',$this->swichtDate('fechaprog',true)])
          ->createCommand()->getRawSql());die(); */
        return static::find()->andWhere(['talleresdet_id' => $this->talleresdet_id,
                            'masivo' => '0'])->
                        andWhere(['<', 'fechaprog', $this->swichtDate('fechaprog', true)])->
                        one();
    }

    /* Esta funcion es muy importante porque 
     * identifica la etapa en la que debe de estar la cita
     * De acuerdo al flujo de trabajo 
     * tabla sta_flujo
     */

    public function obtenerEtapaId($idEtapa = null) {
        $codperiodo = staModule::getCurrentPeriod();
       /* if (h::userId() == 7) {
            $previo = $this->previousWithoutEvento();

            if (!is_null($previo)) {
                if ($previo->asistio) {
                    return $previo->flujo->nextActividad($this->tallerdet->talleres->codperiodo)->actividad;
                } else {
                    if ($previo->isVencida()) {
                        return $previo->obtenerEtapaId();
                    } else {
                        return $previo->flujo->nextActividad($this->tallerdet->talleres->codperiodo)->actividad;
                    }
                }
            } else {

                return StaFlujo::firstRecord($this->tallerdet->talleres->codperiodo)->actividad;
            }
            die();
        }
*/


















        /* Consulta para verificar que hay citas 
         * con asistencia y que no son eventos 
         */
        $queryFilter = static::find()->andWhere(
                [
                    'talleresdet_id' => $this->talleresdet_id,
                    'asistio' => '1',
                    'masivo' => '0'
        ]);





        //yii::error($queryFilter->createCommand()->getRawSql ());
        // $horas=h::gsetting('sta', 'nhorasreprogramacion');
        if (is_null($idEtapa)) {
            $actual = $queryFilter->/* orWhere(['and',
                              'talleresdet_id='.$this->talleresdet_id,
                              "asistio='0'",
                              "masivo='0'",
                              "fechaprog >'".self::CarbonNow()->subHours(5)->format(\common\helpers\timeHelper::formatMysqlDateTime())."'"
                              ])-> */
                            select('max(flujo_id)')->scalar();
            /* yii::error($queryFilter->orWhere(['and',
              'talleresdet_id='.$this->talleresdet_id,
              "asistio='0'",
              "masivo='0'",
              "fechaprog >'".self::CarbonNow()->subHours(5)->format(\common\helpers\timeHelper::formatMysqlDateTime())."'"
              ])->
              select('max(flujo_id)')->createCommand()->getRawSql()); */
            //yii::error('El valor actual es ');
            //yii::error($actual);
            if ($actual === false or is_null($actual)) {
                //yii::error('Chispas es nulo o es falso ');
                //yii::error('retornando StaFlujo::firstRecord($codperiodo)->actividad ');
               // yii::error(StaFlujo::firstRecord($codperiodo)->actividad);
                return StaFlujo::firstRecord($codperiodo)->actividad;
            }

            $queryFlujo = StaFlujo::find()->where([
                'codperiodo' => $codperiodo,
                'actividad' => $actual,
                'esevento' => '0'
            ]);
            //yii::error('queryFuljo');
            //yii::error($queryFlujo->createCommand()->getRawSql());
            //echo $queryFlujo->createCommand()->getRawSql();die();
            // var_dump($queryFlujo->one()->attributes);
            //Ahora verificamos que esta fase haya cumplido 
            // con todas las citas 
            $cuantashay = (integer) $queryFilter->andWhere(['flujo_id' => $actual])->count();
            yii::error('CUANTASHAY');
            yii::error($queryFilter->andWhere(['flujo_id' => $actual])->createCommand()->getRawSql());
            yii::error($cuantashay);
            $cuantasDebeHaber = (integer) $queryFlujo->select(['nsesiones'])->scalar();
            yii::error('CUANTASdDEBEHABER');
            yii::error($queryFlujo->select(['nsesiones'])->createCommand()->getRawSql());
            yii::error($cuantasDebeHaber);

            if ($cuantashay >= $cuantasDebeHaber) {
                //yii::error('CUANTAShay >= cuantas debe haber ');
                //var_dump($queryFlujo->one()->attributes);die();
                //yii::error('$queryFlujo->select(actividad)->one()->nextActividad()->actividad');
                //yii::error($queryFlujo->select(['actividad'])->one()->nextActividad()->actividad);
                return $queryFlujo->select(['actividad'])->one()->nextActividad()->actividad;
            } else {
                yii::error('CUANTAShay < cuantas debe haber ');
                yii::error('$queryFlujo->one()');
                yii::error($queryFlujo->select(['actividad'])->one());
                return $queryFlujo->select(['actividad'])->one()->actividad;
            }
        } else {
            return $idEtapa;
        }
    }

    public function idCitaFirstEvaluacion() {
        $citasId = Citas::find()->select(['id'])->where([
                    'talleresdet_id' => $this->talleresdet_id
                ])->column();
        $idCitasConExamenes = Examenes::find()->select(['citas_id'])->
                        where(['citas_id' => $citasId])->orderby('citas_id asc')->column();
        return (count($idCitasConExamenes) > 0) ? $idCitasConExamenes[0] : null;
    }

    public static function desgracias() {
        return [
            'alcohol', 'alcoho', 'droga', ' delincue',
            'asesinato', 'violencia', 'separacion', 'separados', 'separacion',
            'separación', 'murió', 'muerto', 'muerte', 'murieron',
            'enferm', 'desahuaciado', 'cancer', 'cáncer', 'neoplasia', 'accidente',
            'tbc ', 'vih', 'divorc', 'denuncia', 'corazón', 'corazón', ' sida ',
            'cerebro', 'higado', 'hígado', 'próstata', 'prostata', 'utero', 'uterino',
            'aborto', ' toc ', ' obsesi', ' fobia', ' pánico', 'psiquiatr',
            'medicina', 'médico', 'pesadilla', 'insomnio', 'desmayo', 'cefalea',
            'desemple', 'hambre', 'deceso', 'falleci', 'páncreas', 'gastritis',
            'psicopa', 'legrado', ' viola', 'crimen', 'estómago', 'provincia',
            'transtorno', 'depresi', 'ansiedad', 'llanto', 'accidente',
            ' dolor ', 'pastillas', 'clonazep', 'sertralina', 'fluoxetina',
            ' frustraci', ' odio ', ' resentimiento', ' acoso', 'acosad', 'chantaje',
            'extorsi', 'asalto', 'hospital', ' manía', ' vicio', 'fumador',
            'ludopa'
        ];
    }

    /*
     * Devuelve un
     * array con las coincidencias de probelmas 
     * graves de alumno en dicha cita 
     */

    public function arrayAlertas() {
        $coincidencias = [];
        foreach (array_keys($this->secretFields) as $nombrecampo) {
            $texto = $this->{$nombrecampo};
            foreach (static::desgracias() as $clave => $desgracia) {
                if (!(strpos($texto, $desgracia) === false)) {
                    $coincidencias[$nombrecampo] = $desgracia;
                }
            }
        }
        return $coincidencias;
    }

    public function hasProblems() {
        return(count($this->arrayAlertas()) > 0) ? count($this->arrayAlertas()) : false;
    }

    /*
     * Esta funcion devuelve los "problemas"
     * Según plabras detectadas de todas las citas,
     * calificadas como asistio
     */

    public function arrayAlertasTotal() {
        $citasActivas = static::find()->where([
                    'talleresdet_id' => $this->talleresdet_id,
                    'asistio' => '1'])->all();
        $problems = [];
        foreach ($citasActivas as $cita) {
            $alertas = $cita->arrayAlertas();
            if (count($alertas) > 0) {
                $problems[$cita->numero] = $cita->arrayAlertas();
            }
        }
        return $problems;
    }

    /* Funcion para obtener el horario de del dia
     * Devuelve un registro activeRecord de la tabla Rangos
     * filtro  talleres_id y dia 
     */

    public function horarioToday() {
        $dia = $this->toCarbon('fechaprog')->weekDay();
        $criterio=[
                    'talleres_id' => $this->talleres_id,
                    'dia' => $dia,
                    'codtra'=>$this->codtra,
                   ];
       // var_dump($criterio);
        $rango = Rangos::findOne($criterio);
       
        //var_dump($dia);die();
        return $rango;
    }

    /*
     * Esta funcion busca una nueva fecha probable para 
     * reprogramar la cita, la mas proxima, segun el dia 
     * que le toca atender al psicologo, la fecha es la mas proxima 
     * 1) Se fija la fechaporg actual 
     * 2) Luego busca la fecha porxima que viene el spicolo
     *    segun la tala rangos del programa 
     * 
     */

    public function searchNextDate() {
        $dia = $this->horarioToday()->dia;
    }

    /*
     * Esta función recicla el examen de una cita determinada 
     * quiere decir por ejemplo que si un Alumno a abierto su token
     * y no ha confirmado su respuesta, se considera ABANDONO DEL
     * EXAMEN.
     * 
     * Se tiene que reciclar estas preguntas y la cita debe de quedar
     * como INASISTENCIA
     * 
     * 
     * 
     */

    public function reciclaExamen() {
        
    }

    /*
     * Indica si el alumno ya ha conirnado sus repsuestas del examen
     */

    public function hasPerformedTest() {
        $idExamenes = $this->examenesId();

        // yii::error($idExamenes);
        if (count($idExamenes) == 0)
            return false;
        $nrespondidas = StaExamenesdet::find()->andWhere(['not', ['valor' => null]])->
                        andWhere(['examenes_id' => $idExamenes])->count();
        //yii::error(StaExamenesdet::find()->andWhere(['not',['valor'=>null]])->
        // andWhere(['examenes_id'=>$idExamenes])->createCommand()->getRawSql());
        $ntotales = StaExamenesdet::find()->andWhere(['examenes_id' => $idExamenes])->count();
        //yii::error(StaExamenesdet::find()->andWhere(['examenes_id'=>$idExamenes])->createCommand()->getRawSql());
        if ($ntotales == 0)
            return false;
        return (($nrespondidas / $ntotales) >= 1) ? true : false;
    }

    /*
     * Indica nsi elalumno aun no ha abierto el link del correo 
     * true: NO ha aierto el examen
     * false: Y aha brio el examen
     */

    public function isTokenActive() {
        $token = \common\components\token\Token::exists('citas', 'token_' . $this->id);
        return (!is_null($token)) ? true : false;
    }

    public function nReprogramaciones() {
        return $this->getLog()->count();
    }

    /*
     * Registra le lgo de reprogramacion */

    public function registraLog($oldFecha) {
        //var_dump($oldFecha,$this->fechaprog);die();
        StaCitaLog::firstOrCreateStatic(
                ['citas_id' => $this->id,
                    'fecha' => $oldFecha,
                    'nuevafecha' => $this->fechaprog,
                ]
        );
    }

    /*
     * Esta funcion devuelve un query para hallar todas las citas hábiles 
     * de un alumno , las que asistieron y las que aun no vencen
     * 
     * EL criterio:   Todas a quellas citas que cumplen la siguiente condicion
     * 
     *  1) NO ES LA CITA ACTUAL 
     * 
     * 2) No son eventos 
     * 3) Que asistieron 
     * 
     * Además Unir las que estan activas:
     * 
     * 1) No son eventos
     * 2) Que no asistieron
     * 3) Pero que aún no tienen vencimiento
     * 
     * 
     */

    public function citasHabilesQuery() {
        $horas = h::gsetting('sta', 'nhorasreprogramacion');
        $filtro = $this->CarbonNow()->subHours($horas)->format(\common\helpers\timeHelper::formatMysqlDateTime());
        $query = static::find()->andWhere([
                    'talleresdet_id' => $this->talleresdet_id,
                    'masivo' => '0', 'asistio' => '1'])->orWhere(['and',
            'talleresdet_id=:talleresdet_id',
            'masivo=0', ['>', 'fechaprog', $filtro]
                ], [':talleresdet_id' => $this->talleresdet_id]);
        return $query;
    }

    public function isPossibleToChange($new_flujo) {
        if (in_array($new_flujo, $this->possibleFlujosToChange())) {
            IF ($this->flujo_id <> $new_flujo) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
     * Ubica los posible flujos a los que pouede camabir dicha cita 
     * los flujos que pertencen a una taller son imposibles de cambiar */

    public function possibleFlujosToChange() {
        $flujos = [];
        $flujosInferiores = StaFlujo::idsFlujosNotEventoLessThan($this->flujo_id);

        if (count($flujosInferiores) > 0) {

            $flujoAnterior = max($flujosInferiores);

            /* Verificamos los flujos de la cita anteriorr */
            $citaanterior = $this->citasHabilesQuery()->
                            andWhere(['<', 'fechaprog', $this->swichtDate('fechaprog', false)])
                            ->andWhere(['flujo_id' => $flujoAnterior])->one();
            if (is_null($citaanterior)) {
                $flujos[] = $flujoAnterior;
            }
        }

        return array_map('intval', $flujos);

        /*

          $citasiguiente=$this->citasHabilesQuery()->
          andWhere(['>','fechaprog',$this->swichtDate('fechaprog', false)])->one();

          if(!is_null($citaanterior))
          $flujos[]=$citaanterior->flujo_id;
          if(!is_null($citasiguiente))
          $flujos[]=$citasiguiente->flujo_id;
          return $flujos; */
    }

    public function belongsToTaller() {
        return ($this->flujo->esevento && is_null($this->flujo->examen));
    }

    public function lastCitaBytutoria(){
        $codperiodo = $this->tallerdet->talleres->codperiodo;
        $ids=StaFlujo::idsFlujosNoEventos($codperiodo);
       return self::find()->andWhere([
            'flujo_id'=>$ids,
            'talleresdet_id'=>$this->talleresdet_id,
            /*'fechaprog'=>$ids*/ ])->
            andWhere(['<', 'fechaprog',
                $this->swichtDate('fechaprog', false)
                ])
             ->orderBy(['fechaprog'=>SORT_DESC])->one();
        
    }
    public function diasPasadosUltimaCitaByTutoria(){
        $registro=$this->lastCitaBytutoria();
       if(is_null($registro))
        return 0;
       $dias=$this->toCarbon('fechaprog')->diffInDays($registro->toCarbon('fechaprog'));
       return $dias;
    }
    
    /*
     * Esta función registra un indicadortrabajado
     */
    public function registraIndicadorTrabajado(){
        $indi=$this->flujo->indicador_id;
        if(!is_null($indi) and  in_array($this->flujo_id, StaFlujo::idsFlujosEventos())){
             $campos=[
            'codfac'=>$this->taller->codfac,
            'citas_id'=>$this->id,
            'talleresdet_id'=>$this->talleresdet_id,
            'indicador_id'=>$indi
                ];
                StaCitaIndicadores::firstOrCreateStatic($campos);
        }else{
            yii::error('No se encontró el valor indicador_id , revise ',__FUNCTION__);
        }
       
        
    }
    
    /*
     * Verifica que hay una cita con prueba abierta
     * O efectuada, quiere decir ue si existe devolvera 
     * el activerecord de esta cita
     * En caso de no existir, que da libre para 
     * enviar el troken y generar el banco de pruebas
     * Si noi encuentra ningna cita con
     * prueba virgen o desarrollada devuelve null
     */
    public function otherCitaWithTest(){
        /*Sacanos las ciotas 
          de este alumno qpero que tengna el mismo 
         * flujo y que sean diferentes a la atual
         */
        $citas = self::find()->andwhere(
                [
                    'talleresdet_id' => $this->talleresdet_id,
                    'flujo_id'=>$this->flujo_id,
                ])
          ->andWhere(['<>', 'id', $this->id])->all();
        /*Recoremos y verificams*/
        
       foreach($citas as $cita){
           if($cita->hasPerformedTest()){
               return $cita;
           }elseif($cita->isVencida()){
               
           }else{
               return $cita;
           }
       }
       return null; 
      
    }
  
    public function isEvaluacion(){
        return in_array($this->flujo_id,StaFlujo::idsFlujosEvaluaciones());
    }
    /*
     * veriica si la cita es una evaluacion y esta vencida
     * ademas no ha rendido evaluacion
     */
    public function isLiberable(){
       return ($this->isEvaluacion() && $this->isVencida() && !$this->hasPerformedTest());
    }
    /*
     * ESTA FUNCION VALESOLO PARA CITAS DE EVALUACIO
     * 1) pRIMERO S EFIJA SI ES EVALUACION
     * 2) lUEGO S EFIJA SI ESTA VENCIDA
     * 3) lUEGO SI ESTA VENCIDA DESHACE LA ASISTENCIA
     *    DE LA CITA Y DE SU EVENTO CORRESPONDIENTE
     *    LUEGO LO LIBERA DEL EVENTO, CON ESTO 
     *    DEJA LIBRE AL ALUMNO PARA QUE PUEDA SER EVALUADO
     */
    public function liberarCita(){
        if($this->isLiberable()){
            $oldScenario=$this->getScenario();
            $this->setScenario(self::SCENARIO_ASISTIO);
            $this->asistio=false;
            if(!$this->save())
            return ['error'=>yii::t('sta.labels','No se pudo '.$this->getFirstError())];
            $this->clearErrors();
            $this->setScenario($oldScenario);
            /*Unicando al detalle evento*/
            $eventodetalle=StaEventosdet::findOne(['numerocita'=>$this->numero]);
            if(!is_null($eventodetalle)){
               $eventodetalle->setScenario($eventodetalle::SCENARIO_ASISTENCIA);
               $eventodetalle->asistio=false;
               $eventodetalle->libre=true;
              if(!$eventodetalle->save())
               return ['error'=>yii::t('sta.labels','No se pudo '.$eventodetalle->getFirstError())];
             
              
            }
            
            
        }else{
            return ['error'=>yii::t('sta.labels','Esta cita no es liberable, revise bien')];
        }
        return [];
    }
    
}
