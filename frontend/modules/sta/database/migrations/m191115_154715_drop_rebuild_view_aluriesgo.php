<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;

//use common\helpers\FileHelper;
class m191115_154715_drop_rebuild_view_aluriesgo  extends viewMigration
{
 const NAME_VIEW='{{%vw_aluriesgo}}';
 
    public function safeUp()
    {
        
    $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
        $this->createView($vista,
                $this->getFields(),
                $this->getTables(),
                $this->getWhere()
                );
        
 }
public function safeDown()
    {
    $vista=static::NAME_VIEW; 
    if($this->existsTable($vista)) { 
       
    $this->dropView($vista);
    }
    }
    
 private function getFields(){
     return [ /*Alu*/'a.ap','a.am','a.nombres','a.codfac','a.dni','a.correo','a.celulares','a.fijos',
                  /*Aluriesgo*/'b.status','b.id','b.codcur','b.codalu','b.nveces','b.nveces15','b.codperiodo','b.codcar',
                  /*Cursos*/ 'd.nomcur',
          /*Facultades*/ 'f.desfac',
             /*Carreras*/ 'g.descar',      
         ];
 }   
  private function getTables(){
     $tablas=[
                  'Alumnos'=> '{{%sta_alu}} as a',
                  'Aluriesgo'=>'{{%sta_aluriesgo}}  as b',
                 // 'Materia'=> '{{%sta_materia}} as c',    
                  'Curso'=> '{{%sta_cursos}} as d',  
                'Facultad'=> '{{%sta_facultades}} as f ',
                'Carreras'=> '{{%sta_carreras}} as g ',
                ];
        return $this->prepareTables($tablas);
 }  

 
  /*Talleresdet*/
 
 
 
 
 
 
 public function getWhere(){
      return " b.codalu=a.codalu".//Alu riesgo Con Alu                
             // self::_AND."b.codcur=c.codcur".self::_AND." b.codcar=c.codcar ".self::_AND." c.electivo <> 'E' ".self::_AND." activa= '1' ".//Alu riesgo Con Materias
       self::_AND."b.codcur=d.codcur".//Alu riesgo Con Cursos
   //self::_AND."c.codcur=d.codcur". //Materias con Cursos 
               self::_AND."b.codcar=g.codcar". //Alu riesgo  con Carreras
       self::_AND."b.codfac=f.codfac"; //Con Facultades
}
}
