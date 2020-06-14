<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\components\ActiveQueryScope;
use frontend\modules\sta\staModule;
use frontend\modules\sta\models\Alumnos;
use frontend\modules\sta\models\Cursos;
use Yii;
use common\behaviors\FileBehavior;
/**
 * This is the model class for table "{{%sta_aluriesgo}}".
 *
 * @property int $id
 * @property int $entrega_id
 * @property string $codcur
 * @property string $codalu
 * @property int $nveces
 *
 * @property StaAlu $codalu0
 * @property StaMaterias $codcur0
 */
class Aluriesgo extends \common\models\base\modelBase
{
    const SCENARIO_REGISTER='registro';
    const SCENARIO_REGISTER_NORMAL='registro_normal';
    const FLAG_RETIRADO='R';
    const FLAG_INCORPORADO='I';
    const FLAG_NORMAL='N';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_aluriesgo}}';
    }

    public function behaviors()
            {
	return [
		
		'fileBehavior' => [
			'class' => FileBehavior::className()
		],
            'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
           
		
                ];
            }
    
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entrega_id', 'nveces'], 'integer'],
             
             //[['descripcion'], 'string', 'max' => 40],
            [['codperiodo',
                'entrega_id',
                'codcur',
                'codalu', 
                'codfac',
                'codcar',
                'nveces',
                'nveces15'
                ],'required','on'=>'import'],
            [['status'],'safe'],
            [['codperiodo',
                //'entrega_id',
                'codcur',
                'codalu',
                'codfac',
                //'codcar',
                'nveces',
                'nveces15'
                ],'required','on'=>[self::SCENARIO_REGISTER,self::SCENARIO_REGISTER_NORMAL]],
            ['codalu', 'unique', 'targetAttribute' => 
                 ['codalu','codcur', 'codperiodo'],
              'message'=>yii::t('sta.errors',
                      'Esta combinacion de valores {codalu}-{codcur}-{codperiodo} ya existe',
                      ['codalu'=>$this->getAttributeLabel('codalu'),
                        'codcur'=>$this->getAttributeLabel('codcur'),
                          'codperiodo'=>$this->getAttributeLabel('codperiodo'),
                          //'codcar'=>$this->getAttributeLabel('codcar')
                          ]
                      )
                ],
            [['codcur'], 'string', 'max' => 10],
            [['codalu'], 'string', 'max' => 14],
             [['codalu'], 'validateCodigos', 'on' => self::SCENARIO_REGISTER],
            [['codalu'], 'exist', 'skipOnError' => true,'message'=>'no exiset alu', 'targetClass' => Alumnos::className(), 'targetAttribute' => ['codalu' => 'codalu']],
            [['codcur'], 'exist', 'skipOnError' => true, 'message'=>'no exiset mate','targetClass' => Materias::className(), 'targetAttribute' => ['codcur' => 'codcur']],
        [['codperiodo'], 'exist', 'skipOnError' => true,'message'=>'no exiset periodo', 'targetClass' => Periodos::className(), 'targetAttribute' => ['codperiodo' => 'codperiodo']],
            [['codcar'], 'exist', 'skipOnError' => true, 'message'=>'no exiset carerra','targetClass' => Carreras::className(), 'targetAttribute' => ['codcar' => 'codcar']],
            ];
    }

     public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios['import'] = [
            'codperiodo',
            'codcar',
            'codfac',
            'entrega_id',
            'nveces',
            'nveces15',
            'codcur',
            'codalu'];
        $scenarios[self::SCENARIO_REGISTER] = ['codalu','codfac', 'codcur', 'codperiodo','status','nveces','nveces15'];
         $scenarios[self::SCENARIO_REGISTER_NORMAL] = ['codalu','codfac', 'codcur', 'codperiodo','status','nveces','nveces15'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'entrega_id' => Yii::t('sta.labels', 'Id Entrega'),
            'codcur' => Yii::t('sta.labels', 'Cod. Curso'),
            'codalu' => Yii::t('sta.labels', 'Cod. Alumno'),
            'nveces' => Yii::t('sta.labels', 'N Repet'),
            'nveces15' => Yii::t('sta.labels', 'N Repet desde 2015'),
            'codperiodo' => Yii::t('sta.labels', 'Periodo'),
            'codfac' => Yii::t('sta.labels', 'Cod. Fac'),
             'codcar' => Yii::t('sta.labels', 'Cod. Espec'),
        ];
    }

   public function hasChilds() {
       return Talleresdet::find()->andWhere([
           'codalu'=>$this->codalu,
           'codfac'=>$this->codfac,
           'codperiodo'=>$this->codperiodo,
       ])->exists();
       
   }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno()
    {
        return $this->hasOne(Alumnos::className(), ['codalu' => 'codalu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMateria()
    {
        return $this->hasOne(Materias::className(), ['codcur' => 'codcur']);
    }
    
     public function getCurso()
    {
        return $this->hasOne(Cursos::className(), ['codcur' => 'codcur']);
    }
    
    
    public function getPeriodo()
    {
        return $this->hasOne(Periodos::className(), ['codperiodo' => 'codperiodo']);
    }
    public function getCarrera()
    {
        return $this->hasOne(Carreras::className(), ['codcar' => 'codcar']);
    }

    /**
     * {@inheritdoc}
     * @return AluriesgoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AluriesgoQuery(get_called_class());
    }
    /*
     * Devuelve toodos los alumnos 
     * Ojo que al ser hereadad de activequeryScope
     * devuelve los registros filtrados por facultad
     * segun los roles
   
     */
    public static function studentsInRisk($returnarray=true){
        if($returnarray)
       return $this->studentsInRiskQuery()->asArray()->all();
       return $this->studentsInRiskQuery()->all(); 
    }
    
    /*
     * Devuelve toodos los alumnos 
     * Ojo que al ser hereadad de activequeryScope
     * devuelve los registros filtrados por facultad
     * segun los roles
   
     */
    public static function studentsInRiskQuery(){
       //return static::find()->select('codalu','codperiodo')->distinct(); 
        $query = static::except()->select(
                [                   'codalu','codperiodo','status'
                    ]
                )
                ->distinct()/*->innerJoin(Alumnos::tableName(), Aluriesgo::tableName().'.codalu='. Alumnos::tableName().'.codalu')*/;
                
        return $query;
    }
    
    public static function studentsInRiskByFacQuery($codfac,$codperiodo=null){
        $codper=(is_null($codperiodo))?\frontend\modules\sta\staModule::getCurrentPeriod():$codperiodo;
       $query=self::studentsInRiskQuery();
        $query->andWhere([
               'codfac'=>$codfac,
               'codperiodo'=>$codper,
                   ]);
        return $query;
    } 
    
    public static function worstStudentsByFac($codfac,$codperiodo=null){
      $codper=(is_null($codperiodo))?staModule::getCurrentPeriod():$codperiodo;
      $query=static::except()->from(static::tableName().' t ')->select([
         'count([[t.codcur]]) as cant',
         'm.codalu','t.codperiodo',
         ])->innerJoin(Alumnos::tableName().' m ','[[t.codalu]]=m.codalu')
         ->addSelect(['m.ap','m.am','m.nombres'])->
              where([
                  '[[t.codfac]]'=>$codfac,
                  '[[t.codperiodo]]'=>$codper
                  ])->
        groupBy(['t.codalu','t.codperiodo','m.ap','m.am','m.nombres'])
        ->having(['>','count([[codcur]])',1])->
     orderBy('count([[codcur]]) DESC')->limit(5)->asArray()->all();
      
        return $query; 
    } 
     public static function worstStudentsByFacProvider($codfac,$codperiodo=null){
         //print_r(static::worstStudentsByFac($codfac,$codperiodo=null));die();
         return new \yii\data\ArrayDataProvider([
             //'key' => 'cant',
             'allModels'=>static::worstStudentsByFac($codfac,$codperiodo=null),
         ]);
     }
    
    public static function worstCursosByFac($codfac,$codperiodo=null){
      $codper=(is_null($codperiodo))?staModule::getCurrentPeriod():$codperiodo;
      $query=static::except()->from(static::tableName().' t ')->select([
         'count([[t.codcur]]) as cant',
         'm.codcur','m.nomcur','t.codperiodo'
         ])->innerJoin(Cursos::tableName().' m ','[[t.codcur]]=m.codcur')
         ->addSelect(['m.nomcur'])->
              where([
                  '[[t.codfac]]'=>$codfac,
                  '[[t.codperiodo]]'=>$codper
                  ])->
        groupBy(['m.codcur','t.codperiodo','m.nomcur'])
        ->having(['>','count([[t.codcur]])',1])->
     orderBy('count([[t.codcur]]) DESC')->limit(5)->asArray()->all();
      
        return $query; 
    } 
    
  public static function worstCursosByFacProvider($codfac,$codperiodo=null){
      //VAR_DUMP(static::worstCursosByFac($codfac,$codperiodo=null));DIE();
         return new \yii\data\ArrayDataProvider([
            // 'key' => 'cant',
             'allModels'=>static::worstCursosByFac($codfac,$codperiodo=null),
         ]);
     }
     
 public static function cursosByStudentPeriod($codalu,$codperiodo){
     return static::except()->where(['[[codperiodo]]'=>$codperiodo,
         '[[codalu]]'=>$codalu])/*->/*asArray()->*//*all()*/;
 } 
 
public static function cursosByStudentPeriodProvider($codalu,$codperiodo){
     /*return new \yii\data\ArrayDataProvider([
            // 'key' => 'cant',
             'allModels'=>static::cursosByStudentPeriod($codalu,$codperiodo),
         ]);*/
     return new \yii\data\ActiveDataProvider([
            // 'key' => 'cant',
             'query'=>static::cursosByStudentPeriod($codalu,$codperiodo),
         ]);
 } 
 
 public function validateCodigos($attribute,$params){
    /* var_dump(Alumnos::find()->where([
         'codalu'=>$this->codalu,
         'codfac'=>$this->codfac])->createCommand()->getRawSql(),
             Alumnos::find()->where([
         'codalu'=>$this->codalu,
         'codfac'=>$this->codfac])->exists());*/
     if(!(Alumnos::find()->where([
         'codalu'=>$this->codalu,
         'codfac'=>$this->codfac])->exists())){
          $this->addError ('codalu',yii::t('sta.labels','No se encontró registro de este alumno en esta facultad, verifique'));  
    
     }
     $alumno=Alumnos::findOne(['codalu'=>$this->codalu]);
     //var_dump($this->codalu,$alumno);die();
     if(!is_null($alumno)){
       if(!(Materias::find()->where([
         'codcur'=>$this->codcur,
          'codcar'=>$alumno->codcar,
             
             ])->exists())){
        $this->addError ('codcur',yii::t('sta.labels','No se encontró registro de este curso en esta facultad, verifique'));  
     
     }  
     }else{
       $this->addError ('codalu',yii::t('sta.labels','No se encontró registro de este alumno en el registro maestro'));  
      
     }
     
     
     if(!$this->isNewRecord){
         if($this->hasChilds() && $this->hasChanged()){
           $this->addError ('codalu',yii::t('sta.labels','No puede modificar este registro, porque ya tiene otros registros hijo'));  
       
         }
     }
     
    
 }
 
 public function beforeSave($insert){
     if($insert){
          $this->clase= \frontend\modules\sta\staModule::CLASE_RIESGO;
        
      if(IN_ARRAY($this->getScenario(),[self::SCENARIO_REGISTER,self::SCENARIO_REGISTER_NORMAL])) {
          $this->codcar=$this->alumno->codcar;
          //$this->status=self::FLAG_INCORPORADO;
      } 
       if($this->getScenario()==self::SCENARIO_REGISTER) {
          //$this->codcar=$this->alumno->codcar;
          $this->status=self::FLAG_INCORPORADO;
      } 
      if($this->getScenario()==self::SCENARIO_REGISTER_NORMAL) {
          //$this->codcar=$this->alumno->codcar;
          $this->status=self::FLAG_NORMAL;
      } 
     }
     return parent::beforeSave($insert);
 }
 
 public static function except(){
    return  self::find()->andWhere(['<>','status',self::FLAG_RETIRADO]);
 }
 
 
}
