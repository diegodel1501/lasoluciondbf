<?php

namespace LaSolucion;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
   
   protected $table='persona';
   protected $primaryKey='idPersona';
   public $timestamps=false;

    protected $fillable=[
    	'nombre',
    	'tipo_persona',
    	'documento',
    	'direccion',
    	'telefono',
    	'email',
      'usuario'
    ]; // campos asignables al modelo, para mas campos usar $guarded=[];

}
