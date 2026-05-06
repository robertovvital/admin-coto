@extends('layouts.app')
@section('title','Nuevo Residente')
@section('header','Nuevo Residente')
@section('subheader','Completa los datos del nuevo residente')
@section('actions')
    <a href="{{ route('residentes.index') }}" class="btn-secondary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Volver
    </a>
@endsection

@section('content')
<div class="max-w-3xl">
<form method="POST" action="{{ route('residentes.store') }}" class="space-y-6">
@csrf

{{-- Datos personales --}}
<div class="card">
    <div class="card-header">
        <h2 class="text-sm font-bold text-slate-700">Datos personales</h2>
    </div>
    <div class="card-body space-y-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="form-group">
                <label class="form-label">Nombre completo <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-input @error('nombre') border-red-400 @enderror" placeholder="Nombre del residente">
                @error('nombre')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Número de casa <span class="text-red-500">*</span></label>
                <input type="text" name="casa" value="{{ old('casa') }}" class="form-input @error('casa') border-red-400 @enderror" placeholder="Ej. A-12">
                @error('casa')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="form-group">
                <label class="form-label">Correo electrónico <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-input @error('email') border-red-400 @enderror" placeholder="residente@email.com">
                @error('email')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono de contacto</label>
                <input type="text" name="contacto" value="{{ old('contacto') }}" class="form-input" placeholder="33 1234 5678">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Coto asignado <span class="text-red-500">*</span></label>
            <select name="coto_id" class="form-select @error('coto_id') border-red-400 @enderror">
                <option value="">Selecciona un coto...</option>
                @foreach($cotos as $c)
                    <option value="{{ $c->id }}" {{ old('coto_id', request('coto_id')) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                @endforeach
            </select>
            @error('coto_id')<p class="form-error">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

{{-- País de origen — API REST Countries --}}
<div class="card">
    <div class="card-header">
        <div>
            <h2 class="text-sm font-bold text-slate-700">País de origen</h2>
            <p class="text-xs text-slate-400 mt-0.5">Selecciona el país para autocompletar los datos</p>
        </div>
        <span class="badge-info">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
            REST Countries API
        </span>
    </div>
    <div class="card-body space-y-5">

        {{-- Selector + botón --}}
        <div class="flex gap-3">
            <select id="pais_selector" class="form-select flex-1">
                <option value="">Cargando países...</option>
            </select>
            <button type="button" id="btn_buscar_pais" class="btn-primary whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Autocompletar
            </button>
        </div>

        {{-- Preview del país --}}
        <div id="pais_preview" class="hidden">
            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-brand-50 to-violet-50 rounded-xl border border-brand-100">
                <img id="bandera_preview" src="" alt="Bandera" class="w-16 h-10 object-cover rounded-lg shadow-sm border border-white">
                <div>
                    <p id="pais_nombre_preview" class="font-bold text-slate-800"></p>
                    <p id="pais_detalle_preview" class="text-xs text-slate-500 mt-0.5"></p>
                </div>
                <svg class="w-5 h-5 text-emerald-500 ml-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
        </div>

        {{-- Campos autocomplete --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="form-group">
                <label class="form-label">País</label>
                <input type="text" id="pais" name="pais" value="{{ old('pais') }}" class="form-input bg-slate-50 text-slate-500" readonly placeholder="Se autocompleta">
                <input type="hidden" id="pais_codigo" name="pais_codigo" value="{{ old('pais_codigo') }}">
                <input type="hidden" id="bandera_url" name="bandera_url" value="{{ old('bandera_url') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Capital</label>
                <input type="text" id="capital" name="capital" value="{{ old('capital') }}" class="form-input bg-slate-50 text-slate-500" readonly placeholder="Se autocompleta">
            </div>
            <div class="form-group">
                <label class="form-label">Moneda</label>
                <input type="text" id="moneda" name="moneda" value="{{ old('moneda') }}" class="form-input bg-slate-50 text-slate-500" readonly placeholder="Se autocompleta">
            </div>
            <div class="form-group">
                <label class="form-label">Idioma(s)</label>
                <input type="text" id="idioma" name="idioma" value="{{ old('idioma') }}" class="form-input bg-slate-50 text-slate-500" readonly placeholder="Se autocompleta">
            </div>
            <div class="form-group sm:col-span-2">
                <label class="form-label">Zona horaria</label>
                <input type="text" id="zona_horaria" name="zona_horaria" value="{{ old('zona_horaria') }}" class="form-input bg-slate-50 text-slate-500" readonly placeholder="Se autocompleta">
            </div>
        </div>
    </div>
</div>

<div class="flex justify-end gap-3">
    <a href="{{ route('residentes.index') }}" class="btn-secondary">Cancelar</a>
    <button type="submit" class="btn-primary">Guardar residente</button>
</div>
</form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selector = document.getElementById('pais_selector');
    const btn = document.getElementById('btn_buscar_pais');

    fetch('/api/countries')
        .then(r => r.json())
        .then(paises => {
            selector.innerHTML = '<option value="">Selecciona un país...</option>';
            paises.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.codigo;
                opt.textContent = p.nombre;
                selector.appendChild(opt);
            });
        })
        .catch(() => { selector.innerHTML = '<option value="">Error al cargar países</option>'; });

    btn.addEventListener('click', function () {
        const codigo = selector.value;
        if (!codigo) return;
        btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Cargando...';
        btn.disabled = true;

        fetch(`/api/countries/${codigo}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('pais').value         = data.nombre;
                document.getElementById('pais_codigo').value  = data.codigo;
                document.getElementById('capital').value      = data.capital;
                document.getElementById('moneda').value       = data.moneda;
                document.getElementById('idioma').value       = data.idioma;
                document.getElementById('zona_horaria').value = data.zona_horaria;
                document.getElementById('bandera_url').value  = data.bandera_url;
                document.getElementById('bandera_preview').src = data.bandera_url;
                document.getElementById('pais_nombre_preview').textContent = data.nombre_oficial;
                document.getElementById('pais_detalle_preview').textContent =
                    `Capital: ${data.capital} · ${data.moneda} · ${data.zona_horaria}`;
                document.getElementById('pais_preview').classList.remove('hidden');
            })
            .catch(() => alert('No se pudo obtener la información del país.'))
            .finally(() => {
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg> Autocompletar';
                btn.disabled = false;
            });
    });
});
</script>
@endpush
