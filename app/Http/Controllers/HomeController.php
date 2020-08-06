<?php

namespace LaSolucion\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use LaSolucion\Http\Requests;
use Illuminate\Http\Request;
use LaSolucion\Pedido;
use DB;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // verificar pedidos
        $pedidos=DB::table('Pedido')->select('idpedido','fechaentrega','ultimaalerta')->where('estado','=','activo')->get();

        foreach ($pedidos as $pedido) {
            $fechaentrega=strtotime(date($pedido->fechaentrega,time()));
            $ultimalerta=$pedido->ultimaalerta;
            //fecha actual + 3 dias
            $fechaactual3=strtotime("+3 days");
            if($fechaactual3 > $fechaentrega){
                // enviar alerta 
                if($ultimalerta<strtotime(Carbon::now('America/Santiago'))){
                    try {
                         // $data va a la vista 
                       $data=array(
                        'id' => $pedido->idpedido ,
                        'fecha'=>$pedido->fechaentrega,
                        'insumos'=>DB::table("detalle_pedido")->select('idproducto','cantidad')->where('idpedido','=',$pedido->idpedido)->get(),
                        'productos'=>DB::table("producto")->select('idproducto','nombre')->get()

                    );
                       Mail::send('emails.alert',$data,function($message){
                        $message->from('panaderialasolucion@gmail.com','test');
                        $message->to('duegix@gmail.com')->subject('test');

                    }); 
                       $pedidoa=Pedido::findOrFail($pedido->idpedido);
                       $pedidoa->ultimaalerta=strtotime("+ 1 days");
                       $pedidoa->update();

                   } catch (\Exception $e) {
                       echo'<script type="text/javascript">
                       alert("error al enviar el correo electronico,el pedido'.$pedido->idpedido.' no fue enviado y tiene fecha de entrega: '.$pedido->fechaentrega.', revise certificados de seguridad o contacte con el administrador de la WEB.");
                       </script>';
                   }
               }
           }
       }

       return view('index');
   }
}
