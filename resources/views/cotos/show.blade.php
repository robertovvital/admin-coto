@extends('layouts.app')

@section('title', $coto->nombre)
@section('header', $coto->nombre)
@section('subheader', 'Detalle del coto residencial')

@section('actions')
    <a href="{{ route('cotos.edit', $coto) }}" class="btn-secondary">Editar</a>
    <a href="{{ route('residentes.create') }}?coto_id={{ $coto->id }}" class="btn-primary">+ Agregar residente</a>
@endsection

@section('content')

{{-- Info del coto --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 card">
        <div class="card-header"><h2 class="text-sm font-semibold text-gray-700">Información general</h2></div>
        <div class="card-body grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Responsable</p>
                <p class="font-medium text-gray-900">{{ $coto->responsable }}</p>
            </div>
            <div>
                <p class="text-gray-500">Estado</p>
                @if($coto->activo)
                    <span class="badge-success">Activo</span>
                @else
                    <span class="badge-danger">Inactivo</span>
                @endif
            </div>
            <div class="col-span-2">
                <p class="text-gray-500">Dirección</p>
                <p class="font-medium text-gray-900">{{ $coto->direccion }}</p>
            </div>
            @if($coto->telefono)
            <div>
                <p class="text-gray-500">Teléfono</p>
                <p class="font-medium text-gray-900">{{ $coto->telefono }}</p>
            </div>
            @endif
            @if($coto->email)
            <div>
                <p class="text-gray-500">Correo</p>
                <p class="font-medium text-gray-900">{{ $coto->email }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h2 class="text-sm font-semibold text-gray-700">Resumen</h2></div>
        <div class="card-body space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">Total residentes</span>
                <span class="font-bold text-gray-900">{{ $coto->residentes->count() }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">Registrado</span>
                <span class="text-sm text-gray-700">{{ $coto->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Residentes del coto --}}
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-700">Residentes</h2>
        <a href="{{ route('residentes.index') }}?coto_id={{ $coto->id }}" class="text-sm text-primary-600 hover:text-primary-800">Ver todos</a>
    </div>
    <div class="table-container">
        @if($coto->residentes->isEmpty())
            <div class="p-8 text-center text-gray-400 text-sm">No hay residentes registrados en este coto.</div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Casa</th>
                        <th>Contacto</th>
                        <th>Pagos</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($coto->residentes as $residente)
                    <tr>
                        <td>
                            <div class="font-medium text-gray-900">{{ $residente->nombre }}</div>
                            <div class="text-xs text-gray-500">{{ $residente->email }}</div>
                        </td>
                        <td>{{ $residente->casa }}</td>
                        <td class="text-gray-500">{{ $residente->contacto ?? '—' }}</td>
                        <td><span class="badge-info">{{ $residente->pagos_count }}</span></td>
                        <td class="text-right">
                            <a href="{{ route('residentes.show', $residente) }}"
                               class="text-primary-600 hover:text-primary-800 text-sm font-medium">Ver</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection
