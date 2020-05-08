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
        'edificio_id'=>$this->integer(11)->notNull(),
        'cargosedificio_id'=>$this->integer(11)->notNull(),
        'monto'=>$this->decimal(10,3),
        'unidades'=>$this->string(4),
        'consumototal'=>$this->decimal(10,3),
         'montototal'=>$this->decimal(10,3),
        'delta'=>$this->decimal(7,3),
        'lectura'=>$this->decimal(10,3),
        'cuentaspor_id'=>$this->integer(11),
        'colector_id'=>$this->integer(11),
        'grupo_id'=>$this->integer(11),
         'grupounidad'=>$this->string(10),
         'grupofacturacion'=>$this->string(10),
        'grupounidad_id'=>$this->integer(11),
        'grupocobranza'=>$this->string(6),
        'igv'=>$this->decimal(8,3),
         'anio'=>$this->string(4),
         'mes'=>$this->integer(2),
        'identidad'=>$this->integer(11),
         'dias'=>$this->integer(2),
         'numerorecibo'=>$this->string(14)->append($this->collateColumn()),
        'codsuministro'=>$this->string(12)->append($this->collateColumn()),
        'aacc'=>$this->char(1)->append($this->collateColumn()),
         'codmon'=>$this->char(3)->append($this->collateColumn()),
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