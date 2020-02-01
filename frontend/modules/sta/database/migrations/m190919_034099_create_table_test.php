<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;


/**
 * */
class m190919_034099_create_table_test extends baseMigration
{
     const NAME_TABLE='{{%sta_test}}';  
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'codtest'=>$this->string(8)->append($this->collateColumn())->notNull(),
          'descripcion'=>$this->string(40)->append($this->collateColumn())->notNull(),
          //'codfac'=>$this->string(8)->append($this->collateColumn()),
          'opcional'=>$this->char(1)->append($this->collateColumn())->notNull(),
          //'activa'=>$this->char(1)->append($this->collateColumn()),
         'codocu'=>$this->string(3)->append($this->collateColumn()),
         'version'=>$this->string(5)->append($this->collateColumn())->notNull(),
        'nveces'=>$this->integer(2),
        'reporte_id'=>$this->integer(11),
        'codbateria'=>$this->string(4)->append($this->collateColumn()),
         'orden'=>$this->integer(2),
         'detalles'=>$this->text()->append($this->collateColumn()),
         //'electivo'=>$this->char(1)->append($this->collateColumn()),
         //'ciclo'=>$this->integer(2),
        //'version'=>$this->char(1)->append($this->collateColumn()),
        
        
        ],$this->collateTable());
   $this->addPrimaryKey('pk_codmeval',$table, 'codtest');
  
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