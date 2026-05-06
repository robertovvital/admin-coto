<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Residente;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    /**
     * Lista todos los pagos con filtros.
     */
    public function index(Request $request)
    {
        $query = Pago::with(['residente.coto']);

        if ($request->filled('residente_id')) {
            $query->where('residente_id', $request->residente_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->entreFechas($request->desde, $request->hasta);
        }

        $pagos      = $query->latest('fecha')->paginate(15);
        $residentes = Residente::orderBy('nombre')->get();

        return view('pagos.index', compact('pagos', 'residentes'));
    }

    /**
     * Formulario para registrar un nuevo pago.
     */
    public function create(Request $request)
    {
        $residentes = Residente::with('coto')->orderBy('nombre')->get();
        $residente  = $request->filled('residente_id')
            ? Residente::find($request->residente_id)
            : null;

        return view('pagos.create', compact('residentes', 'residente'));
    }

    /**
     * Guarda un nuevo pago.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'residente_id' => 'required|exists:residentes,id',
            'monto'        => 'required|numeric|min:0.01',
            'fecha'        => 'required|date',
            'periodo_mes'  => 'required|date',
            'estado'       => 'required|in:pagado,pendiente,vencido',
            'metodo_pago'  => 'nullable|string|max:50',
            'notas'        => 'nullable|string|max:500',
        ]);

        $validated['registrado_por'] = auth()->id();

        Pago::create($validated);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    /**
     * Muestra el detalle de un pago.
     */
    public function show(Pago $pago)
    {
        $pago->load(['residente.coto', 'registrador']);

        return view('pagos.show', compact('pago'));
    }

    /**
     * Formulario para editar un pago.
     */
    public function edit(Pago $pago)
    {
        $residentes = Residente::with('coto')->orderBy('nombre')->get();

        return view('pagos.edit', compact('pago', 'residentes'));
    }

    /**
     * Actualiza un pago existente.
     */
    public function update(Request $request, Pago $pago)
    {
        $validated = $request->validate([
            'residente_id' => 'required|exists:residentes,id',
            'monto'        => 'required|numeric|min:0.01',
            'fecha'        => 'required|date',
            'periodo_mes'  => 'required|date',
            'estado'       => 'required|in:pagado,pendiente,vencido',
            'metodo_pago'  => 'nullable|string|max:50',
            'notas'        => 'nullable|string|max:500',
        ]);

        $pago->update($validated);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago actualizado correctamente.');
    }

    /**
     * Elimina un pago (soft delete).
     */
    public function destroy(Pago $pago)
    {
        $pago->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Pago eliminado correctamente.');
    }

    /**
     * Vista de adeudos: residentes con pagos pendientes o vencidos.
     */
    public function adeudos(Request $request)
    {
        $query = Residente::with(['coto', 'pagos' => fn ($q) => $q->adeudos()])
            ->whereHas('pagos', fn ($q) => $q->adeudos());

        if ($request->filled('coto_id')) {
            $query->where('coto_id', $request->coto_id);
        }

        $residentes = $query->paginate(15);

        return view('pagos.adeudos', compact('residentes'));
    }
}
