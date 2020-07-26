<?php

namespace LaSolucion\Http\Controllers;

use Illuminate\Http\Request;
use LaSolucion\Persona;
use Illuminate\Support\Facades\Redirect;
use LaSolucion\Http\Requests\PersonaFormRequest;
use Illuminate\Support\MessageBag;
use DB;
class Empleadocontroller extends Controller
{
     public function __construct(){
$this->middleware('auth');

    }
     //la ruta resource maneja las siguientes funciones
    public function index(Request $request){
         
        if($request){
            $query=trim($request->get('searchText'));
            $personas= DB::table('persona')->where('nombre','LIKE','%'.$query.'%')->where('estado','=','activo')->where('tipo_persona','=','panadero')->orwhere('documento','LIKE','%'.$query.'%')->where('estado','=','activo')->where('tipo_persona','=','panadero')->orwhere('nombre','LIKE','%'.$query.'%')->where('estado','=','activo')->where('tipo_persona','=','vendedor')->orwhere('documento','LIKE','%'.$query.'%')->where('estado','=','activo')->where('tipo_persona','=','vendedor')->orderBy('idPersona','desc')->paginate(3);
            return view('administracion.empleado.index',["personas"=>$personas, "searchText"=>$query]);
            }
    }// para mostrar la pagina inicial 
    public function create(){
        
                return view("administracion.empleado.create");

    }// para crear un objeto del modelo

    public function store(PersonaFormRequest $request){
         
        $persona = new Persona;
        $tipo_persona=$request->get('tipo_persona');
        if($tipo_persona=="vendedor"){
        	 $persona->tipo_persona=$tipo_persona;
        }else{
        	if($tipo_persona=="panadero"){
        		$persona->tipo_persona=$tipo_persona;
        	}else{
        		return Redirect::back()->withErrors(['error', 'El campo tipo de empleado es invalido']);
        	}
        }
        $persona->nombre=$request->get('nombre');
        $persona->documento=$request->get('documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');
        $persona->estado='activo';
        $persona->save();// recordar manejar save
        return Redirect::to('empleado');
		
    }//para guardar un objeto en la bd

    public function show($id){
     
        return view("administracion.empleado.show",["persona"=>Persona::findOrFail($id)]);

    }//para mostrar
    public function edit($id){
      
        return view("administracion.empleado.edit",["persona"=>Persona::findOrFail($id)]);


    }//para editar 
    public function update(PersonaFormRequest $request, $id){
        $persona =Persona::findOrFail($id);
        $tipo_persona=$request->get('tipo_persona');
        if($tipo_persona=="vendedor"){
        	 $persona->tipo_persona=$tipo_persona;
        }else{
        	if($tipo_persona=="panadero"){
        		$persona->tipo_persona=$tipo_persona;
        	}else{
        		return Redirect::back()->withErrors(['error', 'El campo tipo de empleado es invalido']);
        	}
        }
        $persona->nombre=$request->get('nombre');
        $persona->documento=$request->get('documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');
        $persona->estado='activo';
        $persona->update();
        return Redirect::to('empleado');

    }// para actualizar
    public function destroy($id){
                    $persona=Persona::findOrFail($id);
                    $persona->estado='inactivo';
                    $persona->update();
                    return Redirect::to('empleado');

    }// para borrar
}
