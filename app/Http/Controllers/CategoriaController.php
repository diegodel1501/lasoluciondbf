<?php

namespace LaSolucion\Http\Controllers;

use Illuminate\Http\Request;
use LaSolucion\Categoria;
use Illuminate\Support\Facades\Redirect;
use LaSolucion\Http\Requests\CategoriaFormRequest;
use DB;
class CategoriaController extends Controller
{
   
    public function __construct(){
$this->middleware('auth');

    }
     //la ruta resource maneja las siguientes funciones
    public function index(Request $request){
         
        if($request){
            $query=trim($request->get('searchText'));
            $categorias= DB::table('categoria')->where('nombre','LIKE','%'.$query.'%')->where('estado','=','activo')->orderBy('idcategoria','desc')->paginate(3);
            return view('inventario.categoria.index',["categorias"=>$categorias, "searchText"=>$query]);
            }
    }// para mostrar la pagina inicial 
    public function create(){
        
                return view("inventario.categoria.create");

    }// para crear un objeto del modelo

    public function store(CategoriaFormRequest $request){
         
        $categoria = new Categoria;
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->estado='activo';
        $categoria->save();// recordar manejar save
        return Redirect::to('categoria');


    }//para guardar un objeto en la bd

    public function show($id){
     
        return view("inventario.categoria.show",["categoria"=>Categoria::findOrFail($id)]);

    }//para mostrar
    public function edit($id){
      
        return view("inventario.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);


    }//para editar 
    public function update(CategoriaFormRequest $request, $id){
        
        $categoria=Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->update();
        return Redirect::to('categoria');

    }// para actualizar
    public function destroy($id){
                    $categoria=Categoria::findOrFail($id);
                    $categoria->estado='inactiva';
                    $categoria->update();
                    return Redirect::to('categoria');

    }// para borrar




}
