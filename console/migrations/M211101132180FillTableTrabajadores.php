<?php

namespace console\migrations;

use console\migrations\baseMigration;
class M211101132180FillTableTrabajadores extends baseMigration
{
    const NAME_TABLE='{{%trabajadores}}';
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
['760001','RAMIREZ','TENORIO','JULIAN','100','1970-01-01'],
['760002','ESPINOZA','RIVERA','YESENIA','100','1970-01-01'],
['760003','BENDEZU','ESTEBAN','JUAN','100','1970-01-01'],
['760004','CAMARGO','CARRASCO','ADOLFO','100','1970-01-01'],
['760005','VARGAS','TANTALEAN','EDUARDO','100','1970-01-01'],
['760006','ENABENTE','RISCO','ALBERTO MARIO','100','1970-01-01'],
['760007','ESCUDERO','MARIAN','JORGE AGAPITO','100','1970-01-01'],
           ];      
            
    }
    
    private static function  fields(){
        return ['codigotra','ap','am','nombres','codpuesto','cumple'];
    }
    
    private static function  deleteData(){        
        
          (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();
       
    }
}