<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoVariacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productId = 1;
        $product = Producto::find($productId);
        $productVariations = $product->variaciones;
        $attributesGrouped = [];
        foreach ($productVariations as $variation) {
            $attributeValues = $variation->attributeValues;

            foreach ($attributeValues as $attributeValue) {
                $attributeName = $attributeValue->atributo->nombre;
                // Si el atributo no existe en el array, crearlo
                if (!isset($attributesGrouped[$attributeName])) {
                    $attributesGrouped[$attributeName] = [];
                }

                // Agregar el valor del atributo al array del atributo correspondiente
                $attributesGrouped[$attributeName][] = ['atributo' => $attributeName, 'valor' => $attributeValue->valor, 'id' =>  $attributeValue->id];
            }
        }

        foreach ($attributesGrouped as $key => $values) {
            $attributesGrouped[$key] = $this->eliminarDuplicados($values);
        }
        return $attributesGrouped;
    }
    private function eliminarDuplicados($array)
    {
        $unicos = [];
        return array_values(array_filter($array, function ($item) use (&$unicos) {
            $clave = $item['atributo'] . "-" . $item['valor'] . "-" . $item['id'];
            if (in_array($clave, $unicos)) {
                return false;
            }
            $unicos[] = $clave;
            return true;
        }));
    }
    public function precio()
    {
        //return "hola mundo";
        $productId = 1;
        $selectedAttributeValues = [1, 4];
        $variation = ProductoVariacion::where('producto_id', $productId)
            ->whereHas('atributos', function ($query) use ($selectedAttributeValues) {
                $query->whereIn('atributo_valor_id', $selectedAttributeValues);
            }, '=', count($selectedAttributeValues))
            ->first();

        if ($variation) {
            return response()->json(['price' => $variation]);
        }

        return response()->json(['message' => 'No se encontro una variacion para la combinacion seleccionada'], 404);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Productos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
