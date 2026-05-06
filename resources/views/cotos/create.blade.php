@extends('layouts.app')
@section('title','Nuevo Coto')
@section('header','Nuevo Coto')
@section('subheader','Registra un nuevo coto residencial')
@section('actions')
    <a href="{{ route('cotos.index') }}" class="btn-secondary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Volver
    </a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="card-header">
            <h2 class="text-sm font-bold text-slate-700">Información del coto</h2>
        </div>
        <div class="card-body space-y-5">
            <form method="POST" action="{{ route('cotos.store') }}" class="space-y-5">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nombre del coto <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-input @error('nombre') border-red-400 @enderror" placeholder="Ej. Coto Las Palmas">
                    @error('nombre')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Dirección <span class="text-red-500">*</span></label>
                    <textarea name="direccion" rows="2" class="form-textarea @error('direccion') border-red-400 @enderror" placeholder="Calle, colonia, ciudad...">{{ old('direccion') }}</textarea>
                    @error('direccion')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Responsable <span class="text-red-500">*</span></label>
                    <input type="text" name="responsable" value="{{ old('responsable') }}" class="form-input @error('responsable') border-red-400 @enderror" placeholder="Nombre del administrador">
                    @error('responsable')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-input" placeholder="33 1234 5678">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="admin@coto.com">
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ route('cotos.index') }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Guardar coto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
