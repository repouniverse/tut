<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200417_172629_create_table_indi_cita extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_cita_indicadores}}';
     const NAME_TABLE_CITAS='{{%sta_citas}}';
    // const NAME_TABLE_EVENTOS='{{%sta_eventos}}';
      const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
  // const NAME_TABLE_TALLERES='{{%sta_talleres}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),  
        'codfac'=>$this->string(8)->notNull(), 
         'citas_id'=>$this->integer(11)->notNull(),
        'talleresdet_id'=>$this->integer(11)->notNull(),
        'detalles'=>$this->text()->append($this->collateColumn()), 
         'relevancia'=>$this->integer(1),
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'citas_id', static::NAME_TABLE_CITAS,'id'); 
   $this->addForeignKey($this->generateNameFk($table), $table,
              'talleresdet_id', static::NAME_TABLE_TALLERESDET,'id');  
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