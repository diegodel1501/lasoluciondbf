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
use Carbon\Carbon;
class ReporteController extends Controller
{
   public function __construct()
    {
       $this->middleware('auth');

    }

    // Reportes de Vendedores

    public function vendedores(Request $request){
		// enviar informacion de vendedores
            $vendedores= DB::table('persona as p')
        ->join('pedido as pe','p.idpersona','=','pe.idvendedor')
        ->select('p.nombre','p.idpersona','p.documento',DB::raw('count(pe.idvendedor) as pedidos'))
        ->where('p.tipo_persona','=','vendedor')
        ->groupBy('p.nombre','p.idpersona','p.documento')
        ->paginate(7);
            
            if($request){
            $query=trim($request->get('searchText'));
           $vendedores= DB::table('persona as p')
        ->join('pedido as pe','p.idpersona','=','pe.idvendedor')
        ->select('p.nombre','p.idpersona','p.documento',DB::raw('count(pe.idvendedor) as pedidos'))
        ->where('p.tipo_persona','=','vendedor')
        ->where('p.nombre','LIKE','%'.$query.'%')
        ->orwhere('p.tipo_persona','=','vendedor')
        ->where('p.documento','LIKE','%'.$query.'%')
        ->groupBy('p.nombre','p.idpersona','p.documento')
        ->paginate(7);
            }
	
        return view('Reportes.vendedor',["vendedores"=>$vendedores,"searchText"=>$query]);

    }
    public function verV($id){
        // obtener pedidos de ese vendedor
            $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->where('p.idvendedor','=', $id)
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);
        $vendedor=Persona::FindOrFail($id);
        $clientes=DB::table('persona')->where('tipo_persona','=','cliente')->get();
        return view('Reportes.VerV',['pedidos'=>$pedidos,'vendedor'=>$vendedor,'clientes'=>$clientes]);
    }
       public function verVfechas(Request $request){
        // obtener pedidos de ese vendedor
         $fechadesde = $request->get('fechadesde');
            $list = explode('/', $fechadesde);
            $fechadesde=$list[2].'-'.$list[0].'-'.$list[1];
            $fechahasta = $request->get('fechahasta');
            $list = explode('/', $fechahasta);
            $fechahasta=$list[2].'-'.$list[0].'-'.$list[1];
            $fechadesde=date($fechadesde);
            $fechahasta=date($fechahasta);
    if($request->fechasselect=="ingreso"){
            $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->whereBetween('fechacreacion', [$fechadesde, $fechahasta])->where('p.idvendedor','=', $request->idvendedor)
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);
    }else{
         $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->whereBetween('fechaentrega',[$fechadesde, $fechahasta])->where('p.idvendedor','=', $request->idvendedor)
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);

    }
      $vendedor=Persona::FindOrFail($request->idvendedor);
        $clientes=DB::table('persona')->where('tipo_persona','=','cliente')->get();
        return view('Reportes.verVfechas',['pedidos'=>$pedidos,'clientes'=>$clientes,'fechadesde'=>$fechadesde,'fechahasta'=>$fechahasta,'vendedor'=>$vendedor]);
    }
    public function verC($id){
        // obtener pedidos de ese vendedor
            $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->where('p.idcliente','=', $id)
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);
        $cliente=Persona::FindOrFail($id);
        $vendedores=DB::table('persona')->where('tipo_persona','=','vendedor')->get();
        return view('Reportes.VerC',['pedidos'=>$pedidos,'cliente'=>$cliente,'vendedores'=>$vendedores]);
    }
       public function verCfechas(Request $request){
        // obtener pedidos de ese vendedor
         $fechadesde = $request->get('fechadesde');
            $list = explode('/', $fechadesde);
            $fechadesde=$list[2].'-'.$list[0].'-'.$list[1];
            $fechahasta = $request->get('fechahasta');
            $list = explode('/', $fechahasta);
            $fechahasta=$list[2].'-'.$list[0].'-'.$list[1];
            $fechadesde=date($fechadesde);
            $fechahasta=date($fechahasta);
    if($request->fechasselect=="ingreso"){
            $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->whereBetween('fechacreacion', [$fechadesde, $fechahasta])->where('p.idcliente','=', $request->idcliente)
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);
    }else{
         $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->whereBetween('fechaentrega',[$fechadesde, $fechahasta])->where('p.idcliente','=', $request->idcliente)
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);

    }
      $cliente=Persona::FindOrFail($request->idcliente);
        $vendedores=DB::table('persona')->where('tipo_persona','=','vendedor')->get();
        return view('Reportes.verCfechas',['pedidos'=>$pedidos,'vendedores'=>$vendedores,'fechadesde'=>$fechadesde,'fechahasta'=>$fechahasta,'cliente'=>$cliente]);
    }



    public function panaderos(Request $request){
		$panaderos= DB::table('persona as p')
		->join('detalle_pedido as pe','p.idpersona','=','pe.idpanadero')
		->select('idPersona','p.nombre','p.direccion','p.telefono','p.email','p.documento',DB::raw('count(pe.idpanadero) as pedidos'),DB::raw('sum(pe.cantidad) as productos'))
		->where('p.tipo_persona','=','panadero')
		->groupBy('idPersona','p.nombre','p.direccion','p.telefono','p.email','p.documento')
		->paginate(7);

            if($request){
            $query=trim($request->get('searchText'));
            $panaderos= DB::table('persona as p')
        ->join('detalle_pedido as pe','p.idpersona','=','pe.idpanadero')
        ->select('idPersona','p.nombre','p.direccion','p.telefono','p.email','p.documento',DB::raw('count(pe.idpanadero) as pedidos'),DB::raw('sum(pe.cantidad) as productos'))
        ->where('p.tipo_persona','=','panadero')
        ->where('p.nombre','LIKE','%'.$query.'%')
        ->orwhere('p.tipo_persona','=','panadero')
        ->where('p.documento','LIKE','%'.$query.'%')
        ->groupBy('idPersona','p.nombre','p.direccion','p.telefono','p.email','p.documento')
        ->paginate(7);
            }   
        return view('Reportes.panadero',["panaderos"=>$panaderos,"searchText"=>$query]);
    }
      public function verP($id){
        // obtener pedidos de ese vendedor
            $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->where('d.idpanadero','=', $id)
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);
        $panadero=Persona::FindOrFail($id);
        $clientes=DB::table('persona')->where('tipo_persona','=','cliente')->get();
        $vendedores=DB::table('persona')->where('tipo_persona','=','vendedor')->get();
        return view('Reportes.VerP',['pedidos'=>$pedidos,'panadero'=>$panadero,'clientes'=>$clientes,'vendedores'=>$vendedores]);
    }
       public function verPfechas(Request $request){
        // obtener pedidos de ese vendedor
         $fechadesde = $request->get('fechadesde');
            $list = explode('/', $fechadesde);
            $fechadesde=$list[2].'-'.$list[0].'-'.$list[1];
            $fechahasta = $request->get('fechahasta');
            $list = explode('/', $fechahasta);
            $fechahasta=$list[2].'-'.$list[0].'-'.$list[1];
            $fechadesde=date($fechadesde);
            $fechahasta=date($fechahasta);
    if($request->fechasselect=="ingreso"){
            $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->whereBetween('fechacreacion', [$fechadesde, $fechahasta])->where('d.idpanadero','=', $request->idpanadero)
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);
    }else{
         $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->whereBetween('fechaentrega',[$fechadesde, $fechahasta])->where('d.idpanadero','=', $request->idpanadero)
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);

    }
      $panadero=Persona::FindOrFail($request->idpanadero);
        $clientes=DB::table('persona')->where('tipo_persona','=','cliente')->get();
        $vendedores=DB::table('persona')->where('tipo_persona','=','vendedor')->get();
        return view('Reportes.verPfechas',['pedidos'=>$pedidos,'clientes'=>$clientes,'vendedores'=>$vendedores,'fechadesde'=>$fechadesde,'fechahasta'=>$fechahasta,'panadero'=>$panadero]);
    }
    public function fechas(request $request){

         // obtener pedidos de ese vendedor
         $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);
        if($request->get('fechadesde')){
          $fechadesde = $request->get('fechadesde');
            $list = explode('/', $fechadesde);
            $fechadesde=$list[2].'-'.$list[0].'-'.$list[1];
            $fechahasta = $request->get('fechahasta');
            $list = explode('/', $fechahasta);
            $fechahasta=$list[2].'-'.$list[0].'-'.$list[1];
            $fechadesde=date($fechadesde);
            $fechahasta=date($fechahasta);  
             if($request->fechasselect=="ingreso"){
                $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->whereBetween('fechacreacion', [$fechadesde, $fechahasta])
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);
            }else{
                $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->whereBetween('fechaentrega',[$fechadesde, $fechahasta])
            ->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(7);
            }   
        }
            
             

            
             $clientes=DB::table('persona')->where('tipo_persona','=','cliente')->get();
        $vendedores=DB::table('persona')->where('tipo_persona','=','vendedor')->get();
        return view('Reportes.verfechas',['pedidos'=>$pedidos,'clientes'=>$clientes,'vendedores'=>$vendedores]);
    }
    public function clientes(Request $request){
    	$clientes= DB::table('persona as p')
		->join('pedido as pe','p.idpersona','=','pe.idcliente')
		->join('detalle_pedido as d','pe.idpedido','=','d.idpedido')
		 ->join('producto as pr','d.idproducto','=','pr.idproducto')
		->select('idPersona','p.nombre','p.direccion','p.telefono','p.email','p.documento',DB::raw('count(pe.idcliente) as compras'),DB::raw('sum(d.cantidad*pr.valor) as total'))
		->where('p.tipo_persona','=','cliente')
		->groupBy('idPersona','p.nombre','p.direccion','p.telefono','p.email','p.documento')
		->paginate(7);
          if($request){
            $query=trim($request->get('searchText'));
                $clientes= DB::table('persona as p')
        ->join('pedido as pe','p.idpersona','=','pe.idcliente')
        ->join('detalle_pedido as d','pe.idpedido','=','d.idpedido')
         ->join('producto as pr','d.idproducto','=','pr.idproducto')
        ->select('idPersona','p.nombre','p.direccion','p.telefono','p.email','p.documento',DB::raw('count(pe.idcliente) as compras'),DB::raw('sum(d.cantidad*pr.valor) as total'))
        ->where('p.tipo_persona','=','cliente')
        ->where('p.nombre','LIKE','%'.$query.'%')
        ->orwhere('p.tipo_persona','=','cliente')
        ->where('p.documento','LIKE','%'.$query.'%')
        ->groupBy('idPersona','p.nombre','p.direccion','p.telefono','p.email','p.documento')
        ->paginate(7);
        }
        return view('Reportes.cliente',["clientes"=>$clientes,"searchText"=>$query]);
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
