<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200202_232130_create_table_transfereencias extends baseMigration
{
    const NAME_TABLE='{{%sigi_transferencias}}';
   const NAME_TABLE_UNIDADES='{{%sigi_unidades}}';
   const NAME_TABLE_EDIFICIO='{{%sigi_edificios}}';
   //const NAME_TABLE_COLECTORES='{{%sigi_cargosedificio}}';
      //const NAME_TABLE_GRUPOS='{{%sigi_cargosgrupoedificio}}';
       //const NAME_TABLE_CUENTASPOR='{{%sigi_cuentaspor}}';
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        //'cuentaspor_id'=>$this->integer(11)->notNull(),
        'edificio_id'=>$this->integer(11)->notNull(),
        'unidad_id'=>$this->integer(11)->notNull(),
        // 'colector_id'=>$this->integer(11)->notNull(),
        'fecha'=>$this->string(10)->notNull()->append($this->collateColumn()),
        'tipotrans'=>$this->char(2)->notNull()->append($this->collateColumn()),
         'nombre'=>$this->string(60)->notNull()->append($this->collateColumn()),
         'codpro'=>$this->char(6)->notNull()->append($this->collateColumn()),
        'correo'=>$this->string(60)->append($this->collateColumn()),
        'dni'=>$this->string(14)->append($this->collateColumn()),
       'parent_id'=>$this->integer(11),
        ],$this->collateTable());
  
   /* $this->addForeignKey($this->generateNameFk($table), $table,
              'unidad_id', static::NAME_TABLE_UNIDADES,'id');*/
    $this->addForeignKey($this->generateNameFk($table), $table,
              'unidad_id', static::NAME_TABLE_UNIDADES,'id');     
             
     $this->addForeignKey($this->generateNameFk($table), $table,
              'edificio_id', static::NAME_TABLE_EDIFICIO,'id'); 
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