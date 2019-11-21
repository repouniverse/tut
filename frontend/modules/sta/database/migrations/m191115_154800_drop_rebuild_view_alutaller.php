<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;

//use common\helpers\FileHelper;
class m191115_154800_drop_rebuild_view_alutaller extends viewMigration
{
 const NAME_VIEW='{{%vw_alutaller}}';
 
    public function safeUp()
    {
         $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
        $this->createView($vista,
                $this->getFields(),
                $this->getTables(),
                $this->getWhere(),
                $this->getGroup()
                );
   }
public function safeDown()
    {
     
    $vista=static::NAME_VIEW;    
    $this->dropView($vista);
    }
    
 private function getFields(){
     return [ 
          /*Aluriesgo*/'count(b.codcur) as cantidad',
         /*Talleresdet*/'a.id','a.talleres_id','a.codalu','a.codtra','a.fingreso',
            /*Talleres*/'c.codperiodo','c.codfac',
         /*Alumnos*/'f.id as idalumno','f.fecna','f.ap','f.am','f.nombres','f.dni','f.correo','f.domicilio','f.celulares','f.fijos',
           // /*Trabajadores*/'h.ap as aptutor','h.am as amtutor','h.nombres as nombrestutor'
         ];
 }   
 
 
  private function getTables(){
     $tablas=[
                  'Alumnos'=> '{{%sta_alu}} as f',
                  'Talleresdet'=> '{{%sta_talleresdet}} as a',
                 'Talleres'=> '{{%sta_talleres}} as c',  
                 'Aluriesgo'=> '{{%sta_aluriesgo}}  as b',  
                ];
        return $this->prepareTables($tablas);
 }  


 
 public function getWhere(){
      return " b.codalu=a.codalu".//Talleres det Con Alumnos               
             self::_AND."c.codperiodo=b.codperiodo". 
               self::_AND."f.codalu=b.codalu". 
              self::_AND."c.codfac=b.codfac". 
               self::_AND."a.talleres_id =c.id";
             ////Alumnos Con Cursos
             // self::_AND."c.codcur=d.codcur"; //Alumnos Con Cursos
 }
 
 public function getGroup(){
      return ['a.codalu', 'c.codperiodo' ];
             ////Alumnos Con Cursos
             // self::_AND."c.codcur=d.codcur"; //Alumnos Con Cursos
 }
}

