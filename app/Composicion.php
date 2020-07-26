<?php

namespace LaSolucion;

use Illuminate\Database\Eloquent\Model;

class Composicion extends Model
{
    protected $table='composicion';
   protected $primaryKey='idcomposicion';
   public $timestamps=false;

    protected $fillable=[
    	'idproducto',
    	'idinsumo',
    	'cantidad_consumida'
    ]; // campos asignables al modelo, para mas campos usar $guarded=[];
}
