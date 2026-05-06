@extends('layouts.app')
@section('title','Pagos')
@section('header','Pagos')
@section('subheader','Historial y registro de pagos de mantenimiento')
@section('actions')
    <a href="{{ route('pagos.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Registrar pago
    </a>
@endsection

@section('content')
<div class="card mb-5">
    <div class="card-body py-4">
        <form method="GET" action="{{ route('pagos.index') }}" class="flex flex-wrap gap-3">
            <select name="residente_id" class="form-select w-52">
                <option value="">Todos los residentes</option>
                @foreach($residentes as $r)
                    <option value="{{ $r->id }}" {{ request('residente_id') == $r->id ? 'selected' : '' }}>{{ $r->nombre }}</option>
                @endforeach
            </select>
            <select name="estado" class="form-select w-36">
                <option value="">Todos</option>
                <option value="pagado"    {{ request('estado') === 'pagado'    ? 'selected' : '' }}>Pagado</option>
                <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="vencido"   {{ request('estado') === 'vencido'   ? 'selected' : '' }}>Vencido</option>
            </select>
            <input type="date" name="desde" value="{{ request('desde') }}" class="form-input w-40">
            <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-input w-40">
            <button type="submit" class="btn-primary">Filtrar</button>
            @if(request()->hasAny(['residente_id','estado','desde','hasta']))
                <a href="{{ route('pagos.index') }}" class="btn-secondary">Limpiar</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        @if($pagos->isEmpty())
            <div class="py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <p class="text-slate-500 font-medium">No se encontraron pagos</p>
            </div>
        @else
        <table class="table">
            <thead><tr><th>Residente</th><th>Monto</th><th>Fecha</th><th>Periodo</th><th>Método</th><th>Estado</th><th class="text-right">Acciones</th></tr></thead>
            <tbody>
                @foreach($pagos as $pago)
                <tr>
                    <td>
                        <a href="{{ route('residentes.show', $pago->residente) }}" class="font-semibold text-slate-800 hover:text-brand-600 transition-colors">{{ $pago->residente->nombre }}</a>
                        <p class="text-xs text-slate-400">{{ $pago->residente->coto->nombre }}</p>
                    </td>
                    <td class="font-bold text-slate-800">${{ number_format($pago->monto, 2) }}</td>
                    <td class="text-slate-500">{{ $pago->fecha->format('d/m/Y') }}</td>
                    <td class="text-slate-500">{{ $pago->periodo_mes->format('M Y') }}</td>
                    <td>
                        @if($pago->metodo_pago)
                            <span class="badge-gray capitalize">{{ $pago->metodo_pago }}</span>
                        @else <span class="text-slate-400">—</span> @endif
                    </td>
                    <td>
                        @if($pago->estado === 'pagado')<span class="badge-success">Pagado</span>
                        @elseif($pago->estado === 'pendiente')<span class="badge-warning">Pendiente</span>
                        @else<span class="badge-danger">Vencido</span>@endif
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('pagos.show', $pago) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-brand-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('pagos.edit', $pago) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('pagos.destroy', $pago) }}" onsubmit="return confirm('¿Eliminar este pago?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-slate-100">{{ $pagos->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
