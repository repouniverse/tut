<?php

namespace frontend\modules\sta\models;
use common\behaviors\FileBehavior;
use Yii;
use frontend\modules\sta\traits\testTrait;
use frontend\modules\report\models\Reporte;


/**
 * This is the model class for table "{{%sta_test}}".
 *
 * @property string $codtest
 * @property string $descripcion
 * @property string $opcional
 * @property string $version
 * @property int $nveces
 * @property int $id
 * @property string $codocu
 * @property int $reporte_id
 *
 * @property StaExamenes[] $staExamenes
 * @property StaTestcali[] $staTestcalis
 * @property StaTestdet[] $staTestdets
 */
class Test extends \common\models\base\modelBase
{
  use testTrait;
  const DOCUMENTO_TEST='800';
    public static function tableName()
    {
        return '{{%sta_test}}';
    }
public $booleanFields=['opcional'];
  public $hardFields=['codtest'];  
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
<<<<<<< HEAD
            [['codtest', 'descripcion', 'opcional', 'version','reporte_id'], 'required'],
=======
            [['codtest', 'descripcion', 'opcional', 'version','codbateria'], 'required'],
>>>>>>> e4b47ce01ec1bf57231883a79bf995c89c46af44
            [['nveces', 'id', 'reporte_id'], 'integer'],
              [['codbateria', 'reporte_id','orden','detalles'], 'safe'],
            [['codtest'], 'string', 'max' => 8],
            [['descripcion'], 'string', 'max' => 40],
            //[['opcional'], 'string', 'max' => 1],
            [['version'], 'string', 'max' => 5],
            [['codocu'], 'string', 'max' => 3],
            [['codtest'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codtest' => Yii::t('app', 'Codtest'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'opcional' => Yii::t('app', 'Opcional'),
            'version' => Yii::t('app', 'Version'),
            'nveces' => Yii::t('app', 'Nveces'),
            'id' => Yii::t('app', 'ID'),
            'codocu' => Yii::t('app', 'Codocu'),
            'reporte_id' => Yii::t('app', 'Reporte ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaExamenes()
    {
        return $this->hasMany(Examenes::className(), ['codtest' => 'codtest']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaTestcalis()
    {
        return $this->hasMany(StaTestcali::className(), ['codtest' => 'codtest']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestdets()
    {
        return $this->hasMany(StaTestdet::className(), ['codtest' => 'codtest']);
    }

    /**
     * {@inheritdoc}
     * @return TestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestQuery(get_called_class());
    }
    public function getCalificiones(){
       return $this->hasMany(StaTestcali::className(), ['codtest' => 'codtest']);
   
    }
    
    public function getReporte(){
       return $this->hasOne(Reporte::className(), ['id' => 'reporte_id']);
   
    }
    
    public function arrayCalificaciones(){
       return array_column( $this->getCalificiones()->select(['valor','descripcion'])->asArray()->all(),'descripcion','valor');
    }
    
    public function beforeSave($insert){
        $this->codocu=self::DOCUMENTO_TEST;
        return parent::beforeSave($insert);
    }
}
