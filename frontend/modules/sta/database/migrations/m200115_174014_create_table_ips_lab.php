<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200115_174014_create_table_ips_lab  extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_ipslab}}';
     
    const NAME_TABLE_TALLERES='{{%sta_talleres}}';
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),       
        'taller_id'=>$this->integer(11)->notNull(),
        'ip'=>$this->string(20)->notNull()->append($this->collateColumn()), 
        'activo'=>$this->char(1)->append($this->collateColumn()), 
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'taller_id', static::NAME_TABLE_TALLERES,'id');
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