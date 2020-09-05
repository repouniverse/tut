<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200428_155303_create_table_mail_mensajes extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_mail_mensajes}}';
    const NAME_TABLE_TIPO_MAIL='{{%sta_tipo_mail}}';
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
       'tipo_id'=>$this->integer(11),  
         'subject'=>$this->string(40)->notNull(),
        'fecha'=>$this->string(40)->notNull(),
        //'body'=>$this->text(),
        'user_id'=>$this->integer(5),
        //'titulo'=>$this->string(40),
       // 'nombre'=>$this->string(30),
          ],$this->collateTable());
    
    
   $this->addForeignKey($this->generateNameFk($table), $table,
              'tipo_id', static::NAME_TABLE_TIPO_MAIL,'id'); 
  
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