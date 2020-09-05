<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200428_155238_create_table_tipo_mail extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_tipo_mail}}';
     //const NAME_TABLE_EVENTOS='{{%sta_eventos}}';
    // const NAME_TABLE_EVENTOS='{{%sta_eventos}}';
     // const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
  // const NAME_TABLE_TALLERES='{{%sta_talleres}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),  
        //'codfac'=>$this->string(8)->notNull(), 
         'tipo'=>$this->integer(2)->notNull(),
        'cabecera'=>$this->text(),
        'pie'=>$this->text(),
        'titulo'=>$this->string(40),
        'nombre'=>$this->string(30),
          ],$this->collateTable());
  /* $this->addForeignKey($this->generateNameFk($table), $table,
              'eventos_id', static::NAME_TABLE_EVENTOS,'id'); */
  
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