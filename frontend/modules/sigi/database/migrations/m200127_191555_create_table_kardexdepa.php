<?php
namespace frontend\modules\sigi\database\migrations;

//use yii\db\Migration;
use console\migrations\baseMigration;
/**
 * Class m200127_191555_create_table_kardexdepa
 */
class m200127_191555_create_table_kardexdepa extends baseMigration
{
    const NAME_TABLE='{{%sigi_kardexdepa}}';
   const NAME_TABLE_UNIDADES='{{%sigi_unidades}}';
   const NAME_TABLE_EDIFICIO='{{%sigi_edificios}}';
   //const NAME_TABLE_COLECTORES='{{%sigi_cargosedificio}}';
     // const NAME_TABLE_GRUPOS='{{%sigi_cargosgrupoedificio}}';
       const NAME_TABLE_FACTURACION='{{%sigi_facturacion}}';
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        'facturacion_id'=>$this->integer(11)->notNull(),
        'operacion_id'=>$this->integer(11)->comment('Numero de operacion del banco, para abonos  '),
        'edificio_id'=>$this->integer(11)->notNull(),
        'unidad_id'=>$this->integer(11)->notNull(),
        'mes'=>$this->integer(2)->notNull(),
        'fecha'=>$this->char(10)->notNull(),
          'anio'=>$this->char(4)->notNull(),
         'codmon'=>$this->char(3),
         'numerorecibo'=>$this->string(12)->comment('Numeor del recibo  '),
       'monto'=>$this->decimal(12, 4),
         'igv'=>$this->decimal(8, 4),
        'detalles'=>$this->text()->append($this->collateColumn()),
        'reporte_id'=>$this->integer(11),
        
        ],$this->collateTable());
  
   /* $this->addForeignKey($this->generateNameFk($table), $table,
              'unidad_id', static::NAME_TABLE_UNIDADES,'id');*/
    $this->addForeignKey($this->generateNameFk($table), $table,
              'unidad_id', static::NAME_TABLE_UNIDADES,'id');   
             
     $this->addForeignKey($this->generateNameFk($table), $table,
              'edificio_id', static::NAME_TABLE_EDIFICIO,'id');    
            
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