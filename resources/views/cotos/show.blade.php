@extends('layouts.app')
@section('title', $coto->nombre)
@section('header', $coto->nombre)
@section('subheader','Detalle del coto residencial')
@section('actions')
    <a href="{{ route('cotos.edit', $coto) }}" class="btn-secondary">Editar</a>
    <a href="{{ route('residentes.create') }}?coto_id={{ $coto->id }}" class="btn-primary">+ Agregar residente</a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 card">
        <div class="card-header"><h2 class="text-sm font-bold text-slate-700">Información general</h2></div>
        <div class="card-body grid grid-cols-2 gap-5 text-sm">
            <div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Responsable</p><p class="font-semibold text-slate-800">{{ $coto->responsable }}</p></div>
            <div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Estado</p>
                @if($coto->activo)<span class="badge-success">Activo</span>@else<span class="badge-danger">Inactivo</span>@endif
            </div>
            <div class="col-span-2"><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Dirección</p><p class="font-medium text-slate-700">{{ $coto->direccion }}</p></div>
            @if($coto->telefono)<div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Teléfono</p><p class="font-medium text-slate-700">{{ $coto->telefono }}</p></div>@endif
            @if($coto->email)<div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Correo</p><p class="font-medium text-slate-700">{{ $coto->email }}</p></div>@endif
        </div>
    </div>
    <div class="card">
        <div class="card-header"><h2 class="text-sm font-bold text-slate-700">Resumen</h2></div>
        <div class="card-body space-y-4">
            <div class="flex justify-between items-center py-2 border-b border-slate-50">
                <span class="text-sm text-slate-500">Total residentes</span>
                <span class="font-bold text-slate-900 text-lg">{{ $coto->residentes->count() }}</span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-sm text-slate-500">Registrado</span>
                <span class="text-sm text-slate-600">{{ $coto->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="text-sm font-bold text-slate-700">Residentes del coto</h2>
        <a href="{{ route('residentes.index') }}?coto_id={{ $coto->id }}" class="text-xs text-brand-600 hover:text-brand-800 font-semibold">Ver todos →</a>
    </div>
    <div class="table-wrap">
        @if($coto->residentes->isEmpty())
            <div class="py-10 text-center text-slate-400 text-sm">No hay residentes en este coto.</div>
        @else
        <table class="table">
            <thead><tr><th>Nombre</th><th>Casa</th><th>Contacto</th><th>Pagos</th><th class="text-right">Acciones</th></tr></thead>
            <tbody>
                @foreach($coto->residentes as $r)
                <tr>
                    <td><p class="font-medium text-slate-800">{{ $r->nombre }}</p><p class="text-xs text-slate-400">{{ $r->email }}</p></td>
                    <td class="text-slate-600">{{ $r->casa }}</td>
                    <td class="text-slate-500">{{ $r->contacto ?? '—' }}</td>
                    <td><span class="badge-info">{{ $r->pagos_count }}</span></td>
                    <td class="text-right"><a href="{{ route('residentes.show', $r) }}" class="text-brand-600 hover:text-brand-800 text-xs font-semibold">Ver →</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
