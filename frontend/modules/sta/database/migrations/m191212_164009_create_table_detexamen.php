<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191212_164009_create_table_detexamen  extends baseMigration
{
      const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE_EXAMENES='{{%sta_examenes}}';
     const NAME_TABLE='{{%sta_examenesdet}}';
     const NAME_TABLE_TESTS='{{%sta_test}}';
      const NAME_TABLE_TEST_DET='{{%sta_testdet}}';
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
       // 'aluriesgo_id'=>$this->integer(11)->notNull(),
        'examenes_id'=>$this->integer(11)->notNull(), 
        'test_id'=>$this->integer(11)->notNull(), 
         'valor'=>$this->integer(4), 
         'indicador_id'=>$this->integer(11)->notNull(),
        'puntaje'=>$this->integer(3), 
        'percentil'=>$this->integer(3), 
        'categoria'=>$this->string(10)->append($this->collateColumn()),
         'codfac'=>$this->string(8)->notNull()->append($this->collateColumn()),
         'detalles'=>$this->text()->append($this->collateColumn()),
        ],$this->collateTable());
  
  /*  $this->addForeignKey($this->generateNameFk($table), $table,
              'codalu', static::NAME_TABLE_ALUMNO,'codalu');*/
    $this->addForeignKey($this->generateNameFk($table), $table,
              'examenes_id', static::NAME_TABLE_EXAMENES,'id');
  
     $this->addForeignKey($this->generateNameFk($table), $table,
              'codfac', static::NAME_TABLE_FACULTAD,'codfac');
     $this->addForeignKey($this->generateNameFk($table), $table,
              'test_id', static::NAME_TABLE_TEST_DET,'id');           
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