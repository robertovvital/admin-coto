@extends('layouts.app')
@section('title','Editar Pago')
@section('header','Editar Pago')
@section('subheader','Pago #' . $pago->id)
@section('actions')
    <a href="{{ route('pagos.show', $pago) }}" class="btn-secondary">Volver</a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="card-header"><h2 class="text-sm font-bold text-slate-700">Datos del pago</h2></div>
        <div class="card-body">
            <form method="POST" action="{{ route('pagos.update', $pago) }}" class="space-y-5">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Residente <span class="text-red-500">*</span></label>
                    <select name="residente_id" class="form-select @error('residente_id') border-red-400 @enderror">
                        @foreach($residentes as $r)
                            <option value="{{ $r->id }}" {{ old('residente_id', $pago->residente_id) == $r->id ? 'selected' : '' }}>
                                {{ $r->nombre }} — {{ $r->coto->nombre }} (Casa {{ $r->casa }})
                            </option>
                        @endforeach
                    </select>
                    @error('residente_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">Monto <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">$</span>
                            <input type="number" name="monto" step="0.01" min="0.01" value="{{ old('monto', $pago->monto) }}" class="form-input pl-7 @error('monto') border-red-400 @enderror">
                        </div>
                        @error('monto')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Método de pago</label>
                        <select name="metodo_pago" class="form-select">
                            <option value="">Seleccionar...</option>
                            <option value="efectivo"      {{ old('metodo_pago', $pago->metodo_pago) === 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                            <option value="transferencia" {{ old('metodo_pago', $pago->metodo_pago) === 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="tarjeta"       {{ old('metodo_pago', $pago->metodo_pago) === 'tarjeta'       ? 'selected' : '' }}>Tarjeta</option>
                            <option value="cheque"        {{ old('metodo_pago', $pago->metodo_pago) === 'cheque'        ? 'selected' : '' }}>Cheque</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">Fecha de pago <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha" value="{{ old('fecha', $pago->fecha->format('Y-m-d')) }}" class="form-input @error('fecha') border-red-400 @enderror">
                        @error('fecha')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Periodo (mes) <span class="text-red-500">*</span></label>
                        <input type="date" name="periodo_mes" value="{{ old('periodo_mes', $pago->periodo_mes->format('Y-m-d')) }}" class="form-input @error('periodo_mes') border-red-400 @enderror">
                        @error('periodo_mes')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Estado <span class="text-red-500">*</span></label>
                    <select name="estado" class="form-select @error('estado') border-red-400 @enderror">
                        <option value="pagado"    {{ old('estado', $pago->estado) === 'pagado'    ? 'selected' : '' }}>✅ Pagado</option>
                        <option value="pendiente" {{ old('estado', $pago->estado) === 'pendiente' ? 'selected' : '' }}>⏳ Pendiente</option>
                        <option value="vencido"   {{ old('estado', $pago->estado) === 'vencido'   ? 'selected' : '' }}>❌ Vencido</option>
                    </select>
                    @error('estado')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Notas</label>
                    <textarea name="notas" rows="2" class="form-textarea">{{ old('notas', $pago->notas) }}</textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ route('pagos.show', $pago) }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
