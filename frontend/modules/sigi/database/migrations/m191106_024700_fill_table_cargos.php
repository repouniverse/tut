<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191106_024700_fill_table_cargos extends baseMigration
{
   const NAME_TABLE='{{%sigi_cargos}}';
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
        //$campos=['codocu','codocupadre','desdocu','clase','tipo','abreviatura'];
        return [
            ['1000', 'SERV ADMINISTRADOR' ,'1'],
            ['1001', 'SERV CONSERJERIA' ,'1'], 
            ['1002', 'MANT LIMPIEZA' ,'1'],
            ['1003', 'MANT JARDINERIA' ,'1'], 
            ['1004', 'SERV BACK OFFICE' ,'1'],
            ['1005', 'SERV VIGILANCIA/SEGURIDAD' ,'1'],
            ['1006', 'SERV VIDEOVIGILANCIA' ,'1'],
            ['1007', 'BENEFICIOS SOCIALES' ,'1'],
            ['1008', 'COSTOS FINANCIEROS' ,'1'], 
            ['1009', 'ALIMENTACION Y VIATICOS' ,'1'], 
            ['4000', 'SERV AGUA POTABLE' ,'0'],
            ['4001', 'SERV ENERG ELECTRIC' ,'1'], 
            ['5700', 'MANT ASCENSORES' ,'0'],
            ['5701', 'MANT BOMBAS SCI' ,'0'], 
            ['1010', 'MANT PISCINA' ,'0'],
            ['1011', 'MANT SAUNA' ,'0'], 
            ['1012', 'MANT PINTURA' ,'1'],
            ['4003', 'TRAMITES' ,'1'], 
            ['4005', 'REDONDEO TIPO CAMBIO' ,'1'], 
            ['4012', 'MULTA O SANCION' ,'0'],
            ['4013', 'GARANTIA POR RESERVA' ,'1'], 
            ['4014', 'REDONDEO PAGO ANTERIOR' ,'0'], 
            ['4015', 'SERV LAVANDERIA' ,'0'],
            ['4016', 'CUOTA EXTRAORDINARIA' ,'0'], 
            ['4017', 'DERECHO DE RESERVA ' ,'0'],           
            ];
    }
    
    
    private static function  fields(){
        return  ['codcargo','descargo','esegreso'];
    }
    
    private static function  deleteData(){        
        
          (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();
       
    }
}
    
  