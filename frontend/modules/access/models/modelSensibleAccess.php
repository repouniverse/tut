<?php
/*
 * Creador : Julian Ramírez Tenorio  jramirez@neotegnia.com
 * 15/12/2018
 * Esta clase descendiente de la clase modelBase, 
 * Tiene la particularidad de almacenar metainformacion
 * para permtir el acceso no a ciertos recursos del 
 * sistema como las descargas y lso accesosa a los reportes
 * según ciertos roles , recordar que debe de haber un control
 * muy aparte de los accesos a los Actions; Dentro de ellos
 * por ejemplo, ¿Como prodrías controlar por ejemplo las descargas
 * de un recurso, de modo que unos puedan acceder a unas descargas y otros 
 * a otras descargas segun roles y permisos??
 * ¿COmo podrias controlar la visualizacion de unos reportes
 * dentro de un mismo Action??
 * 
 */
namespace frontend\modules\access\models;
use Yii;
use common\models\base\modelBase;
use common\helpers\h;

class modelSensibleAccess extends modelBase
{
  
    
    
    /*
     * nombre del campo criterio para 
     * filtrar lso accesos
     */
public $nameFieldCriteria='codcen';
 /*
     * nombre del campo criterio para 
     * veriifcar la identidad ed usuario
     */
public $nameFieldUserId='user_id';

 /*
     * nombre del campo criterio para 
     * veriifcar la identidad de la organizacion
     */
public $nameFieldOrgId='company_id';

/*Verifica que el registro actual es propiedad
 * del usuario acticvo, por ejemlo 
 * un post o un informe personal, o un correo 
 * privado
 * $model->isOwnerThisRecord = true/false
 */
public function GetisOwnerThisRecord(){
    return ($this->{$this->nameFieldUserId}==h::userId());
}



}   

