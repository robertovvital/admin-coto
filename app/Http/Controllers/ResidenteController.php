<?php

namespace App\Http\Controllers;

use App\Models\Coto;
use App\Models\Residente;
use Illuminate\Http\Request;

class ResidenteController extends Controller
{
    /**
     * Lista todos los residentes.
     */
    public function index(Request $request)
    {
        $query = Residente::with('coto');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%')
                  ->orWhere('email', 'like', '%' . $request->buscar . '%')
                  ->orWhere('casa', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('coto_id')) {
            $query->where('coto_id', $request->coto_id);
        }

        $residentes = $query->latest()->paginate(10);
        $cotos      = Coto::where('activo', true)->orderBy('nombre')->get();

        return view('residentes.index', compact('residentes', 'cotos'));
    }

    /**
     * Formulario para crear un nuevo residente.
     */
    public function create()
    {
        $cotos = Coto::where('activo', true)->orderBy('nombre')->get();

        return view('residentes.create', compact('cotos'));
    }

    /**
     * Guarda un nuevo residente.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'coto_id'      => 'required|exists:cotos,id',
            'nombre'       => 'required|string|max:255',
            'casa'         => 'required|string|max:50',
            'contacto'     => 'nullable|string|max:20',
            'email'        => 'required|email|unique:residentes,email',
            'pais'         => 'nullable|string|max:100',
            'pais_codigo'  => 'nullable|string|max:10',
            'capital'      => 'nullable|string|max:100',
            'moneda'       => 'nullable|string|max:100',
            'idioma'       => 'nullable|string|max:100',
            'zona_horaria' => 'nullable|string|max:100',
            'bandera_url'  => 'nullable|url|max:500',
        ]);

        Residente::create($validated);

        return redirect()->route('residentes.index')
            ->with('success', 'Residente registrado correctamente.');
    }

    /**
     * Muestra el detalle de un residente.
     */
    public function show(Residente $residente)
    {
        $residente->load(['coto', 'pagos' => fn ($q) => $q->latest()]);

        return view('residentes.show', compact('residente'));
    }

    /**
     * Formulario para editar un residente.
     */
    public function edit(Residente $residente)
    {
        $cotos = Coto::where('activo', true)->orderBy('nombre')->get();

        return view('residentes.edit', compact('residente', 'cotos'));
    }

    /**
     * Actualiza un residente existente.
     */
    public function update(Request $request, Residente $residente)
    {
        $validated = $request->validate([
            'coto_id'      => 'required|exists:cotos,id',
            'nombre'       => 'required|string|max:255',
            'casa'         => 'required|string|max:50',
            'contacto'     => 'nullable|string|max:20',
            'email'        => 'required|email|unique:residentes,email,' . $residente->id,
            'pais'         => 'nullable|string|max:100',
            'pais_codigo'  => 'nullable|string|max:10',
            'capital'      => 'nullable|string|max:100',
            'moneda'       => 'nullable|string|max:100',
            'idioma'       => 'nullable|string|max:100',
            'zona_horaria' => 'nullable|string|max:100',
            'bandera_url'  => 'nullable|url|max:500',
            'activo'       => 'boolean',
        ]);

        $residente->update($validated);

        return redirect()->route('residentes.index')
            ->with('success', 'Residente actualizado correctamente.');
    }

    /**
     * Elimina un residente (soft delete).
     */
    public function destroy(Residente $residente)
    {
        $residente->delete();

        return redirect()->route('residentes.index')
            ->with('success', 'Residente eliminado correctamente.');
    }
}
