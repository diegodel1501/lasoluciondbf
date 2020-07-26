<?php

namespace LaSolucion\Http\Controllers;

use Illuminate\Http\Request;
use LaSolucion\Producto;
use LaSolucion\Composicion;
use LaSolucion\Insumo;
use LaSolucion\Categoria;
use Illuminate\Support\Facades\Redirect;
use LaSolucion\Http\Requests\ProductoFormRequest;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Support\Collection;
class ProductoController extends Controller
{
     public function __construct(){
$this->middleware('auth');
    }
     //la ruta resource maneja las siguientes funciones
    public function index(Request $request){
         
        if($request){
            $query=trim($request->get('searchText'));
            $productos= DB::table('producto as p')
            ->Join('categoria as c', 'p.idcategoria','=','c.idcategoria')
            ->select('p.idproducto','p.costoProduccion','p.nombre','p.valor','c.nombre as categoria','p.descripcion','p.imagen','p.estado','p.tiempoelaboracion')
            ->where('p.nombre','LIKE','%'.$query.'%')
            ->where('p.estado','=','activo')
            ->orwhere('c.nombre','LIKE','%'.$query.'%')
            ->where('c.estado','=','activo')
            ->orderBy('p.idproducto','desc')
            ->paginate(3);
            return view('inventario.producto.index',["productos"=>$productos, "searchText"=>$query]);

            }
    }// para mostrar la pagina inicial 
    public function create(){
                $categorias= DB::table('categoria')->where('estado','=','activo')->get();
                $insumos=DB::table('insumo as i')
                         ->select('i.idinsumo','i.nombre','i.stock', DB::raw('SUM(d.cantidad) as totalcomprado'),DB::raw('SUM(d.preciocompra) as costototal'))
                         ->Join('detalle_insumo as d', 'i.idinsumo','=', 'd.idinsumo')
                         ->where('i.estado','=','activo')
                         ->groupBy('i.idinsumo','i.nombre','i.stock')
                         ->get();
                return view("inventario.producto.create",['categorias'=>$categorias,'insumos'=>$insumos]);

    }// para crear un objeto del modelo

    public function store(ProductoFormRequest $request){
        try {
            DB::beginTransaction();
            $producto = new Producto;
            $producto->nombre=$request->get('nombre');
            $producto->descripcion=$request->get('descripcion');
            $producto->valor=$request->get('valor');
            $producto->idcategoria=$request->get('idcategoria');
            $producto->tiempoelaboracion=$request->get('tiempoelaboracion');
            $producto->costoProduccion=$request->get('costo');
            if(Input::hasFile('imagen')){
                $file=Input::file('imagen');
                $file->move(public_path().'/imagenes/productos/',$file->getClientOriginalName());
                $producto->imagen=$file->getClientOriginalName();
            }
            $producto->estado='activo';
            $producto->save();
            //arrays insumo
            $idinsumo=$request->get('idinsumo');
            $cantidad=$request->get('cantidad');
            //recorrer los array
            $cont=0;
            while($cont<count($idinsumo)){
                $composicion = new Composicion;
                $composicion->idproducto=$producto->idproducto;
                $composicion->idinsumo=$idinsumo[$cont];
                $composicion->cantidad_consumida=$cantidad[$cont];
                $insumo = Insumo::findOrFail($idinsumo[$cont]);
                $composicion->save();  
                $cont=$cont+1;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return Redirect::to('producto');


    }//para guardar un objeto en la bd

    public function show($id){
     
        return view("inventario.categoria.show",["categoria"=>Categoria::findOrFail($id)]);

    }//para mostrar
    public function edit($id){
        $insumos=DB::table('insumo as i')
                         ->select('i.idinsumo','i.nombre','i.stock', DB::raw('SUM(d.cantidad) as totalcomprado'),DB::raw('SUM(d.preciocompra) as costototal'))
                         ->Join('detalle_insumo as d', 'i.idinsumo','=', 'd.idinsumo')
                         ->where('i.estado','=','activo')
                         ->groupBy('i.idinsumo','i.nombre','i.stock')
                         ->get();
        $insumosutilizados=DB::table('insumo as i')
                         ->select('i.idinsumo','i.nombre','c.cantidad_consumida', DB::raw('SUM(d.cantidad) as totalcomprado'),DB::raw('SUM(d.preciocompra) as costototal'))
                         ->Join('detalle_insumo as d', 'i.idinsumo','=','d.idinsumo')
                          ->Join('composicion as c', 'c.idinsumo', '=','d.idinsumo')
                         ->where('i.estado','=','activo')
                         ->where('c.idproducto','=',$id)
                         ->groupBy('i.idinsumo','i.nombre','c.cantidad_consumida')
                         ->get();
       $categorias= DB::table('categoria')->where('estado','=','activo')->get();
        return view("inventario.producto.edit",["producto"=>Producto::findOrFail($id),'categorias'=>$categorias,'insumos'=>$insumos,'insumosutilizados'=>$insumosutilizados]);


    }//para editar 
    public function update(ProductoFormRequest $request, $id){
        try {
            DB::beginTransaction();
            $producto =Producto::findOrFail($id);
            $producto->nombre=$request->get('nombre');
            $producto->descripcion=$request->get('descripcion');
            $producto->valor=$request->get('valor');
            $producto->idcategoria=$request->get('idcategoria');
            $producto->tiempoelaboracion=$request->get('tiempoelaboracion');
            $producto->costoProduccion=$request->get('costo');
            if(Input::hasFile('imagen')){
                $file=Input::file('imagen');
                $file->move(public_path().'/imagenes/productos/',$file->getClientOriginalName());
                $producto->imagen=$file->getClientOriginalName();
            }
            $producto->estado='activo';
            $producto->save();
            //arrays insumo
            $idinsumo=$request->get('idinsumo');
            $cantidad=$request->get('cantidad');
            //reestablecer composiciones
            DB::delete('delete from composicion where idproducto = ?',[$id]);
            //recorrer los array
            $cont=0;
            while($cont<count($idinsumo)){

                $composicion = new Composicion;
                $composicion->idproducto=$producto->idproducto;
                $composicion->idinsumo=$idinsumo[$cont];
                $composicion->cantidad_consumida=$cantidad[$cont];
                $composicion->save();  
                $cont=$cont+1;

            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
       
        return Redirect::to('producto');

    }// para actualizar
    public function destroy($id){
   
                    $producto=Producto::findOrFail($id);
                    $producto->estado='inactivo';
                    $producto->update();
                    return Redirect::to('producto');

    }// para borrar

}
