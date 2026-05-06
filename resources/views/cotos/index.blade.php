@extends('layouts.app')
@section('title','Cotos')
@section('header','Cotos')
@section('subheader','Administra los cotos residenciales del sistema')
@section('actions')
    <a href="{{ route('cotos.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nuevo coto
    </a>
@endsection

@section('content')
{{-- Buscador --}}
<div class="card mb-5">
    <div class="card-body py-4">
        <form method="GET" action="{{ route('cotos.index') }}" class="flex gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                    placeholder="Buscar por nombre o responsable..."
                    class="form-input pl-9">
            </div>
            <button type="submit" class="btn-primary">Buscar</button>
            @if(request('buscar'))
                <a href="{{ route('cotos.index') }}" class="btn-secondary">Limpiar</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        @if($cotos->isEmpty())
            <div class="py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                </div>
                <p class="text-slate-500 font-medium">No hay cotos registrados</p>
                <a href="{{ route('cotos.create') }}" class="btn-primary mt-4 inline-flex">Registrar primer coto</a>
            </div>
        @else
        <table class="table">
            <thead><tr>
                <th>Coto</th>
                <th>Responsable</th>
                <th>Residentes</th>
                <th>Estado</th>
                <th class="text-right">Acciones</th>
            </tr></thead>
            <tbody>
                @foreach($cotos as $coto)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-brand-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                                </svg>
                            </div>
                            <div>
                                <a href="{{ route('cotos.show', $coto) }}" class="font-semibold text-slate-800 hover:text-brand-600 transition-colors">{{ $coto->nombre }}</a>
                                <p class="text-xs text-slate-400 truncate max-w-xs">{{ $coto->direccion }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="text-slate-600">{{ $coto->responsable }}</td>
                    <td><span class="badge-info">{{ $coto->residentes_count }}</span></td>
                    <td>
                        @if($coto->activo) <span class="badge-success">Activo</span>
                        @else <span class="badge-danger">Inactivo</span> @endif
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('cotos.show', $coto) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-brand-50 transition-colors" title="Ver">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('cotos.edit', $coto) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('cotos.destroy', $coto) }}" onsubmit="return confirm('¿Eliminar este coto?')">
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
        <div class="px-5 py-4 border-t border-slate-100">{{ $cotos->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
