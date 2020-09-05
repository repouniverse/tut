<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200528_202902_table_grupoflujos extends baseMigration {
  //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_grupoflujo}}';
    //const NAME_TABLE_TIPO_MAIL='{{%sta_tipo_mail}}';
    // const NAME_TABLE_EVENTOS='{{%sta_eventos}}';
     // const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
  // const NAME_TABLE_TALLERES='{{%sta_talleres}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),  
       'desgrupo'=>$this->string(40),  
         'peso'=>$this->integer(2),
        
          ],$this->collateTable());
    
    
   
            } 
 }

public function safeDown()
    {
     $table=static::NAME_TABLE;
       if($this->existsTable($table)) {
            $this->dropTable($table);
        }

    }

}