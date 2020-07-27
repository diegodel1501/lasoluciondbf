<?php

namespace LaSolucion\Http\Controllers;

use Illuminate\Http\Request;

use LaSolucion\Http\Requests;
use LaSolucion\Persona;
use LaSolucion\Pedido;
use LaSolucion\Producto;
use LaSolucion\Insumo;
use LaSolucion\DetallePedido;
use LaSolucion\DetalleInsumo;
use LaSolucion\Composicion;
use DB;
class ReporteController extends Controller
{
   public function __construct()
    {
       $this->middleware('auth');

    }

    // Reportes de Vendedores

    public function vendedores(){
		// enviar informacion de vendedores

		$vendedores= DB::table('persona as p')
		->join('pedido as pe','p.idpersona','=','pe.idvendedor')
		->select('p.nombre','p.direccion','p.telefono','p.email','p.documento',DB::raw('count(pe.idvendedor) as pedidos'))
		->where('p.tipo_persona','=','vendedor')
		->groupBy('p.nombre','p.direccion','p.telefono','p.email','p.documento')
		->paginate(7);
        return view('Reportes.vendedor',["vendedores"=>$vendedores]);

    }



    public function panaderos(){
		$panaderos= DB::table('persona as p')
		->join('detalle_pedido as pe','p.idpersona','=','pe.idpanadero')
		->select('p.nombre','p.direccion','p.telefono','p.email','p.documento',DB::raw('count(pe.idpanadero) as pedidos'),DB::raw('sum(pe.cantidad) as productos'))
		->where('p.tipo_persona','=','panadero')
		->groupBy('p.nombre','p.direccion','p.telefono','p.email','p.documento')
		->paginate(7);
        return view('Reportes.panadero',["panaderos"=>$panaderos]);
    }

    public function clientes(){
    	$clientes= DB::table('persona as p')
		->join('pedido as pe','p.idpersona','=','pe.idcliente')
		->join('detalle_pedido as d','pe.idpedido','=','d.idpedido')
		 ->join('producto as pr','d.idproducto','=','pr.idproducto')
		->select('p.nombre','p.direccion','p.telefono','p.email','p.documento',DB::raw('count(pe.idcliente) as compras'),DB::raw('sum(d.cantidad*pr.valor) as total'))
		->where('p.tipo_persona','=','cliente')
		->groupBy('p.nombre','p.direccion','p.telefono','p.email','p.documento')
		->paginate(7);
        return view('Reportes.cliente',["clientes"=>$clientes]);
    }
   
    public function estadisticas(){
    	$pedidos=DB::table('pedido as pe')
		->join('detalle_pedido as d','pe.idpedido','=','d.idpedido')
		 ->join('producto as pr','d.idproducto','=','pr.idproducto')
    	->select('fechaentrega',DB::raw('sum(d.cantidad*pr.valor) as total'))
    	->groupBy('fechaentrega')
    	->get();
    	//productos con cantidad
    	$productos =DB::table('detalle_pedido as d')
    	->join('producto as p', 'd.idproducto','=','p.idproducto')
    	->select('p.nombre',DB::raw('sum(d.cantidad) as total'))
    	->groupBy('p.nombre')
    	->get();
    return view('Reportes.estadisticas',["pedidos"=>$pedidos,"productos"=>$productos]);
    }
}
