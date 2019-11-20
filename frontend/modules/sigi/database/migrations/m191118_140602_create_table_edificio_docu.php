<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;

/**
 * Class m191031_195027_create_table_examenes
 */
class m191118_140602_create_table_edificio_docu extends baseMigration
{
    const NAME_TABLE_EDIFICIOS='{{%sigi_edificios}}';
     const NAME_TABLE='{{%sigi_edificiodocu}}';
     const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
   //const NAME_TABLE_ALUMNO='{{%sta_alu}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
         'edificio_id'=>$this->integer(11)->notNull(),
        'codocu'=>$this->char(3)->notNull()->append($this->collateColumn()),
        'nombre'=>$this->string(60)->notNull()->append($this->collateColumn()),
         'detalle'=>$this->text()->notNull()->append($this->collateColumn()),
        
        ],$this->collateTable());
  
  /*  $this->addForeignKey($this->generateNameFk($table), $table,
              'codalu', static::NAME_TABLE_ALUMNO,'codalu');*/
    $this->addForeignKey($this->generateNameFk($table), $table,
              'edificio_id', static::NAME_TABLE_EDIFICIOS,'id');
    $this->addForeignKey($this->generateNameFk($table), $table,
              'codocu', static::NAME_TABLE_DOCUMENTOS,'codocu');
            } 
 }

public function safeDown()
    {
     $table=static::NAME_TABLE;
     
       if($this->existsTable($table)) {
           $this->deleteCombo($table, 'tipo');
            $this->dropTable($table);
        }
     

    }

}