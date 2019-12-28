<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\interfaces\colectoresInterface;
use common\models\masters\Clipro;
use common\models\masters\Documentos;
use common\helpers\h;
use Yii;
use common\behaviors\FileBehavior;
/**
 * This is the model class for table "{{%sigi_cuentaspor}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property string $codocu
 * @property string $descripcion
 * @property string $fedoc
 * @property int $mes
 * @property string $anio
 * @property string $detalle
 * @property string $fevenc
 * @property string $monto
 * @property string $igv
 * @property string $codestado
 *
 * @property SigiEdificios $id0
 */
class SigiCuentaspor extends \common\models\base\modelBase 

{
    const SCENARIO_RECIBO_INTERNO='interno';
    const SCENARIO_RECIBO_AUTOMATICO='auto';
    const COD_RECIBO_INTERNO='122';
    const ESTADO_CREADO='CREADO';
    const ESTADO_ANULADO='ANULADO';        
    public $dateorTimeFields=['fedoc'=>self::_FDATE,
        'fevenc'=>SELF::_FDATE];
   protected $Mycolector;
    
    
    /*public function __construct(colectoresInterface $colector) {
        $this->Mycolector=$Colector;
        parent::__construct($config);
        
    }*/
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_cuentaspor}}';
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
            [['edificio_id','colector_id','codpro','fedoc', 'codocu',
                'descripcion', 'mes', 'anio', 'monto'], 
                'required','except'=>self::SCENARIO_RECIBO_INTERNO],
            [['edificio_id', 'mes'], 'integer'],
            [['detalle'], 'string'],
             [['codpro','codmon'], 'safe'],
            /*ESCENARIO RECIBO INTERNO */
            [['edificio_id','unidad_id','colector_id','fedoc','descripcion',
                'mes','anio','monto','codmon','codpro','detalles'],
              'safe','on'=>self::SCENARIO_RECIBO_INTERNO
             ],
            [['edificio_id','unidad_id','colector_id','fedoc','descripcion',
                'mes','anio','monto','codmon','codpro'],
              'required','on'=>self::SCENARIO_RECIBO_INTERNO
             ],
            /*FIN DE ESCENARIO INTERNO */
            
             /*ESCENARIO RECIBO AUTOMATICO */
            [['facturacion_id','edificio_id','numerodoc','descripcion','codpro','fedoc',
                'mes','anio','monto','codmon','colector_id','detalle'],
              'safe','on'=>self::SCENARIO_RECIBO_AUTOMATICO
             ],
            [['facturacion_id','edificio_id','numerodoc','descripcion','codpro','fedoc',
                'mes','anio','monto','codmon','colector_id'],
              'required','on'=>self::SCENARIO_RECIBO_AUTOMATICO
             ],
            /*FIN DE ESCENARIO RECINBO AUTOMATRICO */
            
            
            [['monto'], 'number'],
            [['codocu'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['fedoc', 'fevenc', 'igv', 'codestado'], 'string', 'max' => 10],
            [['anio'], 'string', 'max' => 4],
           // [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio'),
            'colector_id' => Yii::t('sigi.labels', 'Colector'),
            'codocu' => Yii::t('sigi.labels', 'Documento'),
             'codpro' => Yii::t('sigi.labels', 'Emisor'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
            'fedoc' => Yii::t('sigi.labels', 'F. Docu'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'anio' => Yii::t('sigi.labels', 'Año'),
            'detalle' => Yii::t('sigi.labels', 'Detalle'),
            'fevenc' => Yii::t('sigi.labels', 'F. Venc'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
             'codmon' => Yii::t('sigi.labels', 'Moneda'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'codestado' => Yii::t('sigi.labels', 'Estado'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad'),
        ];
    }
 public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_RECIBO_INTERNO] = ['facturacion_id','edificio_id','unidad_id','codpro','colector_id','fechadoc','descripcion','mes','anio','monto','codmon'];
        //$scenarios[self::SCENARIO_UPDATE_TABULAR] = ['codigo','coditem','tarifa'];
       // $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];*/
        return $scenarios;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    public function getDocumento()
    {
        return $this->hasOne(Documentos::className(), ['codocu' => 'codocu']);
    }
    public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }

    /**
     * {@inheritdoc}
     * @return SigiCuentasporQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiCuentasporQuery(get_called_class());
    }
    
    
    public function valoresDefault(){
        $this->anio=date('Y');
        $this->mes=date('m');
        $this->codmon=h::gsetting('general', 'moneda');
    }
    
      
    public function getColector(){
        return $this->hasOne(SigiCargosedificio::className(), ['id' => 'colector_id']);
    }
    
    /*******************************************************
     * Obriene le data provier para su resspectivco colector
     * Es decir para colectores con meddores de agua 
     * obtinene las lecturas, 
     * Para colcores que dependen de lpresupeusto
     * deuelve los registros de las partidas correspondientes
     * ****************************************************
     * 
     */
    public function provider(){
       
    }
    
    
    private function resolveFieldsDefault(){
        if($this->getScenario()==self::SCENARIO_RECIBO_INTERNO){
            $this->codocu=SELF::COD_RECIBO_INTERNO;
            $this->numerodoc=$this->generateNumero();
            // $this->codpro=$this->generateNumero();
        }
    }

  private function generateNumero(){
      return '994950y4';
  } 
  
  public function beforeSave($insert) {
      if($insert){
          $this->resolveFieldsDefault();
      }
      return parent::beforeSave($insert);
  }
  
  public function generateRecibosAuto($mes){
      $colectores=$this->edificio->colectores;
       foreach($colectores as $colector){
          if($colector->isBudget()){
              
              
              
             $this->createRecibo($monto,$mes);
          }
       }  
  }
  
  private function createRecibo($attributes){
      
  }
  
  
  
    
 }
       
       

