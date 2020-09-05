<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200213_213912_create_table_eventosdet extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_docu_indicadores}}';
     const NAME_TABLE_DOCUS='{{%sta_docu_alu}}';
     const NAME_TABLE_INDICADORES='{{%sta_testindicadores}}';
      //const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
  // const NAME_TABLE_TALLERES='{{%sta_talleres}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),  
        'docualu_id'=>$this->integer(3)->notNull(), 
        'indicadores_id'=>$this->integer(11)->notNull(),
         'actividades_realizadas'=>$this->text()->append($this->collateColumn()), 
        'apuntes'=>$this->text()->append($this->collateColumn()), 
          'descripcion'=>$this->string(30)->append($this->collateColumn()), 
        
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'docualu_id', static::NAME_TABLE_DOCUS,'id');
  $this->addForeignKey($this->generateNameFk($table), $table,
              'indicadores_id', static::NAME_TABLE_INDICADORES,'id');
  
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