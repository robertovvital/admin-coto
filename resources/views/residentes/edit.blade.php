@extends('layouts.app')
@section('title','Editar Residente')
@section('header','Editar Residente')
@section('subheader', $residente->nombre)
@section('actions')
    <a href="{{ route('residentes.show', $residente) }}" class="btn-secondary">Volver</a>
@endsection

@section('content')
<div class="max-w-3xl">
<form method="POST" action="{{ route('residentes.update', $residente) }}" class="space-y-6">
@csrf @method('PUT')

<div class="card">
    <div class="card-header"><h2 class="text-sm font-bold text-slate-700">Datos personales</h2></div>
    <div class="card-body space-y-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="form-group">
                <label class="form-label">Nombre completo <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" value="{{ old('nombre', $residente->nombre) }}" class="form-input @error('nombre') border-red-400 @enderror">
                @error('nombre')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Número de casa <span class="text-red-500">*</span></label>
                <input type="text" name="casa" value="{{ old('casa', $residente->casa) }}" class="form-input @error('casa') border-red-400 @enderror">
                @error('casa')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="form-group">
                <label class="form-label">Correo electrónico <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $residente->email) }}" class="form-input @error('email') border-red-400 @enderror">
                @error('email')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono de contacto</label>
                <input type="text" name="contacto" value="{{ old('contacto', $residente->contacto) }}" class="form-input">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Coto asignado <span class="text-red-500">*</span></label>
            <select name="coto_id" class="form-select @error('coto_id') border-red-400 @enderror">
                @foreach($cotos as $c)
                    <option value="{{ $c->id }}" {{ old('coto_id', $residente->coto_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" id="activo" name="activo" value="1" {{ old('activo', $residente->activo) ? 'checked' : '' }}
                class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
            <label for="activo" class="text-sm text-slate-700">Residente activo</label>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <h2 class="text-sm font-bold text-slate-700">País de origen</h2>
            <p class="text-xs text-slate-400 mt-0.5">Actualiza los datos del país si es necesario</p>
        </div>
        <span class="badge-info">REST Countries API</span>
    </div>
    <div class="card-body space-y-5">
        @if($residente->bandera_url)
        <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-brand-50 to-violet-50 rounded-xl border border-brand-100">
            <img src="{{ $residente->bandera_url }}" alt="{{ $residente->pais }}" class="w-16 h-10 object-cover rounded-lg shadow border border-white">
            <div>
                <p class="font-bold text-slate-800">{{ $residente->pais }}</p>
                <p class="text-xs text-slate-500">Capital: {{ $residente->capital }} · {{ $residente->zona_horaria }}</p>
            </div>
        </div>
        @endif
        <div class="flex gap-3">
            <select id="pais_selector" class="form-select flex-1">
                <option value="">Cargando países...</option>
            </select>
            <button type="button" id="btn_buscar_pais" class="btn-primary whitespace-nowrap">Actualizar país</button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="form-group">
                <label class="form-label">País</label>
                <input type="text" id="pais" name="pais" value="{{ old('pais', $residente->pais) }}" class="form-input bg-slate-50 text-slate-500" readonly>
                <input type="hidden" id="pais_codigo" name="pais_codigo" value="{{ old('pais_codigo', $residente->pais_codigo) }}">
                <input type="hidden" id="bandera_url" name="bandera_url" value="{{ old('bandera_url', $residente->bandera_url) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Capital</label>
                <input type="text" id="capital" name="capital" value="{{ old('capital', $residente->capital) }}" class="form-input bg-slate-50 text-slate-500" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Moneda</label>
                <input type="text" id="moneda" name="moneda" value="{{ old('moneda', $residente->moneda) }}" class="form-input bg-slate-50 text-slate-500" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Idioma(s)</label>
                <input type="text" id="idioma" name="idioma" value="{{ old('idioma', $residente->idioma) }}" class="form-input bg-slate-50 text-slate-500" readonly>
            </div>
            <div class="form-group sm:col-span-2">
                <label class="form-label">Zona horaria</label>
                <input type="text" id="zona_horaria" name="zona_horaria" value="{{ old('zona_horaria', $residente->zona_horaria) }}" class="form-input bg-slate-50 text-slate-500" readonly>
            </div>
        </div>
    </div>
</div>

<div class="flex justify-end gap-3">
    <a href="{{ route('residentes.show', $residente) }}" class="btn-secondary">Cancelar</a>
    <button type="submit" class="btn-primary">Guardar cambios</button>
</div>
</form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selector = document.getElementById('pais_selector');
    const btn = document.getElementById('btn_buscar_pais');
    fetch('/api/countries').then(r => r.json()).then(paises => {
        selector.innerHTML = '<option value="">Selecciona un país...</option>';
        paises.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.codigo; opt.textContent = p.nombre;
            selector.appendChild(opt);
        });
    });
    btn.addEventListener('click', function () {
        const codigo = selector.value;
        if (!codigo) return;
        btn.textContent = 'Cargando...'; btn.disabled = true;
        fetch(`/api/countries/${codigo}`).then(r => r.json()).then(data => {
            document.getElementById('pais').value         = data.nombre;
            document.getElementById('pais_codigo').value  = data.codigo;
            document.getElementById('capital').value      = data.capital;
            document.getElementById('moneda').value       = data.moneda;
            document.getElementById('idioma').value       = data.idioma;
            document.getElementById('zona_horaria').value = data.zona_horaria;
            document.getElementById('bandera_url').value  = data.bandera_url;
        }).catch(() => alert('Error al obtener datos del país.'))
        .finally(() => { btn.textContent = 'Actualizar país'; btn.disabled = false; });
    });
});
</script>
@endpush
