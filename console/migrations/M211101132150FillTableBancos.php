<?php

namespace console\migrations;

use console\migrations\baseMigration;
class M211101132150FillTableBancos extends baseMigration
{
    const NAME_TABLE='{{%bancos}}';
 //const NAME_TABLE_CENTROS='{{%centros}}';
    public function safeUp()
    {
            \Yii::$app->db->createCommand()->
             batchInsert(static::NAME_TABLE,
             $this->fields(), $this->getData())->execute();
    }

    public function safeDown()
    { static::deleteData();
    }

    
    private static function  getData(){
              return [
['BBVA','BANCO CONTINENTAL'],
['BCP','BANCO DE CREDITO DEL PERU'],
['BN','BANCO DE LA NACION'],
['SCBK','SCOTIABANK DEL PERU'],
 ['IB','INTERBANK'], 
 ['BANBIF','BANCO INTERAMERICANO DE FINAN'],
           ];      
            
    }
    
    private static function  fields(){
    return  ['codbanco','nombre'];
    }
    
    private static function  deleteData(){        
        
          (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();
       
    }
}