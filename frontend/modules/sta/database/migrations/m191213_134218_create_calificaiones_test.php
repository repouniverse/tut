<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191213_134218_create_calificaiones_test extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_testcali}}';
     const NAME_TABLE_TESTDET='{{%sta_testdet}}';
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
        //'testdet_id'=>$this->integer(11)->notNull(),
         'valor'=>$this->integer(3)->notNull(),
         'descripcion'=>$this->string(30)->notNull()->append($this->collateColumn()), 
        'peso'=>$this->integer(3),
        
        //'tiporespuesta'=>char(2)->notNull()->append($this->collateColumn()),
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'codtest', static::NAME_TABLE_TESTS,'codtest');
 /* $this->addForeignKey($this->generateNameFk($table), $table,
              'testdet_id', static::NAME_TABLE_TESTDET,'id');*/
    
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