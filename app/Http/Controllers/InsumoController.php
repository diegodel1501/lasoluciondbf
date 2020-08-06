<?php

namespace LaSolucion\Http\Controllers;
use Illuminate\Http\Request;
use LaSolucion\Insumo;
use LaSolucion\DetalleInsumo;
use Illuminate\Support\Facades\Redirect;
use LaSolucion\Http\Requests\InsumoFormRequest;
use LaSolucion\Http\Requests\InsumoDFormRequest;
use Illuminate\Support\Facades\Input;
use DB;
class InsumoController extends Controller
{
      public function __construct(){
$this->middleware('auth');
    }
     //la ruta resource maneja las siguientes funciones
    public function index(Request $request){
         
        if($request){
            $query=trim($request->get('searchText'));
            $insumos=  DB::table('insumo')->where('nombre','LIKE','%'.$query.'%')->where('estado','=','activo')->orderBy('idinsumo','desc')->paginate(3);
            return view('inventario.insumo.index',["insumos"=>$insumos, "searchText"=>$query]);
            }
    }// para mostrar la pagina inicial 
    public function create(){
        $insumos=DB::table('insumo')->where('estado','=','activo')->get();
        return view("inventario.insumo.create",["insumos"=>$insumos]);
    }// para crear un objeto del modelo

    public function store(InsumoFormRequest $request){
        $insumo = new Insumo;
        $insumo->nombre=$request->get('nombre');
        $insumo->descripcion=$request->get('descripcion');
          if(Input::hasFile('imagen')){
                $file=Input::file('imagen');
                $file->move(public_path().'/imagenes/insumos/',$file->getClientOriginalName());
                $insumo->imagen=$file->getClientOriginalName();
            }
        $insumo->estado='activo';
        $insumo->save();// recordar manejar save
        return Redirect::to('insumo');
    }//para guardar un objeto en la bd
    public function anadir(){
          $insumos=DB::table('insumo')->where('estado','=','activo')->get();
            return view("inventario.insumo.Añadir",["insumos"=>$insumos]);
    }
    public function add(InsumoDFormRequest $request){
        $insumo=Insumo::findOrFail($request->get('idinsumo'));
        $insumo->stock=$insumo->stock+$request->get('cantidad');
        $detalleInsumo= new DetalleInsumo;
        $detalleInsumo->cantidad=$request->get('cantidad');
        $detalleInsumo->preciocompra=$request->get('preciocompra');
        $detalleInsumo->idinsumo=$request->get('idinsumo');
        $insumo->update();
        $detalleInsumo->save();
return Redirect::to('insumo');
    }
    public function show($id){
     
        return view("inventario.insumo.show",["insumo"=>Insumo::findOrFail($id)]);

    }//para mostrar
    public function edit($id){
       
        return view("inventario.insumo.edit",["insumo"=>Insumo::findOrFail($id)]);


    }//para editar 
    public function update(InsumoFormRequest $request, $id){
        $insumo =Insumo::findOrFail($id);
        $insumo->nombre=$request->get('nombre');
        $insumo->descripcion=$request->get('descripcion');
        if(Input::hasFile('imagen')){
                $file=Input::file('imagen');
                $file->move(public_path().'/imagenes/insumos/',$file->getClientOriginalName());
                $insumo->imagen=$file->getClientOriginalName();
            }
        $insumo->update();// recordar manejar save
       
        return Redirect::to('insumo');

    }// para actualizar
    public function destroy($id){
   
                    $insumo=Insumo::findOrFail($id);
                    $insumo->estado='inactivo';
                    $insumo->update();
                    return Redirect::to('insumo');

    }// para borrar
}
