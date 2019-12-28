<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use common\helpers\FileHelper;
class m191210_201431_creat_view_colectores extends viewMigration
{
 const NAME_VIEW='{{%vw_sigi_colectores}}';
 
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
    if($this->existsTable($vista)) {
    $this->dropView($vista);
    }}
    
 private function getFields(){
     return [ /*Cargos*/'a.id as idcargo','a.descargo','a.codcargo',
                  /*Grupos*/'b.id as idgrupo','b.edificio_id','b.codgrupo','b.descripcion as descripciongrupo',
                  /*Colectores*/'c.emisorexterno','c.individual', 'c.id as idcolector','c.tasamora','c.frecuencia','c.regular','montofijo','tipomedidor',
          /*Edicicios*/ 'd.id as idedificio','d.codigo','d.nombre',
                  
         ];
 }   
  private function getTables(){
     $tablas=[
                  'Cargos'=> '{{%sigi_cargos}} as a',
                  'Grupos'=>'{{%sigi_cargosgrupoedificio}}  as b',
                  'Colectores'=> '{{%sigi_cargosedificio}} as c',    
                 'Edificios'=> '{{%sigi_edificios}} as d'/*  
                'Facultad'=> '{{%sta_facultades}} as f ',
                'Carreras'=> '{{%sta_carreras}} as g ',*/
                ];
        return $this->prepareTables($tablas);
 }  

 
 public function getWhere(){
      return " c.grupo_id=b.id".//Colectores con Grupos             
               self::_AND."c.edificio_id=d.id".//Colectores con Edificios 
              self::_AND."c.cargo_id=a.id"; //Colectores  con Cargos
              //self::_AND."b.edificio_id=d.id"; //Grupos con Edificio
}
}
