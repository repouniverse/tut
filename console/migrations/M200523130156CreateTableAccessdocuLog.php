<?php
namespace console\migrations;

use console\migrations\baseMigration;

/**
 * Class M200523130156CreateTableAccessdocuLog
 */
class M200523130156CreateTableAccessdocuLog extends baseMigration
{
   const NAME_TABLE='{{%access_docu_log}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
       
 $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
             'id'=>$this->primaryKey(),
        'canal' =>$this->char(2)->append($this->collateColumn()),
        'user_id' =>$this->integer(6),
        'id_model' =>$owner->id,
        'fecha_hora' =>$this->string(19)->notNull()->append($this->collateColumn()),            
        'model_class' => $this->string(30)->append($this->collateColumn()),
        'id'=>$this->integer(11),
        'codocu' =>$this->string(6)->notNull()->append($this->collateColumn()), 
        
             ],$this->collateTable());
        
           }
    
    }

    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table=static::NAME_TABLE; 
       if ($this->existsTable($table)){
            $this->dropTable($table);
        }

    }
}
