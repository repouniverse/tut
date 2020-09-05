<?php
namespace frontend\modules\sta\components;
use frontend\modules\sta\models\UserFacultades;
use common\helpers\h;
use frontend\modules\sta\staModule;
/* 
 * Esta clase es la que efectua los filtros por facultad segun 
 * el perfil del ususario; es decir 
 * cualquier persona no puede visulaizar registros de otras facultades
 * por convencion el campo de criterio es el campo
 * "codfac" 
 */
class ActiveQueryScope extends \yii\db\ActiveQuery 
{
  public function init()
    {
      //var_dump(UserFacultades::filterFacultades());die();
       //$this->andWhere([ 'in', 'codfac',['FIM','FIP'] ]);
      $this->alias('t')->andWhere(['in',
              't.codfac', UserFacultades::filterFacultades()
               ])->andWhere(['clase'=>staModule::CLASE_REGULAR]);
        parent::init();
    }
    // HOLA MODIFICANDO

   
    
   public function complete(){
       return  $this->orWhere(['in',
              'codfac',Facultades::find()->select('codfac')->asArray()->all()
               ]);
   }
    
    
   
   /*
    * Cada que se efectue una llamada a un SQL
    * Siempre filtrará los valores de facultagitdes 
    * asignados en la tabla 'userfacultades' a cada usuario
    * sin necesidad de escribir la condicion una y otra vez
    * Se vale de los valores  devueltos porla funcion 
    * UserFacultades::filterFacultades()
    */
   /* public function all($db = null)
    {
        $this->andWhere(
              ['in',
              'codfac', UserFacultades::filterFacultades()
               ]
               );
        return parent::all($db);
    }*/
    
    /*public function active()
        {
          return $this->andWhere(
              ['in',
              'codfac', UserFacultades::filterFacultades()
               ]
               );
        }*/
}

