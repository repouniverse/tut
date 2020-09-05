<?php

namespace frontend\modules\sigi\models;
use yii\db\Query;
use backend\components\Installer;
use common\helpers\h;
use yii\data\ActiveDataProvider;
use Yii;
use mdm\admin\models\form\Signup;
/**
 * This is the model class for table "{{%sta_user_facultades}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $codfac
 * @property string $activa
 *
 * @property StaFacultades $codfac0
 */
class SigiUserEdificios extends \common\models\base\modelBase
{
    public $booleanFields=['activa'];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_user_edificios}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['edificio_id'], 'integer'],
           // [['activa'], 'string', 'max' => 1],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'user_id' => Yii::t('sta.labels', 'User ID'),
            'edificio_id' => Yii::t('sta.labels', 'edificio_id'),
            'activa' => Yii::t('sta.labels', 'Activa'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    

    /**
     * {@inheritdoc}
     * @return UserFacultadesQuery the active query used by this AR class.
     */
    public static function find()
    {
        
          return new \yii\db\ActiveQuery(get_called_class());  
       
        
    }
    
   public function getEdificio(){
       return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
   }
    
    /*Refresca los valores de la tabla 
     * segun se hayan agregado faultades 
     * o falte algun registro 
     */
    public static function refreshTableByUser($iduser=null){
        if(is_null($iduser))
        $iduser=h::userId();
       $edificios=static::idEdificios();
       //var_dump($edificios);die();
     foreach($edificios as $key=>$id){
          static::firstOrCreateStatic([
                    'user_id'=>$iduser,
                     'edificio_id'=>$id,
                     //rr'activa'=>'0',
                    ]);
      }
      return $edificios;
    }
    
    private static function query(){
        return new Query;
    }
    /*
    private static function tableUser(){
        return h::user()->identity->tableName();
    }*/
    private static function idEdificios(){
        return Edificios::find()->select('id')
             ->asArray()->column();
    }
    /* private static function idUsers(){
        return static::query()->select('id')->
            from(static::tableUser())
              ->where(
                      ['status'=>
                        \common\models\User::STATUS_ACTIVE
                      ])->all();
    }*/
    
    
   /*Devuelve un data provider de lso facultades user por usuario 
    * Observe que hace reerencia a la clase Parametroscentrosdocu tabla
    *   'parametrosdocucentros'
    */
   public static function providerEdificios($iduser=null){
            return new ActiveDataProvider([
                'query' =>static::find()->where(['user_id'=>is_null($iduser)?h::userId():$iduser]),
                'pagination' => [
                    'pageSize' => 20,
                            ],
                                    ]);
        } 
    
        
        public static function providerEdificiosAll($iduser=null){
          
            return new ActiveDataProvider([
                'query' =>static::find(false)->where(['user_id'=>is_null($iduser)?h::userId():$iduser]),
                'pagination' => [
                    'pageSize' => 20,
                            ],
                                    ]);
        } 
        
   public static function filterEdificios($iduser=null){
      return static::find()->
               select('id')->
               andWhere(['user_id'=>is_null($iduser)?h::userId():$iduser,'activa'=>'1'])->asArray()->column();
   }   
   
   public function generateUsersResidentes($idedificio){
       $edificio=Edificios::findOne($idedificio);       
     foreach($edificio->queryPropietariosActivos()->asArray() as $propietarioArray){
         if(!empty($propietarioArray['correo'])){
             $user=New Signup();
            $user->username = $propietarioArray['tipo'].'_'.$propietarioArray;
            $user->email = $propietarioArray['correo'];
            $user->password =Installer::generateRandomString(4);
            $user->signup();unset($user);
         }
      }
         
       
   }
        
}
