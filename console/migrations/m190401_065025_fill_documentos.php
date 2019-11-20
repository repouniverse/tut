<?php
namespace console\migrations;
use console\migrations\baseMigration;
use common\models\masters\Documentos;
use frontend\models\masters\Trabajadores;
/**
 * Class m190401_065025_fill_documentos
 */
class m190401_065025_fill_documentos extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            //echo Documentos::class(); 
        
       //echo yii::$app->basePath; die();
        $model=New Documentos();
            static::setData($model);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $model=New Documentos();
            static::deleteData($model);
        //echo "m190401_065025_fill_documentos cannot be reverted.\n";
 echo "m190401_065025_fill_documentos was reverted successfully..! .\n";
        ///return false;
    }

    private static function  getData(){
        //$campos=['codocu','codocupadre','desdocu','clase','tipo','abreviatura'];
        return [
            ['100', 'GUIA DE REMISION' ,'D','10','GRE'],
            ['101', 'BOLETA DE VENTA' ,'D','10','DGR'],
            ['102', 'FACTURA' ,'D','10','FAC'],
            ['103', 'ACTA DE ACUERDO' ,'D','10','DFA'],
            ['104', 'VALE ALMACEN' ,'D','10','VAL'],
            ['105', 'ORDEN DE COMPRA ' ,'D','10','DVA'],
            ['106', 'NORMAS DE CONVIVENCIA' ,'D','10','OCO'], 
            ['107', 'ACTA DE ASISTENCIA' ,'D','10','OCO'], 
            ['108', 'MEMORANDUM' ,'D','10','DFA'],
            ['109', 'REGLAMENTO INTERNO' ,'D','10','VAL'],
            ['110', 'PARTIDA REGISTRAL' ,'D','10','DVA'],
            ['111', 'TITULO DE PROPIEDAD' ,'D','10','OCO'], 
            ['112', 'CONTRATO COMPRA VENTA' ,'D','10','OCO'], 
            ['113', 'CONTRATO ALQUILER' ,'D','10','OCO'], 
            ['114', 'RECIBO' ,'D','10','DFA'],
            ['115', 'CONTRATO ADMINISTRACION' ,'D','10','VAL'],
            ['116', 'ACTA DE CONFORMIDAD' ,'D','10','DVA'],
            ['117', 'ORDEN DE TRABAJO' ,'D','10','OCO'], 
            ['118', 'RESERVA DE AACC' ,'D','10','OCO'], 
            ['119', 'CONTRATO DE SERVICIOS' ,'D','10','OCO'], 
            ['120', 'VALE DE MOVILIDAD' ,'D','10','OCO'], 
            ['121', 'RECIBO DE HONORARIOS PROF' ,'D','10','OCO'], 
            ['122', 'INFORME DE SERVICIOS' ,'D','10','DFA'],
            ['123', 'COMUNICADO' ,'D','10','VAL'],
            ['124', 'NOTA DE INGRESO' ,'D','10','DVA'],            
            ];
    }
    
    private static function  setData($model){
        $campos=['codocu','desdocu','clase','tipo','abreviatura'];
        foreach(static::getData() as $clave=>$valorfila){
           
           echo (($model->firstOrCreate(array_combine($campos,$valorfila))))?'Ok: Insert':'Error\n';
        }
    }
    
    private static function  deleteData($model){
        $campos=['codocu','codocupadre','desdocu','clase','tipo','abreviatura'];
        foreach(static::getData() as $clave=>$valorfila){
           $model->deleteAll(['codocu'=>$valorfila[0]]);
        }
    }
    
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190401_065025_fill_documentos cannot be reverted.\n";

        return false;
    }
    */
}
