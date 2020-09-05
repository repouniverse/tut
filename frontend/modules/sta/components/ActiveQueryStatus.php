<?php
namespace frontend\modules\sta\components;
use frontend\modules\sta\models\Facultades;
use common\helpers\h;
/* 
 * Esta clase es la que efectua los filtros por facultad segun 
 * el perfil del ususario; es decir 
 * cualquier persona no puede visulaizar registros de otras facultades
 * por convencion el campo de criterio es el campo
 * "codfac" 
 */
class ActiveQueryStatus extends ActiveQueryScope
{
  public function init()
    {
       $this->andWhere([
              'status'=> ['N','I']
               ]);
        parent::init();
    }
    
  public function completeFacultades(){
       return  $this->orWhere(['in',
              'codfac',Facultades::find()->select('codfac')->asArray()->all()
               ])->andWhere([
              'status'=> ['N','I']
               ]);
   } 
   public function complete(){
       return  $this->orWhere(['status'=>'R']);
   } 
    
}

