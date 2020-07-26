<?php

namespace LaSolucion;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table='insumo';
   protected $primaryKey='idinsumo';
   public $timestamps=false;

    protected $fillable=[
    	'nombre',
    	'descripcion',
    	'stock',
    	'imagen'
    ]; // campos asignables al modelo, para mas campos usar $guarded=[];
}