<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191130_052750_create_table_facturacion extends baseMigration
{
    const NAME_TABLE='{{%sigi_facturacion}}';
   //const NAME_TABLE_GRUPOS='{{%sigi_grupo_presupuesto}}';
    const NAME_TABLE_EDIFICIOS='{{%sigi_edificios}}';
     
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        'edificio_id'=>$this->integer(11)->notNull(),
        'mes'=>$this->char(2)->notNull()->append($this->collateColumn()),       
        'ejercicio'=>$this->char(4)->append($this->collateColumn()),
        'fecha'=>$this->char(10)->append($this->collateColumn()),
         'fvencimiento'=>$this->char(10)->append($this->collateColumn()),
         'reporte_id'=>integer(11),
         'unidad_id'=>integer(11)->comment('Unidad PARA AGRUPAR LA COBRANZA DE LA INMOILIARIA , NO SE APLICA EN MUCHOS EDIFICIOS, SOLO EN EDIFICOIS MIXTOS EN PROESO DE VENTAS DE DEPAS para agrupar un solo reporte de cobranza'),
        //'periodo'=>$this->char(4)->append($this->collateColumn()),
        'descripcion'=>$this->string(40)->notNull()->append($this->collateColumn()),        
        'detalles'=>$this->text()->append($this->collateColumn()),
        'detalleinterno'=>$this->text()->append($this->collateColumn()),
        ],$this->collateTable());
  
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