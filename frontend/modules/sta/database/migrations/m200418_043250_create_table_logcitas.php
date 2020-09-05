<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200418_043250_create_table_logcitas extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_cita_log}}';
     const NAME_TABLE_CITAS='{{%sta_citas}}';
    // const NAME_TABLE_EVENTOS='{{%sta_eventos}}';
     // const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
  // const NAME_TABLE_TALLERES='{{%sta_talleres}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),  
        //'codfac'=>$this->string(8)->notNull(), 
         'citas_id'=>$this->integer(11)->notNull(),
        'fecha'=>$this->string(19),
        'nuevafecha'=>$this->string(19),
        'detalles'=>$this->text()->append($this->collateColumn()),         
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'citas_id', static::NAME_TABLE_CITAS,'id'); 
  
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