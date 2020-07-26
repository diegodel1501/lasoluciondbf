<?php

namespace LaSolucion;

use Illuminate\Database\Eloquent\Model;

class DetalleInsumo extends Model
{  protected $table='detalle_insumo';
   protected $primaryKey='iddetalleinsumo';
   public $timestamps=false;

    protected $fillable=[
    	'idinsumo',
    	'precioCompra',
    	'cantidad'
    ]; // campos asignables al modelo, para mas campos usar $guarded=[];
}
