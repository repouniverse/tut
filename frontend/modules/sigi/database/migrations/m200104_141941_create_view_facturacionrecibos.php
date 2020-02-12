<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use common\helpers\FileHelper;
use yii;
class m200104_141941_create_view_facturacionrecibos extends viewMigration
{
    const NAME_VIEW='{{%vw_sigi_facturecibo}}';
  public function safeUp()
    {
         $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
        $comando= $this->db->createCommand(); 
        
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
         'a.dias','a.id','a.codmon','a.numerorecibo','a.consumototal','a.montototal','a.participacion','a.codsuministro','a.aacc','a.delta','a.lectura', 'a.lectura-a.delta as lanterior'   ,'a.cuentaspor_id','a.edificio_id','a.unidad_id','a.colector_id','a.grupo_id','a.monto','a.igv','a.grupounidad','a.grupofacturacion','a.facturacion_id','a.mes','a.anio','a.identidad','a.numerorecibo','a.unidades','a.grupocobranza',//detalle facturacion  a
         'b.fecha','b.fvencimiento','b.descripcion','b.detalles', //facturacionion b
         'c.nombre as nombreedificio','c.codigo','c.direccion', //EDIFICIOS C
        'd.numero','d.nombre','d.area','d.participacion', ///UNIDADES d  POR DETALLE
        //'d.numero','d.nombre','d.area','d.participacion', ///coelctores e
         'f.descargo','f.codcargo', ///Cargos f
        'g.codgrupo','g.descripcion as desgrupo', ///Grupos g
         'h.numero as numerodepa','h.nombre as nombredepa','h.area as areadepa','h.participacion as participaciondepa', ///UNIDADES h  POR GRUPO
        ])
    ->from(['a'=>'{{%sigi_detfacturacion}}'])->
     innerJoin('{{%sigi_facturacion}} b', 'a.facturacion_id=b.id')->
     innerJoin('{{%sigi_edificios}} c', 'b.edificio_id=c.id')->
     innerJoin('{{%sigi_unidades}} d', 'a.grupounidad_id=d.id')->//CONECTA CON CAMPO GRUPOUNIDAD_ID
     innerJoin('{{%sigi_unidades}} h', 'a.unidad_id=h.id')->//CONECTA CON CAMPO UNIDAD_ID
     innerJoin('{{%sigi_cargosedificio}} e', 'a.colector_id=e.id')->
     innerJoin('{{%sigi_cargos}} f', 'e.cargo_id=f.id')->
     innerJoin('{{%sigi_cargosgrupoedificio}} g', 'a.grupo_id=g.id')
                )->execute();
       yii::error($comando->getRawSql());
   }
public function safeDown()
    {
     
    $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
    }
    
}
