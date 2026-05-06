@extends('layouts.app')

@section('title', 'Nuevo Residente')
@section('header', 'Registrar Residente')
@section('subheader', 'Completa los datos del nuevo residente')

@section('actions')
    <a href="{{ route('residentes.index') }}" class="btn-secondary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
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
                <h2 class="text-sm font-semibold text-gray-700">Datos personales</h2>
            </div>
            <div class="card-body space-y-5">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="nombre" class="form-label">Nombre completo <span class="text-red-500">*</span></label>
                        <input type="text" id="nombre" name="nombre"
                            value="{{ old('nombre') }}"
                            class="form-input @error('nombre') border-red-500 @enderror"
                            placeholder="Nombre del residente">
                        @error('nombre') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="casa" class="form-label">Número de casa <span class="text-red-500">*</span></label>
                        <input type="text" id="casa" name="casa"
                            value="{{ old('casa') }}"
                            class="form-input @error('casa') border-red-500 @enderror"
                            placeholder="Ej. A-12, Casa 5">
                        @error('casa') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="email" class="form-label">Correo electrónico <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email') }}"
                            class="form-input @error('email') border-red-500 @enderror"
                            placeholder="residente@email.com">
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="contacto" class="form-label">Teléfono de contacto</label>
                        <input type="text" id="contacto" name="contacto"
                            value="{{ old('contacto') }}"
                            class="form-input @error('contacto') border-red-500 @enderror"
                            placeholder="Ej. 33 1234 5678">
                        @error('contacto') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="coto_id" class="form-label">Coto asignado <span class="text-red-500">*</span></label>
                    <select id="coto_id" name="coto_id"
                        class="form-select @error('coto_id') border-red-500 @enderror">
                        <option value="">Selecciona un coto...</option>
                        @foreach($cotos as $coto)
                            <option value="{{ $coto->id }}"
                                {{ old('coto_id', request('coto_id')) == $coto->id ? 'selected' : '' }}>
                                {{ $coto->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('coto_id') <p class="form-error">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        {{-- Datos internacionales (API REST Countries) --}}
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-gray-700">País de origen</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Los datos se autocompletan al seleccionar el país</p>
                </div>
                <span class="badge-info">API REST Countries</span>
            </div>
            <div class="card-body space-y-5">

                {{-- Selector de país --}}
                <div>
                    <label for="pais_selector" class="form-label">Seleccionar país</label>
                    <div class="flex gap-3">
                        <select id="pais_selector" class="form-select flex-1">
                            <option value="">Cargando países...</option>
                        </select>
                        <button type="button" id="btn_buscar_pais"
                            class="btn-secondary whitespace-nowrap">
                            Autocompletar
                        </button>
                    </div>
                </div>

                {{-- Preview de bandera --}}
                <div id="pais_preview" class="hidden">
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <img id="bandera_preview" src="" alt="Bandera" class="w-16 h-10 object-cover rounded shadow">
                        <div>
                            <p id="pais_nombre_preview" class="font-semibold text-gray-900"></p>
                            <p id="pais_detalle_preview" class="text-sm text-gray-500"></p>
                        </div>
                    </div>
                </div>

                {{-- Campos ocultos que se llenan con la API --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">País</label>
                        <input type="text" id="pais" name="pais" value="{{ old('pais') }}"
                            class="form-input bg-gray-50" readonly placeholder="Se autocompleta">
                        <input type="hidden" id="pais_codigo" name="pais_codigo" value="{{ old('pais_codigo') }}">
                        <input type="hidden" id="bandera_url" name="bandera_url" value="{{ old('bandera_url') }}">
                    </div>
                    <div>
                        <label class="form-label">Capital</label>
                        <input type="text" id="capital" name="capital" value="{{ old('capital') }}"
                            class="form-input bg-gray-50" readonly placeholder="Se autocompleta">
                    </div>
                    <div>
                        <label class="form-label">Moneda</label>
                        <input type="text" id="moneda" name="moneda" value="{{ old('moneda') }}"
                            class="form-input bg-gray-50" readonly placeholder="Se autocompleta">
                    </div>
                    <div>
                        <label class="form-label">Idioma(s)</label>
                        <input type="text" id="idioma" name="idioma" value="{{ old('idioma') }}"
                            class="form-input bg-gray-50" readonly placeholder="Se autocompleta">
                    </div>
                    <div>
                        <label class="form-label">Zona horaria</label>
                        <input type="text" id="zona_horaria" name="zona_horaria" value="{{ old('zona_horaria') }}"
                            class="form-input bg-gray-50" readonly placeholder="Se autocompleta">
                    </div>
                </div>

            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
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
    const btnBuscar = document.getElementById('btn_buscar_pais');

    // Cargar lista de países desde la API interna
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
        .catch(() => {
            selector.innerHTML = '<option value="">Error al cargar países</option>';
        });

    // Autocompletar al hacer clic
    btnBuscar.addEventListener('click', function () {
        const codigo = selector.value;
        if (!codigo) return;

        btnBuscar.textContent = 'Cargando...';
        btnBuscar.disabled = true;

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

                // Preview
                const preview = document.getElementById('pais_preview');
                document.getElementById('bandera_preview').src = data.bandera_url;
                document.getElementById('pais_nombre_preview').textContent = data.nombre_oficial;
                document.getElementById('pais_detalle_preview').textContent =
                    `Capital: ${data.capital} · ${data.moneda} · ${data.zona_horaria}`;
                preview.classList.remove('hidden');
            })
            .catch(() => alert('No se pudo obtener la información del país.'))
            .finally(() => {
                btnBuscar.textContent = 'Autocompletar';
                btnBuscar.disabled = false;
            });
    });
});
</script>
@endpush
