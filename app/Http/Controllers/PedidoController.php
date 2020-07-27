<?php

namespace LaSolucion\Http\Controllers;

use Illuminate\Http\Request;
use LaSolucion\Pedido;
use LaSolucion\Persona;
use LaSolucion\DetallePedido;
use Illuminate\Support\Facades\Redirect;
use LaSolucion\Http\Requests\PedidoFormRequest;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
class PedidoController extends Controller
{
       public function __construct(){
$this->middleware('auth');

    }
     //la ruta resource maneja las siguientes funciones
    public function index(Request $request){
         
        if($request){
            $query=trim($request->get('searchText'));
            $pedidos= DB::table('pedido as p')
            ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
            ->join('producto as pr','d.idproducto','=','pr.idproducto')
            ->select('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
            ->where('p.idpedido','LIKE','%'.$query.'%')->orderBy('p.idpedido','desc')
            ->groupBy('p.idpedido','p.idvendedor','p.idcliente','P.fechacreacion','p.fechaentrega','p.estado')
            ->paginate(3);
                $vendedores =DB::table('persona')->where('tipo_persona','=','vendedor')->get();
                $clientes =DB::table('persona')->where('tipo_persona','=','cliente')->get();
                $panaderos =DB::table('persona')->where('tipo_persona','=','panadero')->get();
            return view('ventas.pedido.index',["vendedores"=>$vendedores,'clientes'=>$clientes,"pedidos"=>$pedidos, "searchText"=>$query]);
            }
    }// para mostrar la pagina inicial 

    public function create(){
    	$vendedores =DB::table('persona')->where('tipo_persona','=','vendedor')->get();
    	$clientes =DB::table('persona')->where('tipo_persona','=','cliente')->get();
        $panaderos =DB::table('persona')->where('tipo_persona','=','panadero')->get();
    	$productos =DB::table('producto')->where('estado','=','activo')->get();
    	  return view("ventas.pedido.create",["vendedores"=>$vendedores,'clientes'=>$clientes,'panaderos'=>$panaderos,'productos'=>$productos]);

    }
    public function store(PedidoFormRequest $request){

    	try {
    		DB::beginTransaction();
    		$pedido = new Pedido;
    		$pedido->idcliente=$request->get('idcliente');
    		$pedido->idvendedor=$request->get('idvendedor');
    		$pedido->fechaentrega=$request->get('fechaentrega');
            // establecemos la ultima alerta del pedido ayer para enviar cada dia una alerta desde que falten 3 dias
            $pedido->ultimaalerta=strtotime("-1 days");
    		$fecha=Carbon::now('America/Santiago');
    		$pedido->fechacreacion=$fecha->toDateTimeString();
    		$pedido->estado='activo';
			//arrays detalle
    		$idproducto=$request->get('idproducto');
    		$cantidad=$request->get('cantidad');
            $idpanadero=$request->get('idpanadero');
    		$pedido->save();
    		//recorrer los array
    		$cont=0;
    		while($cont<count($idproducto)){
    			$detalle = new DetallePedido;
    			$detalle->idproducto=$idproducto[$cont];
    			$detalle->cantidad=$cantidad[$cont];
    			$detalle->idpedido=$pedido->idpedido;
                $detalle->idpanadero=$idpanadero[$cont];
    			$detalle->save();
    			$cont=$cont+1;

    		}

    		DB::commit();
    	} catch (Exception $e) {
    		DB::rollBack();
    	}
    	return Redirect::to('pedido');

    }

    public function show($id){

    	$pedido=DB::table('pedido as p')
        ->join('detalle_pedido as d','p.idpedido','=','d.idpedido')
        ->join('producto as pr','d.idproducto','=','pr.idproducto')
        ->select('p.idvendedor','p.idcliente','p.idpedido','P.fechacreacion','p.fechaentrega','p.estado',DB::raw('sum(d.cantidad*pr.valor) as total'))
        ->where('p.idpedido','=',$id)
        ->groupBy('p.idvendedor','p.idcliente','p.idpedido','P.fechacreacion','p.fechaentrega','p.estado')
        ->first();

    	$detalles=DB::table('producto as p')->join('detalle_pedido as d','p.idproducto','=','d.idproducto')->select('p.nombre','idpanadero as idpanaderoA','d.cantidad','p.valor','p.tiempoelaboracion')->where('d.idpedido','=',$id)->get();
        $panaderos=DB::table('persona')->select('idPersona as idpanaderoB','nombre')->where('tipo_persona','=','panadero')->get();
        $vendedor=Persona::findOrFail($pedido->idvendedor);
        $cliente=Persona::findOrFail($pedido->idcliente);
    	return view("ventas.pedido.show",["pedido"=>$pedido,"productos"=>$detalles,'vendedor'=>$vendedor,'cliente'=>$cliente,'panaderos'=>$panaderos]);

    }


    public function destroy($id){
    	$pedido=Pedido::findOrFail($id);
    	$pedido->estado="terminado";
    	$pedido->update();
    	return Redirect::to('pedido');

    }
}
