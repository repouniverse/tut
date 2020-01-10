<?php
namespace frontend\modules\sigi\interfaces;

/*Esta interfaz es base
 * para los colecrtores como claulan las particiapciones en
 * la facturacion
 */
interface  colectoresInterface { 
    /*  
     */
    //public function factorProRateo();
    
    public function montoTotal($mes,$anio);
    
}



