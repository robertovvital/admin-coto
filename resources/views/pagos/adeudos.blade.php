@extends('layouts.app')

@section('title', 'Adeudos')
@section('header', 'Control de Adeudos')
@section('subheader', 'Residentes con pagos pendientes o vencidos')

@section('content')

<div class="card">
    <div class="table-container">
        @if($residentes->isEmpty())
            <div class="p-12 text-center">
                <svg class="w-12 h-12 text-green-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-500 text-sm font-medium">¡Sin adeudos pendientes!</p>
                <p class="text-gray-400 text-xs mt-1">Todos los residentes están al corriente.</p>
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Residente</th>
                        <th>Casa</th>
                        <th>Coto</th>
                        <th>Adeudos</th>
                        <th>Total adeudado</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($residentes as $residente)
                    <tr>
                        <td>
                            <div class="font-medium text-gray-900">{{ $residente->nombre }}</div>
                            <div class="text-xs text-gray-500">{{ $residente->email }}</div>
                        </td>
                        <td>{{ $residente->casa }}</td>
                        <td>
                            <a href="{{ route('cotos.show', $residente->coto) }}"
                               class="text-primary-600 hover:text-primary-800 text-sm">
                                {{ $residente->coto->nombre }}
                            </a>
                        </td>
                        <td>
                            @foreach($residente->pagos as $pago)
                                @if($pago->estado === 'vencido')
                                    <span class="badge-danger mr-1">{{ $pago->periodo_mes->format('M Y') }}</span>
                                @else
                                    <span class="badge-warning mr-1">{{ $pago->periodo_mes->format('M Y') }}</span>
                                @endif
                            @endforeach
                        </td>
                        <td class="font-bold text-red-600">
                            ${{ number_format($residente->pagos->sum('monto'), 2) }}
                        </td>
                        <td class="text-right">
                            <a href="{{ route('pagos.create') }}?residente_id={{ $residente->id }}"
                               class="btn-primary text-xs py-1.5 px-3">
                                Registrar pago
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $residentes->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
