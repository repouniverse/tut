<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191130_053049_create_table_detfacturacion extends baseMigration
{
    const NAME_TABLE='{{%sigi_detfacturacion}}';
   const NAME_TABLE_FACTURACION='{{%sigi_facturacion}}';
   const NAME_TABLE_CONCEPTO_EDIFICIO='{{%sigi_cargosedificio}}';
   
     
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        'facturacion_id'=>$this->integer(11)->notNull(),
        'cargosedificio_id'=>$this->integer(11)->notNull(),
        'monto'=>$this->decimal(10,3),
        'codocu'=>$this->char(3)->notNull()->append($this->collateColumn()),       
        'femision'=>$this->char(10)->append($this->collateColumn()),
        'fecha'=>$this->char(10)->append($this->collateColumn()),
        'numero'=>$this->string(14)->append($this->collateColumn()),
        'descripcion'=>$this->string(40)->notNull()->append($this->collateColumn()),
        'unidad_id'=>$this->integer(11), //imputado o no 
        'detalles'=>$this->text()->append($this->collateColumn()),
        ],$this->collateTable());
  
    $this->addForeignKey($this->generateNameFk($table), $table,
              'facturacion_id', static::NAME_TABLE_FACTURACION,'id');
    $this->addForeignKey($this->generateNameFk($table), $table,
              'cargosedificio_id', static::NAME_TABLE_CONCEPTO_EDIFICIO,'id');
     
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