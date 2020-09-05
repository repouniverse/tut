<?php
namespace common\actions;
use common\helpers\h;
use yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActionAddMaletin extends \yii\base\Action
{
	
	public function run()
	{
           
	 if(h::request()->isPost && h::request()->isAjax){
          h::response()->format = \yii\web\Response::FORMAT_JSON;
         $sesion=h::session();
         $datos=[];
         $datos=h::request()->post('selection');
         $preserve=h::request()->post('preserve',false);
         //$borrar=h::request()->get('borrar',false);
      // VAR_DUMP($datos);DIE();
        if(!is_null($datos)){ 
         // $datos= \yii\helpers\Json::decode($datos);
          $i=0;
          foreach($datos as $nombre=>$valores){
              $datos[$nombre]=$valores;
                  $i++;
              /*if(!$sesion->has(h::SESION_MALETIN)){
                  
              }else{
                  if(array_key_exists($nombre, $sesion[h::SESION_MALETIN])){
                      $datos[$nombre]=($preserve)?array_merge($sesion[h::SESION_MALETIN],$valores):$valores; 
                      $i++;
                      }else{
                          
                      $datos[$nombre]=$valores; 
                      $i++;
                  }
              }*/
          }
          /*Finalmente igualemos a la sesion*/
          
          IF($preserve &&  is_array($sesion[h::SESION_MALETIN])){
              
              $datos=array_merge($sesion[h::SESION_MALETIN],$datos);
          }
          $datos= array_values(array_unique($datos));
          $sesion[h::SESION_MALETIN]=$datos;
         //yii::error($sesion[h::SESION_MALETIN]);
         return ['success'=> yii::t('sta.errors','Se agregaron al maletín {elementos}',['elementos'=>$i])];
          }else{
              return ['success'=>yii::t('sta.errors','No se pasaron datos')];
          }
     }else{
         echo "no es ajax";
     }
          }
}