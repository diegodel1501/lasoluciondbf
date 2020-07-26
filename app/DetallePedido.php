<?php

namespace LaSolucion;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{  protected $table='detalle_pedido';
   protected $primaryKey='iddetallepedido';
   public $timestamps=false;

    protected $fillable=[
    	'idproducto',
    	'idpedido',
    	'cantidad',
    	'idpanadero'
    ]; // campos asignables al modelo, para mas campos usar $guarded=[];
}
