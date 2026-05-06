@extends('layouts.app')
@section('title','Adeudos')
@section('header','Control de Adeudos')
@section('subheader','Residentes con pagos pendientes o vencidos')

@section('content')
<div class="card">
    <div class="table-wrap">
        @if($residentes->isEmpty())
            <div class="py-16 text-center">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-slate-700 font-semibold">¡Sin adeudos pendientes!</p>
                <p class="text-slate-400 text-sm mt-1">Todos los residentes están al corriente.</p>
            </div>
        @else
        <table class="table">
            <thead><tr><th>Residente</th><th>Casa</th><th>Coto</th><th>Periodos</th><th>Total adeudado</th><th class="text-right">Acción</th></tr></thead>
            <tbody>
                @foreach($residentes as $r)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-400 to-orange-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
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
                        <div class="flex flex-wrap gap-1">
                            @foreach($r->pagos as $pago)
                                @if($pago->estado === 'vencido')
                                    <span class="badge-danger">{{ $pago->periodo_mes->format('M Y') }}</span>
                                @else
                                    <span class="badge-warning">{{ $pago->periodo_mes->format('M Y') }}</span>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td><span class="font-bold text-red-600 text-base">${{ number_format($r->pagos->sum('monto'), 2) }}</span></td>
                    <td class="text-right">
                        <a href="{{ route('pagos.create') }}?residente_id={{ $r->id }}" class="btn-primary btn-sm">Registrar pago</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-slate-100">{{ $residentes->links() }}</div>
        @endif
    </div>
</div>
@endsection
