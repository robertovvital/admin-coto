@extends('layouts.app')
@section('title','Editar Coto')
@section('header','Editar Coto')
@section('subheader', $coto->nombre)
@section('actions')
    <a href="{{ route('cotos.show', $coto) }}" class="btn-secondary">Volver</a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="card-header">
            <h2 class="text-sm font-bold text-slate-700">Información del coto</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('cotos.update', $coto) }}" class="space-y-5">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nombre del coto <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $coto->nombre) }}" class="form-input @error('nombre') border-red-400 @enderror">
                    @error('nombre')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Dirección <span class="text-red-500">*</span></label>
                    <textarea name="direccion" rows="2" class="form-textarea @error('direccion') border-red-400 @enderror">{{ old('direccion', $coto->direccion) }}</textarea>
                    @error('direccion')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Responsable <span class="text-red-500">*</span></label>
                    <input type="text" name="responsable" value="{{ old('responsable', $coto->responsable) }}" class="form-input @error('responsable') border-red-400 @enderror">
                    @error('responsable')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $coto->telefono) }}" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email', $coto->email) }}" class="form-input">
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="activo" name="activo" value="1" {{ old('activo', $coto->activo) ? 'checked' : '' }}
                        class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    <label for="activo" class="text-sm text-slate-700">Coto activo</label>
                </div>
                <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ route('cotos.index') }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
