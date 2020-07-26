<?php

namespace LaSolucion;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
       protected $table='pedido';
   protected $primaryKey='idpedido';
   public $timestamps=false;

    protected $fillable=[
    	'idcliente',
    	'idvendedor',
    	'fechaentrega',
    	'estado'
    ]; // campos asignables al modelo, para mas campos usar $guarded=[];
}
