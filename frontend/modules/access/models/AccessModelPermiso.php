<?php

namespace frontend\modules\access\models;
//use \frontend\modules\access\models\modelSensibleAccess;
use Yii;

/**
 * This is the model class for table "{{%access_model_permiso}}".
 *
 * @property int $id
 * @property string $modelo
 * @property string $permiso
 * @property string $activo
 */
class AccessModelPermiso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public $booleanFields=['activo'];
    public static function tableName()
    {
        return '{{%access_model_permiso}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modelo', 'activo'], 'required'],
             [['activo'], 'safe'],
            [['modelo', 'permiso'], 'string', 'max' => 200],
            [['activo'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'modelo' => Yii::t('sta.labels', 'Modelo'),
            'permiso' => Yii::t('sta.labels', 'Permiso'),
            'activo' => Yii::t('sta.labels', 'Activo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AccessModelPermisoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccessModelPermisoQuery(get_called_class());
    }
    
    public static function generateNamePersmission(){
        return 'p_'.\common\helpers\FileHelper::getShortName(self::className(), '\\');
    }
    
    public function afterFind() {
        parent::afterFind();
        $this->activo=($this->activo=='1')?true:false;
    }
    public function beforeSave($insert) {
       $this->activo=($this->activo==true)?'1':'0';
        if($insert){
            $auth = Yii::$app->authManager;
               //$auth->removeAll();
            $createPerm = $auth->createPermission($this->permiso);
             $createPerm->description = 'Documentos de alumno';
              $auth->add($createPerm);
        }
        
        
        
         return parent::beforeSave($insert);
    }
}
