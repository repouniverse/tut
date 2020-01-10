<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191210_164207_create_table_cuentaspor extends baseMigration
{
    const NAME_TABLE='{{%sigi_cuentaspor}}';
  const NAME_TABLE_EDIFICIOS='{{%sigi_edificios}}';
  const NAME_TABLE_CLIPRO='{{%clipro}}';
  const NAME_TABLE_MONEDAS='{{%monedas}}';
   const NAME_TABLE_FACTURACION='{{%sigi_facturacion}}';
   //const NAME_TABLE_CONCEPTO_EDIFICIO='{{%sigi_cargosedificio}}';
   
     
    public function safeUp()
    {
       $table=static::NAME_TABLE;
       $collate=$this->collateColumn();
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
         'edificio_id'=>$this->integer(11)->notNull(),
         'facturacion_id'=>$this->integer(11)->notNull(),
        'codocu'=>$this->char(3)->notNull()->append($collate),
        'numerodoc'=>$this->string(20)->notNull()->append($collate),
         'descripcion'=>$this->string(40)->notNull()->append($collate),
         'codpro'=>$this->char(6)->notNull()->append($collate),
        'codmon'=>$this->char(3)->notNull()->append($collate),
        'fedoc'=>$this->char(10)->append($collate),
         'mes'=>$this->integer(2)->notNull(),
         'mesconsumo'=>$this->integer(2)->notNull(),
         'consumo'=>$this->decimal(12,4)->notNull(),
         'unidad_id'=>$this->integer(11)->notNull(),
         'anio'=>$this->char(4)->notNull()->append($collate),
        'detalle'=>$this->text()->append($collate),
        'fevenc'=>$this->char(10)->append($collate),
        'monto'=>$this->decimal(12,4)->notNull(),
        'igv'=>$this->char(10,4), 
        'reporte_id'=>$this->integer(5), 
        'codestado'=>$this->string(10)->notNull()->append($collate),
        ],$this->collateTable());
  
   /* $this->addForeignKey($this->generateNameFk($table), $table,
              'unidad_id', static::NAME_TABLE_UNIDADES,'id');*/
    $this->addForeignKey($this->generateNameFk($table), $table,
              'edificio_id', static::NAME_TABLE_EDIFICIOS,'id');
    $this->addForeignKey($this->generateNameFk($table), $table,
              'codpro', static::NAME_TABLE_CLIPRO,'codpro');
         $this->addForeignKey($this->generateNameFk($table), $table,
              'codmon', static::NAME_TABLE_MONEDAS,'codmon');
            $this->addForeignKey($this->generateNameFk($table), $table,
              'facturacion_id', static::NAME_TABLE_FACTURACION,'id');
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