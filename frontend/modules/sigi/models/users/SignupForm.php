<?php
namespace frontend\modules\sigi\models\users;
use frontend\models\SignupForm as SignupOriginal;

use yii\base\Model;
use mdm\admin\components\UserStatus;
use common\models\User;

use yii;
/**
 * Signup form
 */
class SignupForm extends SignupOriginal
{
    
   

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' =>yii::t('base.errors','This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ///['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => '\common\models\User', 'message' => yii::t('base.errors','This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 2],
            
            ['status', 'safe', 'on' => 'createx'],
            ['status', 'required', 'on' => 'createx'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        
        
        if ($this->validate() && !$this->alreadyExists($this->username)) {
           // $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
              $user->status = UserStatus::ACTIVE;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                $identidad=$user->getId();
                 $auth = Yii::$app->authManager;
               $authorRole = $auth->getRole('r_visitas');
                $auth->assign($authorRole,$identidad );
                $user->getProfile($identidad, \frontend\modules\sigi\Module::PROFILE_RESIDENTE);
                return true;
            } else{
                return $user->getErrors();
            }
        }else{
           return $this->getErrors(); 
        }
        
    }
  
   public function alreadyExists($name){
      return  User::find()->where(['username'=>trim($name)])->exists();
   }
    
   
}

