<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200318_144010_create_table_resumen_asistencias  extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
   // const NAME_TABLE_EXAMENES='{{%sta_examenes}}';
     const NAME_TABLE='{{%sta_resumenasistencias}}';
     //const NAME_TABLE_EXAMENES='{{%sta_examenes}}';
     //const NAME_TABLE_INDICADORES='{{%sta_testindicadores}}';
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
         'tallerdet_id'=>$this->integer(11),
         'codalu'=>$this->string(14)->append($this->collateColumn()),
        'codfac'=>$this->string(8)->append($this->collateColumn()),
         'codcar'=>$this->string(3)->append($this->collateColumn()),
         'codperiodo'=>$this->string(6)->append($this->collateColumn()),
        'nombres'=>$this->string(40)->append($this->collateColumn()),
         'status'=>$this->char(1)->append($this->collateColumn()),
        'c_1'=>$this->string(19)->append($this->collateColumn()),
        'n_informe'=>$this->integer(2),
        'c_2'=>$this->string(19)->append($this->collateColumn()),
        'c_3'=>$this->string(19)->append($this->collateColumn()),
        'c_4'=>$this->string(19)->append($this->collateColumn()),
         'c_5'=>$this->string(19)->append($this->collateColumn()),
        'c_6'=>$this->string(19)->append($this->collateColumn()),
        'c_7'=>$this->string(19)->append($this->collateColumn()),
        'c_8'=>$this->string(19)->append($this->collateColumn()),
         'c_9'=>$this->string(19)->append($this->collateColumn()),
        'c_10'=>$this->string(19)->append($this->collateColumn()),
        'c_11'=>$this->string(19)->append($this->collateColumn()),
        'c_12'=>$this->string(19)->append($this->collateColumn()),
         'c_13'=>$this->string(19)->append($this->collateColumn()),
        'c_14'=>$this->string(19)->append($this->collateColumn()),
    
         ],$this->collateTable());
  
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