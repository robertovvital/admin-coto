@extends('layouts.app')

@section('title', 'Cotos')
@section('header', 'Gestión de Cotos')
@section('subheader', 'Administra los cotos residenciales registrados')

@section('actions')
    <a href="{{ route('cotos.create') }}" class="btn-primary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Coto
    </a>
@endsection

@section('content')

{{-- Buscador --}}
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('cotos.index') }}" class="flex gap-3">
            <input type="text" name="buscar" value="{{ request('buscar') }}"
                placeholder="Buscar por nombre o responsable..."
                class="form-input flex-1">
            <button type="submit" class="btn-primary">Buscar</button>
            @if(request('buscar'))
                <a href="{{ route('cotos.index') }}" class="btn-secondary">Limpiar</a>
            @endif
        </form>
    </div>
</div>

{{-- Tabla --}}
<div class="card">
    <div class="table-container">
        @if($cotos->isEmpty())
            <div class="p-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                </svg>
                <p class="text-gray-500 text-sm">No hay cotos registrados.</p>
                <a href="{{ route('cotos.create') }}" class="btn-primary mt-4 inline-flex">Registrar primer coto</a>
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Responsable</th>
                        <th>Residentes</th>
                        <th>Estado</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cotos as $coto)
                    <tr>
                        <td>
                            <a href="{{ route('cotos.show', $coto) }}"
                               class="font-semibold text-primary-600 hover:text-primary-800">
                                {{ $coto->nombre }}
                            </a>
                        </td>
                        <td class="text-gray-500 max-w-xs truncate">{{ $coto->direccion }}</td>
                        <td>{{ $coto->responsable }}</td>
                        <td>
                            <span class="badge-info">{{ $coto->residentes_count }} residentes</span>
                        </td>
                        <td>
                            @if($coto->activo)
                                <span class="badge-success">Activo</span>
                            @else
                                <span class="badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('cotos.show', $coto) }}"
                                   class="text-gray-400 hover:text-primary-600 transition-colors" title="Ver">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('cotos.edit', $coto) }}"
                                   class="text-gray-400 hover:text-yellow-600 transition-colors" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('cotos.destroy', $coto) }}"
                                      onsubmit="return confirm('¿Eliminar este coto?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-gray-400 hover:text-red-600 transition-colors" title="Eliminar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $cotos->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
