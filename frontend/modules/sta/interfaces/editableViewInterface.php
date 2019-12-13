<?php
namespace frontend\modules\sta\interfaces;

/*Esta interfaz es base
 * para los interlocutores Alumnos y profesores
 * que asisten a clases y tutorias
 */
interface  editableViewInterface {
    
   
      /*  Se matricula en la tutoria  
     */
    public static function findOne($id);
    
    /*  Cambia de tutoria 
     */
    public function delete();
    
    
}
