<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use common\helpers\FileHelper;
class m191013_162180_create_view_aluriesgo  extends viewMigration
{
 const NAME_VIEW='{{%vw_aluriesgo}}';
 
    public function safeUp()
    {
        
    $table=static::NAME_VIEW;
        if(!$this->existsTable($table)) {
        
        $vista=static::NAME_VIEW;
        $this->createView($vista,
                $this->getFields(),
                $this->getTables(),
                $this->getWhere()
                );
        
 }}
public function safeDown()
    {
     
    $vista=static::NAME_VIEW;    
    $this->dropView($vista);
    }
    
 private function getFields(){
     return [ /*Alu*/'a.ap','a.am','a.nombres','a.codfac','a.dni','a.correo','a.celulares','a.fijos',
                  /*Aluriesgo*/'b.id','b.codcur','b.codalu','b.nveces','b.nveces15','b.codperiodo','b.codcar',
                  /*Materias*/ 'd.nomcur','c.creditos','c.electivo','c.ciclo',
          /*Facultades*/ 'e.desfac',
                  
         ];
 }   
  private function getTables(){
     $tablas=[
                  'Alumnos'=> '{{%sta_alu}} as a',
                  'Aluriesgo'=>'{{%sta_aluriesgo}}  as b',
                  'Materia'=> '{{%sta_materia}} as c',    
                  'Curso'=> '{{%sta_cursos}} as d',  
                'Facultad'=> '{{%sta_facultades}} as f ',
                'Carreras'=> '{{%sta_carreras}} as g ',
                ];
        return $this->prepareTables($tablas);
 }  

 
 public function getWhere(){
      return " b.codalu=a.codalu".//Alu riesgo Con Alu                
              self::_AND."b.codcur=c.codcur".self::_AND." b.codcar=c.codcar ".self::_AND." c.electivo <> 'E' ".self::_AND." activa= '1' ".//Alu riesgo Con Materias
       self::_AND."c.codcur=d.codcur". //Materias con Cursos 
               self::_AND."b.codcar=g.codcar". //Alu riesgo  con Carreras
       self::_AND."b.codfac=f.codfac"; //Con Facultades
}
}
