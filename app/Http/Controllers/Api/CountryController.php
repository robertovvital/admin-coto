<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    private const API_BASE = 'https://restcountries.com/v3.1';
    private const CACHE_TTL = 3600; // 1 hora

    /**
     * Retorna la lista de todos los países (nombre + código).
     */
    public function index(): JsonResponse
    {
        $paises = Cache::remember('countries_list', self::CACHE_TTL, function () {
            $response = Http::timeout(10)->get(self::API_BASE . '/all', [
                'fields' => 'name,cca2,flags',
            ]);

            if ($response->failed()) {
                return [];
            }

            return collect($response->json())
                ->map(fn ($c) => [
                    'nombre' => $c['name']['common'],
                    'codigo' => $c['cca2'],
                    'bandera' => $c['flags']['png'] ?? '',
                ])
                ->sortBy('nombre')
                ->values()
                ->toArray();
        });

        return response()->json($paises);
    }

    /**
     * Retorna los datos de un país por su código ISO (ej: MX, US).
     */
    public function show(string $codigo): JsonResponse
    {
        $codigo = strtoupper($codigo);

        $datos = Cache::remember("country_{$codigo}", self::CACHE_TTL, function () use ($codigo) {
            $response = Http::timeout(10)->get(self::API_BASE . "/alpha/{$codigo}");

            if ($response->failed() || empty($response->json())) {
                return null;
            }

            $pais = $response->json()[0];

            return [
                'nombre'       => $pais['name']['common'],
                'nombre_oficial' => $pais['name']['official'],
                'codigo'       => $pais['cca2'],
                'capital'      => $pais['capital'][0] ?? 'N/A',
                'moneda'       => $this->extraerMoneda($pais['currencies'] ?? []),
                'idioma'       => $this->extraerIdioma($pais['languages'] ?? []),
                'zona_horaria' => $pais['timezones'][0] ?? 'N/A',
                'bandera_url'  => $pais['flags']['png'] ?? '',
                'region'       => $pais['region'] ?? '',
                'subregion'    => $pais['subregion'] ?? '',
                'poblacion'    => $pais['population'] ?? 0,
            ];
        });

        if (! $datos) {
            return response()->json(['error' => 'País no encontrado'], 404);
        }

        return response()->json($datos);
    }

    /**
     * Extrae el nombre de la primera moneda disponible.
     */
    private function extraerMoneda(array $monedas): string
    {
        if (empty($monedas)) {
            return 'N/A';
        }

        $primera = array_values($monedas)[0];

        return ($primera['name'] ?? '') . ' (' . (array_key_first($monedas)) . ')';
    }

    /**
     * Extrae el nombre del primer idioma disponible.
     */
    private function extraerIdioma(array $idiomas): string
    {
        if (empty($idiomas)) {
            return 'N/A';
        }

        return implode(', ', array_values($idiomas));
    }
}
