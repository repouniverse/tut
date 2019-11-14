<?php

namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191108_161231_create_table_dispopsico extends baseMigration
{
   const NAME_TABLE='{{%sta_dispopsico}}';
     const NAME_TABLE_TALLERPSICO='{{%sta_talleresdet}}';
      
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
       // 'aluriesgo_id'=>$this->integer(11)->notNull(),
        'tallerpsico_id'=>$this->integer(11)->notNull(),
         'finicio'=>$this->integer(11)->notNull(),//Rompiendo la normalizacion 
        'ftermino'=>$this->string(19)->append($this->collateColumn()),
        'tolerancia'=>$this->decimal(4,2),
        
        ],$this->collateTable());
  
  /*  $this->addForeignKey($this->generateNameFk($table), $table,
              'codalu', static::NAME_TABLE_ALUMNO,'codalu');*/
     $this->addForeignKey($this->generateNameFk($table), $table,
              'tallerpsico_id', static::NAME_TABLE_TALLERPSICO,'id');
    
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