<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191212_164751_create_table_testdet extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE_EXAMENES='{{%sta_examenes}}';
     const NAME_TABLE='{{%sta_testdet}}';
     const NAME_TABLE_TESTS='{{%sta_test}}';
      //const NAME_TABLE_FACULTAD='{{%sta_test}}';
   //const NAME_TABLE_ALUMNO='{{%sta_alu}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        'codtest'=>$this->string(8)->notNull(),
         'item'=>$this->char(3)->notNull()->append($this->collateColumn()), 
         'grupo'=>$this->char(2)->notNull()->append($this->collateColumn()), 
        'pregunta'=>$this->string(300)->notNull(), 
         'detalles'=>$this->text()->append($this->collateColumn()),
        //'tiporespuesta'=>char(2)->notNull()->append($this->collateColumn()),
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'codtest', static::NAME_TABLE_TESTS,'codtest');
 
    
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