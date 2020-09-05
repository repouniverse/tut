<?php
namespace common\actions;
use common\helpers\h;
use yii;
class ActionFlushMaletin extends \yii\base\Action
{
	
	public function run()
	{
          if( h::request()->isAjax){
             h::response()->format = \yii\web\Response::FORMAT_JSON;  
             $sesion=h::session();
          if($sesion->has(h::SESION_MALETIN)){
             $sesion[h::SESION_MALETIN]=[]; 
              return ['success'=> yii::t('sta.errors','Se limpió el maletín')];
          }
          
          
          }
          
          
          }
}
