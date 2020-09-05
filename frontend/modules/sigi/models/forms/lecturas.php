<?php
namespace frontend\modules\sigi\models\forms;
class lecturas extends \yii\base\Model{
 public $flectura;
 public $mes;
  public $mesconsumo;
  public function rules()
    {
        return [
            //['username', 'filter', 'filter' => 'trim'],
            [['flectura', 'mes', 'mesconsumo'], 'required'],
            //['flectura', 'validateFecha'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function validateFecha($attribute,$params){
        
    }
}

    


