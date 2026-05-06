@extends('layouts.app')
@section('title','Reporte Financiero')
@section('header','Reporte Financiero')
@section('subheader','Resumen mensual del año ' . $anio)
@section('actions')
    <a href="{{ route('reportes.index') }}" class="btn-secondary">Volver</a>
@endsection

@section('content')
<div class="card mb-5">
    <div class="card-body py-4">
        <form method="GET" action="{{ route('reportes.financiero') }}" class="flex gap-3 items-end">
            <div class="form-group">
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

<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="card p-6 text-center">
        <p class="text-xs text-slate-400 uppercase tracking-wide">Total cobrado {{ $anio }}</p>
        <p class="text-3xl font-bold text-emerald-600 mt-2">${{ number_format($meses->sum('pagado'), 2) }}</p>
    </div>
    <div class="card p-6 text-center">
        <p class="text-xs text-slate-400 uppercase tracking-wide">Total adeudos {{ $anio }}</p>
        <p class="text-3xl font-bold text-red-600 mt-2">${{ number_format($meses->sum('adeudos'), 2) }}</p>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Mes</th><th class="text-right">Cobrado</th><th class="text-right">Adeudos</th><th class="text-right">Balance</th></tr></thead>
            <tbody>
                @foreach($meses as $mes)
                <tr>
                    <td class="font-medium text-slate-800 capitalize">{{ $mes['nombre'] }}</td>
                    <td class="text-right font-semibold {{ $mes['pagado'] > 0 ? 'text-emerald-600' : 'text-slate-300' }}">
                        {{ $mes['pagado'] > 0 ? '$' . number_format($mes['pagado'], 2) : '—' }}
                    </td>
                    <td class="text-right font-semibold {{ $mes['adeudos'] > 0 ? 'text-red-600' : 'text-slate-300' }}">
                        {{ $mes['adeudos'] > 0 ? '$' . number_format($mes['adeudos'], 2) : '—' }}
                    </td>
                    <td class="text-right font-bold">
                        @php $b = $mes['pagado'] - $mes['adeudos']; @endphp
                        <span class="{{ $b >= 0 ? 'text-emerald-700' : 'text-red-700' }}">${{ number_format($b, 2) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-50 font-bold">
                <tr>
                    <td class="px-5 py-3 text-slate-700">Total anual</td>
                    <td class="px-5 py-3 text-right text-emerald-700">${{ number_format($meses->sum('pagado'), 2) }}</td>
                    <td class="px-5 py-3 text-right text-red-700">${{ number_format($meses->sum('adeudos'), 2) }}</td>
                    <td class="px-5 py-3 text-right">
                        @php $tb = $meses->sum('pagado') - $meses->sum('adeudos'); @endphp
                        <span class="{{ $tb >= 0 ? 'text-emerald-700' : 'text-red-700' }}">${{ number_format($tb, 2) }}</span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
