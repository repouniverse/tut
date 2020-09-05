<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;


class m200117_220426_create_table_users_edificios extends baseMigration
{
     const NAME_TABLE='{{%sigi_user_edificios}}';
    /// const NAME_TABLE_CARRERAS='{{%sta_carreras}}';
     const NAME_TABLE_EDIFICIOS='{{%sigi_edificios}}';
 //const NAME_TABLE_DOCBOTELLAS='{{%bigitems_docbotellas}}';
  //const NAME_TABLE_ACTIVOS='{{%activos}}';
//const NAME_TABLE_UM='{{%ums}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
               'id'=>$this->primaryKey(),
               'user_id'=>$this->integer(4)->notNull(),
         // 'profile_id'=>$this->integer(11)->notNull(),
              'edificio_id'=>$this->integer(11)->notNull(),
             'activa'=>$this->char(1)->append($this->collateColumn()),
       
        ],$this->collateTable());
          $this->addForeignKey($this->generateNameFk($table), $table,
              'edificio_id', static::NAME_TABLE_EDIFICIOS,'id');
                /*  $this->addForeignKey($this->generateNameFk($table), $table,
              'codcar', static::NAME_TABLE_CARRERAS,'codcar');*/
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