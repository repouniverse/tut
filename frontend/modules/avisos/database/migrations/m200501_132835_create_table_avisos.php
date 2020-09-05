<?php
namespace frontend\modules\avisos\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;

class m200501_132835_create_table_avisos extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%avisos_tablon}}';
     //const NAME_TABLE_PERIODOS='{{%sta_periodos}}';
    // const NAME_TABLE_EVENTOS='{{%sta_eventos}}';
    //  const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
  // const NAME_TABLE_TALLERES='{{%sta_talleres}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),  
        'user_id'=>$this->integer(4)->notNull(),
        'finicio'=>$this->string(19)->notNull(),
        'ftermino'=>$this->string(19)->notNull(),
        'texto'=>$this->text()->append($this->collateColumn()),
         'texto_interno'=>$this->text()->append($this->collateColumn()),
        'esevento'=>$this->char(1)->append($this->collateColumn()), //  
         'activo'=>$this->char(1)->append($this->collateColumn()), //  
        'periodo'=>$this->integer(5), //  
        'user_admin'=>$this->integer(4)->notNull(),
        ],$this->collateTable());
   /*$this->addForeignKey($this->generateNameFk($table), $table,
              'codperiodo', static::NAME_TABLE_PERIODOS,'codperiodo'); */ 
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