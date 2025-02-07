<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\MetodoPago;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request as PostRequest;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $param = PostRequest::get('search');

        $param = ($param == NULL) ? ($param = '') : $param;
        $customers = Cliente::where('nombre', 'like', '%' . $param . '%')
            ->limit(5)
            ->get();

        $payment_methods = MetodoPago::all();
        return Inertia::render(
            'Pos/Index',
            [
                'customers' => $customers,
                'payment_methods' => $payment_methods
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required|unique:customers'
            ],
            [
                'nombre.required' => 'Es requerido',
                'nombre.unique' => 'Ya se encuentra registrado',
            ]
        );

        $request->merge([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'ciudad' => $request->ciudad,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'rfc' => $request->rfc,
            'razon_social' => $request->razon_social,
            'empresa' => $request->empresa
        ]);
        Cliente::create($request->all());
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate(
            [
                'nombre' => ['required', 'string', Rule::unique('clientes')->ignore($cliente->id)]
            ],
            [
                'nombre.required' => 'Es requerido',
                'nombre.unique' => 'Ya se encuentra registrado',
            ]
        );
        $cliente->nombre = $request->nombre;
        $cliente->email = $request->email;
        $cliente->ciudad = $request->ciudad;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->rfc = $request->rfc;
        $cliente->nombre = $request->nombre;
        $cliente->razon_social = $request->razon_social;
        $cliente->empresa = $request->empresa;
        $cliente->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
