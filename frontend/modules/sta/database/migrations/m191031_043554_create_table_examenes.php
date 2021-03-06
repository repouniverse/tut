<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;


/**
 * Class m191031_043554_create_table_examenes
 */
class m191031_043554_create_table_examenes extends baseMigration
{
      const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE_CITAS='{{%sta_citas}}';
     const NAME_TABLE='{{%sta_examenes}}';
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
       // 'aluriesgo_id'=>$this->integer(11)->notNull(),
        'citas_id'=>$this->integer(11)->notNull(),
        'reporte_id'=>$this->integer(11)->notNull(),
        'codtest'=>$this->string(8)->notNull(),
        'user_id'=>$this->integer(6),//campo propietarios 
         'codfac'=>$this->string(8)->notNull()->append($this->collateColumn()),
         'fnotificacion'=>$this->string(20)->notNull()->append($this->collateColumn()),
         'detalles'=>$this->text()->append($this->collateColumn()),
            'clase'=>$this->char(1)->notNull()->append($this->collateColumn()), //QUE CALSE DE TALLERS 
        ],$this->collateTable());
  
  /*  $this->addForeignKey($this->generateNameFk($table), $table,
              'codalu', static::NAME_TABLE_ALUMNO,'codalu');*/
    $this->addForeignKey($this->generateNameFk($table), $table,
              'citas_id', static::NAME_TABLE_CITAS,'id');
    $this->addForeignKey($this->generateNameFk($table), $table,
              'codtest', static::NAME_TABLE_TESTS,'codtest');
                /*  $this->addForeignKey($this->generateNameFk($table), $table,
              'codcar', static::NAME_TABLE_CARRERAS,'codcar');*/
     $this->addForeignKey($this->generateNameFk($table), $table,
              'codfac', static::NAME_TABLE_FACULTAD,'codfac');
                
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