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
       'grupounidad'=>$this->string(12)->comment('agrupa  todos los objetos: cochera, depositos  en el mismo departamento  '),
          'grupofacturacion'=>$this->string(12)->notNull()->comment('Agrupa el documento del recibo, ojo lo hace por departametno o apoderado, MUY IMPORTANTES '),
         'grupocobranza'=>$this->string(12)->notNull()->comment('Agrupa el documento para cobrar ojo, puede cobrar de un solo cocacho varios recibos  MUY IMPORTANTES '),
        'grupounidad_id'=>$this->integer(11)->notNull()->comment('Agrupa los ids del mismo departameno  '),
          'facturacion_id'=>$this->integer(11)->notNull()->comment('Id facturacion  '),
          'identidad'=>$this->integer(11)->notNull()->comment('identidad para agrupar un solo reporte'),
        'aacc'=>$this->char(1)->notNull()->comment('flag para discrimianr cual es prorateo y cual no , areas comunes o es directo, pejem el agua de las areas comunes'),
         'mes'=>$this->integer(2)->notNull(),
          'anio'=>$this->char(4)->notNull(),
        'participacion'=>$this->decimal(8,5)->comment('porc de particiapcion'),
        'codsuminsitro'=>$this->string(12)->comment('Codigo del sumisnitro '),
       'lectura'=>$this->decimal(14,5)->comment('lectura'),
        'delta'=>$this->decimal(14,5)->comment('consumo'),
        'consumototal'=>$this->decimal(15,5)->comment('Consumo total de las lecturas del mes'),
        'montototal'=>$this->decimal(15,5)->comment('MOnto total del recibo o del prepuesto emnsual, cuentas por '),
         'numerorecibo'=>$this->string(12)->comment('Numero recibo '),
        'unidades'=>$this->string(6)->comment('Unidades de medida '),
         'dias'=>$this->integer(2)->comment('numero de dias de facturacion puede ser 30 mes completo o una  numero d edias segun la transferencia  '),
        'nuevoprop'=>$this->char(1)->comment('flag para indicar si es prpietario antiguo o nuevo cuando hay transferencia '),
       
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