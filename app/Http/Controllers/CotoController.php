<?php

namespace App\Http\Controllers;

use App\Models\Coto;
use Illuminate\Http\Request;

class CotoController extends Controller
{
    /**
     * Lista todos los cotos.
     */
    public function index(Request $request)
    {
        $query = Coto::withCount('residentes');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%')
                  ->orWhere('responsable', 'like', '%' . $request->buscar . '%');
        }

        $cotos = $query->latest()->paginate(10);

        return view('cotos.index', compact('cotos'));
    }

    /**
     * Formulario para crear un nuevo coto.
     */
    public function create()
    {
        return view('cotos.create');
    }

    /**
     * Guarda un nuevo coto.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'direccion'   => 'required|string|max:500',
            'responsable' => 'required|string|max:255',
            'telefono'    => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
        ]);

        Coto::create($validated);

        return redirect()->route('cotos.index')
            ->with('success', 'Coto registrado correctamente.');
    }

    /**
     * Muestra el detalle de un coto.
     */
    public function show(Coto $coto)
    {
        $coto->load(['residentes' => fn ($q) => $q->withCount('pagos')]);

        return view('cotos.show', compact('coto'));
    }

    /**
     * Formulario para editar un coto.
     */
    public function edit(Coto $coto)
    {
        return view('cotos.edit', compact('coto'));
    }

    /**
     * Actualiza un coto existente.
     */
    public function update(Request $request, Coto $coto)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'direccion'   => 'required|string|max:500',
            'responsable' => 'required|string|max:255',
            'telefono'    => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'activo'      => 'boolean',
        ]);

        $coto->update($validated);

        return redirect()->route('cotos.index')
            ->with('success', 'Coto actualizado correctamente.');
    }

    /**
     * Elimina un coto (soft delete).
     */
    public function destroy(Coto $coto)
    {
        $coto->delete();

        return redirect()->route('cotos.index')
            ->with('success', 'Coto eliminado correctamente.');
    }
}
