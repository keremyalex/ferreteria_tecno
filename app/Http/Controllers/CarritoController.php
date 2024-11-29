<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\DetallePedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use GuzzleHttp\Client;
use Carbon\Carbon;

class CarritoController extends Controller
{
    public function index(){
        $pedido = Pedido::where('user_id', auth()->user()->id)->where('estado', 'pendiente')->first();
        if($pedido){
            $detalles = PedidoDetalle::where('pedido_id', $pedido->id)->get()->map(function($detalle){
                return [
                    'id' => $detalle->id,
                    'pedido_id' => $detalle->pedido_id,
                    'producto_id' => $detalle->producto_id,
                    'cantidad' => $detalle->cantidad,
                    'precio' => $detalle->precio,
                    'producto' => $detalle->producto
                ];
            });
            $total = $detalles->sum('precio');
            // dd([
            //     'pedido' => $pedido,
            //     'detalles' => $detalles,
            //     'total' => $total
            // ]);
            return Inertia::render('Carrito/Index',[
                'pedido' => $pedido,
                'detalles' => $detalles,
                'total' => $total
            ]);
        }


        return Inertia::render('Carrito/Index',[
            'pedido' => null,
            'detalles' => null,
            'total' => 0
        ]);
    }

    public function store(Request $request){
        if(auth()->user()->hasCarrito()){
            $pedido = auth()->user()->hasCarrito();
        }else{
            $now = Carbon::now();
            $pedido = Pedido::create([
                'fecha' => $now->toDateString(),
                'hora' => $now->format('H:i'),
                'monto_total' => 0,
                'estado' => 'pendiente',
                'user_id' => auth()->user()->id,
            ]);
        }

        $producto = Producto::find($request->producto_id);

        $detalle = PedidoDetalle::where('pedido_id', $pedido->id)->where('producto_id', $producto->id)->first();
        if($detalle){
            $detalle->cantidad = $detalle->cantidad + $request->cantidad;
            $detalle->precio = $detalle->cantidad * $producto->precio;
            $detalle->save();
        }else{
            $detalle = PedidoDetalle::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $producto->id,
                'cantidad' => $request->cantidad,
                'precio' => $request->cantidad * $producto->precio
            ]);
        }

        $pedido->monto_total = $pedido->monto_total + $detalle->precio;
        $pedido->save();
        return redirect()->route('carrito.index');

    }

    public function destroy(PedidoDetalle $detalle){
        $pedido = Pedido::find($detalle->pedido_id);
        $pedido->monto_total = $pedido->monto_total - $detalle->precio;
        $pedido->save();
        $detalle->delete();
        if($pedido->monto_total == 0){
            $pedido->delete();
        }
        return redirect()->route('carrito.index');
    }


    // public function checkout(Request $request){

    //     $pedido = Pedido::find($request->id);

    //     $tcCommerceID = env('PAGOFACIL_COMMERCEID');
    //     $AccessToken = env('PAGOFACIL_ACCESSTOKEN');
    //     // $tcTokenServicio = env('PAGOFACIL_TOKENSERVICE');
    //     // $tcTokenSecret = env('PAGOFACIL_TOKENSECRET');
    //     $tcUrlCallBack =  env('PAGOFACIL_URLCALLBACK');
    //     $tcUrlReturn = env('PAGOFACIL_URLRETURN');

    //     $url = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/pagoqr";

    //     $dataHeader = [
    //         "Accept" => "*/*",
    //         "Authorization" => "Bearer ".$AccessToken,
    //         "Content-Type" => "application/json"
    //     ];

    //     $taPedidoDetalle = [
    //         "Serial" => $pedido->id,
    //         "Producto" => "Pedido ".$pedido->id,
    //         "Cantidad" => 1,
    //         "Precio" => $pedido->total,
    //         "Descuento" => 0,
    //         "Total" => $pedido->total,
    //     ];

    //     $dataBody = [
    //         "tcCommerceID"          => $tcCommerceID,
    //         "tcNroPago"             => "pago ".rand(1000, 9999),
    //         "tcNombreUsuario"       => $pedido->cliente->user->name,
    //         "tnCiNit"               => (int)$pedido->cliente->ci_nit,
    //         "tnTelefono"            => (int)$pedido->cliente->numeroTelf,
    //         "tcCorreo"              => $pedido->cliente->user->email,
    //         "tcCodigoClienteEmpresa"=> $pedido->cliente->id,
    //         "tnMontoClienteEmpresa" => (int)$pedido->total,
    //         "tnMoneda"              => 2,
    //         "tcUrlCallBack"         => $tcUrlCallBack,
    //         "tcUrlReturn"           => $tcUrlReturn,
    //         "taPedidoDetalle"       => $taPedidoDetalle,
    //         // "tcTokenSecret"         => $tcTokenSecret,
    //         // "tcTokenServicio"       => $tcTokenServicio,
    //         // "tcPedidoID"            => $this->pedido->id,
    //     ];

    //     $clienteHTTP = new Client();

    //     $response = $clienteHTTP->request('POST', $url, [
    //         'headers' => $dataHeader,
    //         'json' => $dataBody
    //     ]);

    //     $decodedJSON = json_decode($response->getBody()->getContents());

    //     $values = explode(";", $decodedJSON->values)[1];
    //     $QR = "data:image/png;base64,".json_decode($values)->qrImage;

    //     return response()->json(['qr' => $QR]);
    // }

    // public function pagado(){
    //     return Inertia::render('Carrito/Pagado');
    // }

}
