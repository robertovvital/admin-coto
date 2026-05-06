@extends('layouts.app')
@section('title','Residentes')
@section('header','Residentes')
@section('subheader','Administra los residentes registrados en el sistema')
@section('actions')
    <a href="{{ route('residentes.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nuevo residente
    </a>
@endsection

@section('content')
<div class="card mb-5">
    <div class="card-body py-4">
        <form method="GET" action="{{ route('residentes.index') }}" class="flex flex-wrap gap-3">
            <div class="relative flex-1 min-w-48">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre, email o casa..." class="form-input pl-9">
            </div>
            <select name="coto_id" class="form-select w-48">
                <option value="">Todos los cotos</option>
                @foreach($cotos as $c)
                    <option value="{{ $c->id }}" {{ request('coto_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary">Filtrar</button>
            @if(request()->hasAny(['buscar','coto_id']))
                <a href="{{ route('residentes.index') }}" class="btn-secondary">Limpiar</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        @if($residentes->isEmpty())
            <div class="py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-slate-500 font-medium">No se encontraron residentes</p>
            </div>
        @else
        <table class="table">
            <thead><tr><th>Residente</th><th>Casa</th><th>Coto</th><th>País</th><th>Estado</th><th class="text-right">Acciones</th></tr></thead>
            <tbody>
                @foreach($residentes as $r)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-400 to-brand-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($r->nombre, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $r->nombre }}</p>
                                <p class="text-xs text-slate-400">{{ $r->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="text-slate-600">{{ $r->casa }}</td>
                    <td><a href="{{ route('cotos.show', $r->coto) }}" class="text-brand-600 hover:text-brand-800 text-sm font-medium">{{ $r->coto->nombre }}</a></td>
                    <td>
                        @if($r->bandera_url)
                        <div class="flex items-center gap-2">
                            <img src="{{ $r->bandera_url }}" class="w-5 h-3.5 object-cover rounded shadow-sm">
                            <span class="text-sm text-slate-600">{{ $r->pais }}</span>
                        </div>
                        @else <span class="text-slate-400">—</span> @endif
                    </td>
                    <td>@if($r->activo)<span class="badge-success">Activo</span>@else<span class="badge-danger">Inactivo</span>@endif</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('residentes.show', $r) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-brand-50 transition-colors" title="Ver">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('residentes.edit', $r) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('residentes.destroy', $r) }}" onsubmit="return confirm('¿Eliminar este residente?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-slate-100">{{ $residentes->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
