<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200208_162545_create_table_resultados  extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
   // const NAME_TABLE_EXAMENES='{{%sta_examenes}}';
     const NAME_TABLE='{{%sta_resultados}}';
     const NAME_TABLE_EXAMENES='{{%sta_examenes}}';
     const NAME_TABLE_INDICADORES='{{%sta_testindicadores}}';
    // const NAME_TABLE_INDICADORES='{{%sta_testindicadores}}';
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
        'indicador_id'=>$this->integer(11)->notNull(),
         'examen_id'=>$this->integer(11)->notNull(),
        //'codtest'=>$this->string(8)->notNull()->append($this->collateColumn()),
         //'item'=>$this->char(3)->notNull()->append($this->collateColumn()), 
         'puntaje_total'=>$this->integer(4), 
        'percentil'=>$this->integer(3), 
         'categoria'=>$this->string(10)->append($this->collateColumn()),
        'codfac'=>$this->string(8)->append($this->collateColumn()),
        'interpretacion'=>$this->text()->append($this->collateColumn()),
         ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'examen_id', static::NAME_TABLE_EXAMENES,'id'); 
    $this->addForeignKey($this->generateNameFk($table), $table,
              'indicador_id', static::NAME_TABLE_INDICADORES,'id');
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