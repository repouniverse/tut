<?php
namespace console\migrations;
use yii\db\Migration;
/**
 * Class M200206173858CreateTableAccessDocus
 */
class M200206173858CreateTableAccessDocus extends baseMigration
{   
 const NAME_TABLE='{{%acces_docu}}';
 const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
       
 $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
             'id'=>$this->primaryKey(),
            'modelo'=>$this->string(180)->notNull()->append($this->collateColumn()),
            'codocu' =>$this->char(3)->notNull()->append($this->collateColumn()),
          'rol' => $this->string(100)->notNull()->append($this->collateColumn()),
         'campo' => $this->string(40)->append($this->collateColumn()),
        'campo_profile' => $this->string(20)->append($this->collateColumn()),
            'upload' =>$this->char(1)->append($this->collateColumn()),
          'download' =>$this->char(1)->append($this->collateColumn()),
             ],$this->collateTable());
         $this->addForeignKey($this->generateNameFk($table), $table,
              'codocu', static::NAME_TABLE_DOCUMENTOS,'codocu');
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
