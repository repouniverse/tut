<?php

namespace console\migrations;

use console\migrations\baseMigration;
class M190508053799FillTableClipro extends baseMigration
{
    const NAME_TABLE='{{%clipro}}';
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
['100000','EMPRESA PERSONA NATURAL','10000000000'],
['760001','CONG MISIONERAS SGDO CORAZON DE JESUS','20100098041'],
['760002','INSTITUTO SUPERIOR SAN IGNACIO DE LOYOLA S.A.','20100134455'],
['760003','FUNDACION PARA EL DESARROLLO DEL AGRO','20100178070'],
['760004','FUNDACION IGNACIA R VDA DE CANEVARO','20100266793'],
['760005','SOC.ITALIANA DE BENEFICENCIA Y ASIST','20100331951'],
['760006','ASOCIACION EDUCATIVA PITAGORAS','20100426669'],
['760007','MONASTERIO DE JESUS MARIA Y JOSE','20100479193'],
['760008','ASOCIACION FRAY LUIS DE LEON','20100559898'],
['760009','SANTA MAGDALENA CIVIL DE RESPONSABI','20100606641'],
['760010','INST SUP TECNOLOGICO NO EST ALMTE GRAU','20100607701'],
['760011','INST SUPERIOR TECNOL N PRO DEN','20100716152'],
['760012','C E P NUESTRA SEÑORA DEL PILAR','20100754917'],
 
           ];      
            
    }
    
    private static function  fields(){
        return ['codpro','despro','rucpro'];
    }
    
    private static function  deleteData(){        
        
          (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();
       
    }
}