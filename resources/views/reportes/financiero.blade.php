@extends('layouts.app')

@section('title', 'Reporte Financiero')
@section('header', 'Reporte Financiero')
@section('subheader', 'Resumen mensual del año ' . $anio)

@section('actions')
    <a href="{{ route('reportes.index') }}" class="btn-secondary">Volver</a>
@endsection

@section('content')

{{-- Selector de año --}}
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('reportes.financiero') }}" class="flex gap-3 items-end">
            <div>
                <label class="form-label">Año</label>
                <select name="anio" class="form-select w-32">
                    @foreach($anios as $a)
                        <option value="{{ $a }}" {{ $a == $anio ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                    @if($anios->isEmpty())
                        <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                    @endif
                </select>
            </div>
            <button type="submit" class="btn-primary">Ver año</button>
        </form>
    </div>
</div>

{{-- Totales del año --}}
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="card">
        <div class="card-body text-center">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total cobrado {{ $anio }}</p>
            <p class="text-3xl font-bold text-green-600 mt-1">
                ${{ number_format($meses->sum('pagado'), 2) }}
            </p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total adeudos {{ $anio }}</p>
            <p class="text-3xl font-bold text-red-600 mt-1">
                ${{ number_format($meses->sum('adeudos'), 2) }}
            </p>
        </div>
    </div>
</div>

{{-- Tabla mensual --}}
<div class="card">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th class="text-right">Cobrado</th>
                    <th class="text-right">Adeudos</th>
                    <th class="text-right">Balance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($meses as $mes)
                <tr>
                    <td class="font-medium text-gray-900 capitalize">{{ $mes['nombre'] }}</td>
                    <td class="text-right font-semibold text-green-600">
                        @if($mes['pagado'] > 0)
                            ${{ number_format($mes['pagado'], 2) }}
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="text-right font-semibold text-red-600">
                        @if($mes['adeudos'] > 0)
                            ${{ number_format($mes['adeudos'], 2) }}
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="text-right font-bold">
                        @php $balance = $mes['pagado'] - $mes['adeudos']; @endphp
                        <span class="{{ $balance >= 0 ? 'text-green-700' : 'text-red-700' }}">
                            ${{ number_format($balance, 2) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 font-bold">
                <tr>
                    <td class="px-6 py-3 text-gray-700">Total anual</td>
                    <td class="px-6 py-3 text-right text-green-700">${{ number_format($meses->sum('pagado'), 2) }}</td>
                    <td class="px-6 py-3 text-right text-red-700">${{ number_format($meses->sum('adeudos'), 2) }}</td>
                    <td class="px-6 py-3 text-right">
                        @php $totalBalance = $meses->sum('pagado') - $meses->sum('adeudos'); @endphp
                        <span class="{{ $totalBalance >= 0 ? 'text-green-700' : 'text-red-700' }}">
                            ${{ number_format($totalBalance, 2) }}
                        </span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection
