<?php
namespace common\actions;
use common\helpers\h;
use common\helpers\ComboHelper;
USE yii\helpers\Html;
use yii;
/* 
 * Este action se encara de delcover datos de un comoheloper 
 * dado un filtro nada mas
 * 
 */

class ActionCombodependienteCombo extends \yii\base\Action
{	
	public function run(){
	//Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          // yii::error('inicinaod');
            /*$modelo= h::request()->post('clase');*/
            $valorfiltro=h::request()->post('filtro');
            /*$campoclave=h::request()->post('campoclave');
            $camporef=h::request()->post('camporef');*/
           $isremote=h::request()->post('isremotesource');
           $functionCombo=h::request()->post('source');
           if($isremote=='yes'){
               // yii::error('es remotop');
             $functionCombo=array_keys($source)[0];
            //var_dump($source);die();
             //$valorfiltro='20';
            // yii::error($modelo);  
             $datos=$claseCombo::{$metodo}(
                     $valorfiltro);
            // yii::error($datos); 
             //print_r($datos);die();
            // array_unshift($datos,[''=>yii::t('base.verbs','--Seleccione un Valor--')]);
             //$datos['']=yii::t('base.verbs','--Seleccione un Valor--');
              //yii::error( $datos);
             $datos=[''=>yii::t('base.verbs','--Seleccione un Valor--')]+$datos;
           }else{/*Se traa de datos directametne */
               $datos=$source;
             
           }
           yii::error( $datos);
          return $this->generateHtml($datos);   
        }
        
        private function generateHtml($datos){
           return  Html::renderSelectOptions('', $datos);
        }
}