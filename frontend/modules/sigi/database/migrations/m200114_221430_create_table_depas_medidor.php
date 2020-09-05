<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200114_221430_create_table_depas_medidor extends baseMigration
{
    const NAME_TABLE='{{%sigi_suministro_depa}}';
   const NAME_TABLE_SUMINISTROS='{{%sigi_suministros}}';
   const NAME_TABLE_EDIFICIOS='{{%sigi_edificios}}';
   const NAME_TABLE_UNIDADES='{{%sigi_unidades}}';
     
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        'edificio_id'=>$this->integer(11)->notNull(),
        'unidad_id'=>$this->integer(11)->notNull(),
         'suministro_id'=>$this->integer(11)->notNull(),  
          'afiliado'=>$this->char(1)->notNull(),        
        ],$this->collateTable());
  
    $this->addForeignKey($this->generateNameFk($table), $table,
              'unidad_id', static::NAME_TABLE_UNIDADES,'id');
    $this->addForeignKey($this->generateNameFk($table), $table,
              'suministro_id', static::NAME_TABLE_SUMINISTROS,'id');
      $this->addForeignKey($this->generateNameFk($table), $table,
              'edificio_id', static::NAME_TABLE_EDIFICIOS,'id');
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