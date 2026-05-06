@extends('layouts.app')

@section('title', 'Editar Pago')
@section('header', 'Editar Pago')
@section('subheader', 'Modifica los datos del pago')

@section('actions')
    <a href="{{ route('pagos.show', $pago) }}" class="btn-secondary">Volver</a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="card-header">
            <h2 class="text-sm font-semibold text-gray-700">Datos del pago</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('pagos.update', $pago) }}" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label for="residente_id" class="form-label">Residente <span class="text-red-500">*</span></label>
                    <select id="residente_id" name="residente_id"
                        class="form-select @error('residente_id') border-red-500 @enderror">
                        @foreach($residentes as $r)
                            <option value="{{ $r->id }}"
                                {{ old('residente_id', $pago->residente_id) == $r->id ? 'selected' : '' }}>
                                {{ $r->nombre }} — {{ $r->coto->nombre }} (Casa {{ $r->casa }})
                            </option>
                        @endforeach
                    </select>
                    @error('residente_id') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="monto" class="form-label">Monto <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">$</span>
                            <input type="number" id="monto" name="monto" step="0.01" min="0.01"
                                value="{{ old('monto', $pago->monto) }}"
                                class="form-input pl-7 @error('monto') border-red-500 @enderror">
                        </div>
                        @error('monto') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="metodo_pago" class="form-label">Método de pago</label>
                        <select id="metodo_pago" name="metodo_pago" class="form-select">
                            <option value="">Seleccionar...</option>
                            <option value="efectivo"     {{ old('metodo_pago', $pago->metodo_pago) === 'efectivo'     ? 'selected' : '' }}>Efectivo</option>
                            <option value="transferencia"{{ old('metodo_pago', $pago->metodo_pago) === 'transferencia'? 'selected' : '' }}>Transferencia</option>
                            <option value="tarjeta"      {{ old('metodo_pago', $pago->metodo_pago) === 'tarjeta'      ? 'selected' : '' }}>Tarjeta</option>
                            <option value="cheque"       {{ old('metodo_pago', $pago->metodo_pago) === 'cheque'       ? 'selected' : '' }}>Cheque</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="fecha" class="form-label">Fecha de pago <span class="text-red-500">*</span></label>
                        <input type="date" id="fecha" name="fecha"
                            value="{{ old('fecha', $pago->fecha->format('Y-m-d')) }}"
                            class="form-input @error('fecha') border-red-500 @enderror">
                        @error('fecha') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="periodo_mes" class="form-label">Periodo (mes) <span class="text-red-500">*</span></label>
                        <input type="date" id="periodo_mes" name="periodo_mes"
                            value="{{ old('periodo_mes', $pago->periodo_mes->format('Y-m-d')) }}"
                            class="form-input @error('periodo_mes') border-red-500 @enderror">
                        @error('periodo_mes') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="estado" class="form-label">Estado <span class="text-red-500">*</span></label>
                    <select id="estado" name="estado" class="form-select @error('estado') border-red-500 @enderror">
                        <option value="pagado"    {{ old('estado', $pago->estado) === 'pagado'    ? 'selected' : '' }}>Pagado</option>
                        <option value="pendiente" {{ old('estado', $pago->estado) === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="vencido"   {{ old('estado', $pago->estado) === 'vencido'   ? 'selected' : '' }}>Vencido</option>
                    </select>
                    @error('estado') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="notas" class="form-label">Notas</label>
                    <textarea id="notas" name="notas" rows="2" class="form-input">{{ old('notas', $pago->notas) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                    <a href="{{ route('pagos.show', $pago) }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
