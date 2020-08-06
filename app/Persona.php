<?php

namespace LaSolucion;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
   
   protected $table='users';
   protected $primaryKey='id';
   public $timestamps=true;

    protected $fillable=[
    	'nombre',
    	'tipo_persona',
    	'documento',
    	'direccion',
    	'telefono',
    	'email',
      'password'
    ]; // campos asignables al modelo, para mas campos usar $guarded=[];
protected $hidden = [
        'password', 'remember_token',
    ];
}
