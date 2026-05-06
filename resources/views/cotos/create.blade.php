@extends('layouts.app')

@section('title', 'Nuevo Coto')
@section('header', 'Registrar Coto')
@section('subheader', 'Completa los datos del nuevo coto residencial')

@section('actions')
    <a href="{{ route('cotos.index') }}" class="btn-secondary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver
    </a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="card-header">
            <h2 class="text-sm font-semibold text-gray-700">Información del coto</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('cotos.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="nombre" class="form-label">Nombre del coto <span class="text-red-500">*</span></label>
                    <input type="text" id="nombre" name="nombre"
                        value="{{ old('nombre') }}"
                        class="form-input @error('nombre') border-red-500 @enderror"
                        placeholder="Ej. Coto Las Palmas">
                    @error('nombre') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="direccion" class="form-label">Dirección <span class="text-red-500">*</span></label>
                    <textarea id="direccion" name="direccion" rows="2"
                        class="form-input @error('direccion') border-red-500 @enderror"
                        placeholder="Calle, colonia, ciudad...">{{ old('direccion') }}</textarea>
                    @error('direccion') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="responsable" class="form-label">Responsable <span class="text-red-500">*</span></label>
                    <input type="text" id="responsable" name="responsable"
                        value="{{ old('responsable') }}"
                        class="form-input @error('responsable') border-red-500 @enderror"
                        placeholder="Nombre del administrador">
                    @error('responsable') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" id="telefono" name="telefono"
                            value="{{ old('telefono') }}"
                            class="form-input @error('telefono') border-red-500 @enderror"
                            placeholder="Ej. 33 1234 5678">
                        @error('telefono') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email') }}"
                            class="form-input @error('email') border-red-500 @enderror"
                            placeholder="admin@coto.com">
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                    <a href="{{ route('cotos.index') }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Guardar coto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
