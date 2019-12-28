<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\models\SigiCargosedificio;
use Yii;

class SigiBasePresupuesto extends \common\models\base\modelBase
{
   const SCENARIO_IMPORTACION='importacion';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_base_presupuesto}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id','ejercicio','mensual','cargosedificio_id','cargosgrupoedificio_id'], 'required','except'=>self::SCENARIO_IMPORTACION],
            [['edificio_id'], 'integer'],
            [['cargosedificio_id','detalles','activo'], 'safe'],
            [['mensual', 'anual', 'acumulado'], 'number'],
            [['codgrupo', 'ejercicio'], 'string', 'max' => 4],
            [['codigo'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 40],
            //[['activo', 'restringir'], 'string', 'max' => 1],
            //[['codgrupo'], 'exist', 'skipOnError' => true, 'targetClass' => SigiGrupoPresupuesto::className(), 'targetAttribute' => ['codgrupo' => 'codigo']],
            
            
            /*
             * ESCENARIO Iportacion*/
             
            [['codgrupo'], 'exist', 'skipOnError' => true,
                'targetClass' => SigiCargosgrupoedificio::className(),
                'targetAttribute' => ['codgrupo' => 'codgrupo'],
                'on'=>'importacion',
               // 'message'=>yii('sigi.errors','El valor del campo \'cargo_id\' NO se encontro en la tabla {{sigi_cargos}}')
             ],
            [['codcargo'], 'exist', 'skipOnError' => true,
                'targetClass' => SigiCargos::className(),
                'targetAttribute' => ['codcargo' => 'codcargo'],
                'on'=>'importacion',
               // 'message'=>yii('sigi.errors','El valor del campo \'cargo_id\' NO se encontro en la tabla {{sigi_cargos}}')
             ],
            [['codcargo'], 'validateEdificio', 'skipOnError' => true,                
                'on'=>'importacion',
                'message'=>yii::t('sigi.errors','El valor del campo \'cargo_id\' NO se encontro en la tabla {{sigi_cargos}}')
             ],
            
            /*Campos obligatorios*/
            [['edificio_id','ejercicio','mensual','cargosedificio_id','cargosgrupoedificio_id'], 'required'],
            
            /*fiN DEL escenario imortacion*/
            
             [['edificio_id','codgrupo','codcargo','descripcion','ejercicio','anual'], 'required','on'=>self::SCENARIO_IMPORTACION],
            
            
        ];
    }

     public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCENARIO_IMPORTACION] = [
            'edificio_id','codgrupo','codcargo',/*'cargo_id','cargosgrupoedificio_id','cargosedificio_id',*/
            'codigo','descripcion','ejercicio','anual','detalles'];
        //$scenarios[self::SCENARIO_HIJO] = ['destalles','estreno','codtipo','numero','area','numero','area','npiso','nombre','participacion'];
// $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'codgrupo' => Yii::t('sigi.labels', 'Codgrupo'),
            'codigo' => Yii::t('sigi.labels', 'Codigo'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
            'activo' => Yii::t('sigi.labels', 'Activo'),
            'ejercicio' => Yii::t('sigi.labels', 'Ejercicio'),
            'mensual' => Yii::t('sigi.labels', 'Mensual'),
            'anual' => Yii::t('sigi.labels', 'Anual'),
            'restringir' => Yii::t('sigi.labels', 'Restringir'),
            'acumulado' => Yii::t('sigi.labels', 'Acumulado'),
            'cargosgrupoedificio_id'=>Yii::t('sigi.labels', 'Grupo'),
            'cargosedificio_id'=>Yii::t('sigi.labels', 'Colector'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoConcepto()
    {
        return $this->hasOne(SigiCargosedificio::className(), ['id' => 'cargosedificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
    public function getCargo()
    {
        return $this->hasOne(SigiCargos::className(), ['id' => 'cargo_id']);
    }
    
    public function getCargosGrupoEdificioFirme()
    {
        return $this->hasOne(SigiCargosgrupoedificio::className(), [
           'id'=> 'cargosgrupoedificio_id',
            
            ]);
    }
    
    
   /*Dsolo para cumplir con la importacion*/ 
    public function getCargosGrupoEdificio()
    {
        return $this->hasOne(SigiCargosgrupoedificio::className(), [
            'codgrupo' => 'codgrupo',
            
            ]);
    }
    
     /*Dsolo para cumplir con la importacion*/ 
    public function getCargosByCode()
    {
        return $this->hasOne(SigiCargos::className(), [
            'codcargo' => 'codcargo',
            
            ]);
    }
    


    /**
     * {@inheritdoc}
     * @return SigiBasePresupuestoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiBasePresupuestoQuery(get_called_class());
    }
    
    
    /*
     * Valida que el codcargo  y  codgrupo  pertenezcan a 
     * la tabla     SigiGruposedificio
     * UTIL PARA IMPORTACIONES DONDE EL SUUARIO NO SABE NADA DE ESTA 
     * TABLA INTERMEDIA  y no se quier comlicar con los ids 
     */
     public function validateEdificio($attribute, $params)
    {
         /*Solo verifica rque el codgrupo, este dentro del ediicio*/
         
         $cuantos=SigiCargosgrupoedificio::find()->where([
             'edificio_id'=>$this->edificio_id,
             'codgrupo'=>$this->codgrupo
           ])->count();
         if(!($cuantos>0))
             $this->addError ('codgrupo','El grupo \'{codigo}\' no existe en el edificio \'{edificio}\'',['codigo'=>$this->codgrupo,'edificio'=>$this->edificio_id]);
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->resolveFieldsToImport();
          if($this->cargosedificio_id >0)
            $this->resolveFieldsToIds ();
        }
        return parent::beforeSave($insert);
    }
    
    private function resolveFieldsToImport(){
       if($this->getScenario()==self::SCENARIO_IMPORTACION){
           $modelCargos=SigiCargos::find()->where(['codcargo'=>$this->codcargo])->one();
           $modelGrupoCargos=SigiCargosgrupoedificio::find()->where(
                    [
                        'codgrupo'=>$this->codgrupo,
                        'edificio_id'=>$this->edificio_id
                    ]
                    )->one();
          $modelCargosEdificio= SigiCargosedificio::find()->where(
                    [
                        'cargo_id'=>$modelCargos->id,
                         'grupo_id'=>$modelGrupoCargos->id,
                        'edificio_id'=>$this->edificio_id
                    ]
                    )->one();
            $this->cargo_id= $modelCargos->id;
            $this->cargosgrupoedificio_id=$modelGrupoCargos->id;            
            $this->cargosedificio_id=$modelCargosEdificio->id;
        } 
    }
 
    
    private function resolveFieldsToIds(){
           $modelCargosEdificio= SigiCargosedificio::findOne($this->cargosedificio_id);
            $this->edificio_id=$modelCargosEdificio->grupo->edificio_id;
            $this->cargo_id= $modelCargosEdificio->cargo->id;
            $this->cargosgrupoedificio_id=$modelCargosEdificio->grupo->id;            
            $this->cargosedificio_id=$modelCargosEdificio->id;
        
    }
}
