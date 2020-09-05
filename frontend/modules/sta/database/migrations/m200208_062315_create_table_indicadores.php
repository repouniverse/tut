<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200208_062315_create_table_indicadores extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
   // const NAME_TABLE_EXAMENES='{{%sta_examenes}}';
     const NAME_TABLE='{{%sta_testindicadores}}';
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
         //'item'=>$this->char(3)->notNull()->append($this->collateColumn()), 
         'grupo'=>$this->char(2)->notNull()->append($this->collateColumn()), 
         'codbateria'=>$this->string(4)->notNull()->append($this->collateColumn()), 
        'nombre'=>$this->string(60)->notNull(), 
        'texto_bajo'=>$this->text()->append($this->collateColumn()),
        'texto_medio'=>$this->text()->append($this->collateColumn()),
         'texto_alto'=>$this->text()->append($this->collateColumn()),
          'orden'=>$this->integer(2),
        'ordenabs'=>$this->integer(2),
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