<?php

namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191229_170828_create_table_sigi_detfacturacion extends baseMigration
{
    const NAME_TABLE='{{%sigi_detfactur}}';
   const NAME_TABLE_UNIDADES='{{%sigi_unidades}}';
   const NAME_TABLE_EDIFICIO='{{%sigi_edificios}}';
   const NAME_TABLE_COLECTORES='{{%sigi_cargosedificio}}';
      const NAME_TABLE_GRUPOS='{{%sigi_cargosgrupoedificio}}';
       const NAME_TABLE_CUENTASPOR='{{%sigi_cuentaspor}}';
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        'cuentaspor_id'=>$this->integer(11)->notNull(),
        'edificio_id'=>$this->integer(11)->notNull(),
        'unidad_id'=>$this->integer(11)->notNull(),
         'colector_id'=>$this->integer(11)->notNull(),
        'grupo_id'=>$this->integer(11)->notNull(),
        'monto'=>$this->decimal(12, 4)->notNull(),
         'igv'=>$this->decimal(8, 4)->notNull(),
       'grupounidad'=>$this->integer(11)->notNull()->comment('agrupa  todos los objetos: cochera, depositos  en el mismo departamento  '),
         'grupofacturacion'=>$this->integer(11)->notNull()->comment('Agrupa el documento del recibo, ojo lo hace por departametno o apoderado, MUY IMPORTANTES '),
        ],$this->collateTable());
  
   /* $this->addForeignKey($this->generateNameFk($table), $table,
              'unidad_id', static::NAME_TABLE_UNIDADES,'id');*/
    $this->addForeignKey($this->generateNameFk($table), $table,
              'unidad_id', static::NAME_TABLE_UNIDADES,'id');     
             
     $this->addForeignKey($this->generateNameFk($table), $table,
              'edificio_id', static::NAME_TABLE_EDIFICIO,'id');     
            
            $this->addForeignKey($this->generateNameFk($table), $table,
              'colector_id', static::NAME_TABLE_COLECTORES,'id');
            
            $this->addForeignKey($this->generateNameFk($table), $table,
              'grupo_id', static::NAME_TABLE_GRUPOS,'id');
     
        $this->addForeignKey($this->generateNameFk($table), $table,
              'cuentaspor_id', static::NAME_TABLE_CUENTASPOR,'id');
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