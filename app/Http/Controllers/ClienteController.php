<?php

namespace LaSolucion\Http\Controllers;

use Illuminate\Http\Request;
use LaSolucion\Persona;
use Illuminate\Support\Facades\Redirect;
use LaSolucion\Http\Requests\PersonaFormRequest;
use DB;
class ClienteController extends Controller
{
  
    public function __construct(){
$this->middleware('auth');

    }
     //la ruta resource maneja las siguientes funciones
    public function index(Request $request){
         
        if($request){
            $query=trim($request->get('searchText'));
            $personas= DB::table('persona')->where('nombre','LIKE','%'.$query.'%')->where('estado','=','activo')->where('tipo_persona','=','cliente')->orwhere('documento','LIKE','%'.$query.'%')->where('estado','=','activo')->where('tipo_persona','=','cliente')->orderBy('idPersona','desc')->paginate(3);
            return view('ventas.cliente.index',["personas"=>$personas, "searchText"=>$query]);
            }
    }// para mostrar la pagina inicial 
    public function create(){
        
                return view("ventas.cliente.create");

    }// para crear un objeto del modelo

    public function store(PersonaFormRequest $request){
         
        $persona = new Persona;
        $persona->tipo_persona='cliente';
        $persona->nombre=$request->get('nombre');
        $persona->documento=$request->get('documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');
        $persona->estado='activo';
        $persona->save();// recordar manejar save
        return Redirect::to('cliente');


    }//para guardar un objeto en la bd

    public function show($id){
     
        return view("ventas.cliente.show",["persona"=>Persona::findOrFail($id)]);

    }//para mostrar
    public function edit($id){
      
        return view("ventas.cliente.edit",["persona"=>Persona::findOrFail($id)]);


    }//para editar 
    public function update(PersonaFormRequest $request, $id){
        $persona =Persona::findOrFail($id);
        $persona->nombre=$request->get('nombre');
        $persona->documento=$request->get('documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');
        $persona->estado='activo';
        $persona->update();
        return Redirect::to('cliente');

    }// para actualizar
    public function destroy($id){
   
                    $persona=Persona::findOrFail($id);
                    $persona->estado='inactivo';
                    $persona->update();
                    return Redirect::to('cliente');

    }// para borrar


}
