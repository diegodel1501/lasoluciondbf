<?php

namespace LaSolucion;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table='producto';
   protected $primaryKey='idproducto';
   public $timestamps=false;

    protected $fillable=[
    	'nombre',
        'tiempoelaboracion',
    	'descripcion',
    	'valor',
    	'idcategoria',
    	'imagen',
        'estado',
    ]; // campos asignables al modelo, para mas campos usar $guarded=[];
}
