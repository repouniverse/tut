<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191101_195630_create_table_cargos_grupo_edificio extends baseMigration
{
   const NAME_TABLE='{{%sigi_cargosgrupoedificio}}';
   const NAME_TABLE_CARGOS_EDIFICIOS='{{%sigi_cargosedificio}}';
    const NAME_TABLE_EDIFICIOS='{{%sigi_edificios}}';
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
        'id'=>$this->primaryKey(),
        'edificio_id'=>$this->integer(11)->notNull(),
       // 'cargosedificio_id'=>$this->integer(11)->notNull(),
        'codgrupo'=>$this->char(3)->notNull()->append($this->collateColumn()),
       // 'codigo'=>$this->string(10)->notNull()->append($this->collateColumn()),
        'descripcion'=>$this->string(40)->append($this->collateColumn()),
         'activo'=>$this->char(1)->append($this->collateColumn()),
       'detalles'=>$this->text()->append($this->collateColumn()),
        ],$this->collateTable());
  //$this->addPrimaryKey($this->generateNameFk($table), $table, ['codgrupo']);
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