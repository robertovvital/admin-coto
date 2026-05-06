@extends('layouts.app')

@section('title', 'Residentes')
@section('header', 'Gestión de Residentes')
@section('subheader', 'Administra los residentes registrados en el sistema')

@section('actions')
    <a href="{{ route('residentes.create') }}" class="btn-primary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Residente
    </a>
@endsection

@section('content')

{{-- Filtros --}}
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('residentes.index') }}" class="flex flex-wrap gap-3">
            <input type="text" name="buscar" value="{{ request('buscar') }}"
                placeholder="Buscar por nombre, email o casa..."
                class="form-input flex-1 min-w-48">
            <select name="coto_id" class="form-select w-48">
                <option value="">Todos los cotos</option>
                @foreach($cotos as $coto)
                    <option value="{{ $coto->id }}" {{ request('coto_id') == $coto->id ? 'selected' : '' }}>
                        {{ $coto->nombre }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary">Filtrar</button>
            @if(request()->hasAny(['buscar','coto_id']))
                <a href="{{ route('residentes.index') }}" class="btn-secondary">Limpiar</a>
            @endif
        </form>
    </div>
</div>

{{-- Tabla --}}
<div class="card">
    <div class="table-container">
        @if($residentes->isEmpty())
            <div class="p-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <p class="text-gray-500 text-sm">No se encontraron residentes.</p>
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Residente</th>
                        <th>Casa</th>
                        <th>Coto</th>
                        <th>País</th>
                        <th>Estado</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($residentes as $residente)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                @if($residente->bandera_url)
                                    <img src="{{ $residente->bandera_url }}" alt="{{ $residente->pais }}"
                                         class="w-6 h-4 object-cover rounded shadow-sm flex-shrink-0">
                                @endif
                                <div>
                                    <div class="font-medium text-gray-900">{{ $residente->nombre }}</div>
                                    <div class="text-xs text-gray-500">{{ $residente->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $residente->casa }}</td>
                        <td>
                            <a href="{{ route('cotos.show', $residente->coto) }}"
                               class="text-primary-600 hover:text-primary-800 text-sm">
                                {{ $residente->coto->nombre }}
                            </a>
                        </td>
                        <td class="text-gray-500 text-sm">{{ $residente->pais ?? '—' }}</td>
                        <td>
                            @if($residente->activo)
                                <span class="badge-success">Activo</span>
                            @else
                                <span class="badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('residentes.show', $residente) }}"
                                   class="text-gray-400 hover:text-primary-600 transition-colors" title="Ver">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('residentes.edit', $residente) }}"
                                   class="text-gray-400 hover:text-yellow-600 transition-colors" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('residentes.destroy', $residente) }}"
                                      onsubmit="return confirm('¿Eliminar este residente?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Eliminar">
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
                {{ $residentes->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
