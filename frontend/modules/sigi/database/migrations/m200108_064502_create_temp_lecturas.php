<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200108_064502_create_temp_lecturas extends  baseMigration
{
    const NAME_TABLE='{{%sigi_temp_lecturas}}';
   const NAME_TABLE_SUMINISTROS='{{%sigi_suministros}}';
   //const NAME_TABLE_CONCEPTO_EDIFICIO='{{%sigi_cargosedificio}}';
   
     
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        'suministro_id'=>$this->integer(11)->notNull(),
        'unidad_id'=>$this->integer(11)->notNull(),
        'codepa'=>$this->string(12),
        'mes'=>$this->string(2)->notNull()->append($this->collateColumn()),
       'flectura'=>$this->char(10)->append($this->collateColumn()),
        'hlectura'=>$this->char(5)->append($this->collateColumn()),
        'lectura'=>$this->decimal(12,4),
         'lecturaant'=>$this->decimal(12,4),
         'anio'=>$this->char(4)->notNull()->append($this->collateColumn()),
        'codedificio'=>$this->string(12)->append($this->collateColumn()),
        'codtipo'=>$this->char(3)->append($this->collateColumn()),
         'facturable'=>$this->char(1)->append($this->collateColumn()),
        'delta'=>$this->decimal(12,4),     
                'edificio_id'=>$this->integer(11)->notNull(),
        ],$this->collateTable());
  
   /* $this->addForeignKey($this->generateNameFk($table), $table,
              'unidad_id', static::NAME_TABLE_UNIDADES,'id');*/
    $this->addForeignKey($this->generateNameFk($table), $table,
              'suministro_id', static::NAME_TABLE_SUMINISTROS,'id');
     
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