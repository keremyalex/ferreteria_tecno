<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('id')->get()->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'imagen' => $producto->imagen,
                'tamaño' => $producto->tamaño,
                'precio' => $producto->precio,
                'cantidad' => $producto->cantidad,
                'descripcion' => $producto->descripcion,
                'categoria' => $producto->categoria,
            ];
        });
        //$visitas = Visita::where('page_name', request()->path())->first();

        return Inertia::render('Productos/Index', [
            'productos' => $productos,
            //'visitas' => $visitas
        ]);
    }

    public function show(Producto $producto)
    {

        return Inertia::render('Productos/Show', [
            'producto' => $producto,
        ]);
    }


    public function create()
    {

        return Inertia::render('Productos/Create', []);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'imagen' => 'required',
            'tamaño' => 'required',
            'precio' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'descripcion' => 'required|max:255',
            'categoria' => 'required',
        ]);

        Producto::create([
            'nombre' => $request->nombre,
            'imagen' => $request->imagen,
            'tamaño' => $request->tamaño,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
        ]);
        return redirect()->route('productos.index');
    }

    public function edit(Producto $producto)
    {

        return Inertia::render('Productos/Edit', [
            'producto' => $producto,
        ]);
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required',
            'imagen' => 'required',
            'tamaño' => 'required',
            'precio' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'descripcion' => 'required|max:255',
            'categoria' => 'required',
        ]);

        $producto->update([
            'nombre' => $request->nombre,
            'imagen' => $request->imagen,
            'tamaño' => $request->tamaño,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
        ]);

        return redirect()->route('productos.index');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index');
    }
}
