<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191111_184026_create_table_aulas_taller extends baseMigration
{
   const NAME_TABLE='{{%sta_aula_taller}}';
     const NAME_TABLE_AULAS='{{%sta_aulas}}';
      const NAME_TABLE_TALLERES='{{%sta_talleres}}';
       const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
   public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
       'aula_id'=>$this->integer(11)->notNull(),
         'talleres_id'=>$this->integer(11)->notNull(),
         'activo'=>$this->char(1)->append($this->collateColumn()),
        'multiple'=>$this->char(1)->append($this->collateColumn()),
        'alternativa_id'=>$this->integer(11),
         'codfac'=>$this->string(8)->notNull()->append($this->collateColumn()),
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'codfac', static::NAME_TABLE_FACULTAD,'codfac');
        
  /*  $this->addForeignKey($this->generateNameFk($table), $table,
              'codalu', static::NAME_TABLE_ALUMNO,'codalu');*/
     $this->addForeignKey($this->generateNameFk($table), $table,
              'talleres_id', static::NAME_TABLE_TALLERES,'id');
    $this->addForeignKey($this->generateNameFk($table), $table,
              'aula_id', static::NAME_TABLE_AULAS,'id');
    
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