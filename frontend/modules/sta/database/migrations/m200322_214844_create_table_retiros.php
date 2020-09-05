<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
use yii\db\Migration;

/**
 * Class m200322_214844_create_table_retiros
 */
class m200322_214844_create_table_retiros extends  baseMigration
{
    const NAME_TABLE='{{%sta_retiros}}';
    const NAME_TABLE_TALLERDET='{{%sta_talleresdet}}';
      public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
         'tallerdet_id'=>$this->integer(11),
         'codalu'=>$this->string(14)->append($this->collateColumn()),        
        'motivo'=>$this->string(3),
        'fecha'=>$this->char(10),
         'codocu'=>$this->char(3),
        'detalle'=>$this->text(),
         'estado'=>$this->char(1),
         'codfac'=>$this->string(6),
         ],$this->collateTable());
    $this->addForeignKey($this->generateNameFk($table), $table,
              'tallerdet_id', static::NAME_TABLE_TALLERDET,'id');  
         
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