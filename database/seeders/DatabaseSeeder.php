<?php

namespace Database\Seeders;

use App\Models\Coto;
use App\Models\Pago;
use App\Models\Residente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Usuarios ──────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@admincoto.com',
            'password' => Hash::make('password'),
            'role'     => 'administrador',
            'activo'   => true,
        ]);

        User::create([
            'name'     => 'Empleado Demo',
            'email'    => 'empleado@admincoto.com',
            'password' => Hash::make('password'),
            'role'     => 'empleado',
            'activo'   => true,
        ]);

        // ── Cotos ─────────────────────────────────────────────────
        $coto1 = Coto::create([
            'nombre'      => 'Coto Las Palmas',
            'direccion'   => 'Av. Las Palmas 100, Col. Jardines, Guadalajara, Jalisco',
            'responsable' => 'Carlos Mendoza',
            'telefono'    => '33 1234 5678',
            'email'       => 'laspalmas@admincoto.com',
        ]);

        $coto2 = Coto::create([
            'nombre'      => 'Residencial Los Pinos',
            'direccion'   => 'Calle Los Pinos 45, Col. Bosques, Zapopan, Jalisco',
            'responsable' => 'María García',
            'telefono'    => '33 8765 4321',
            'email'       => 'lospinos@admincoto.com',
        ]);

        // ── Residentes ────────────────────────────────────────────
        $residentes1 = [
            ['nombre' => 'Juan Pérez López',    'casa' => 'A-01', 'email' => 'juan.perez@email.com',    'contacto' => '33 1111 2222'],
            ['nombre' => 'Ana Martínez Ruiz',   'casa' => 'A-02', 'email' => 'ana.martinez@email.com',  'contacto' => '33 3333 4444'],
            ['nombre' => 'Roberto Silva Torres','casa' => 'B-01', 'email' => 'roberto.silva@email.com', 'contacto' => '33 5555 6666'],
        ];

        $residentes2 = [
            ['nombre' => 'Laura Gómez Vega',    'casa' => '1',  'email' => 'laura.gomez@email.com',    'contacto' => '33 7777 8888'],
            ['nombre' => 'Miguel Ángel Ramos',  'casa' => '2',  'email' => 'miguel.ramos@email.com',   'contacto' => '33 9999 0000'],
        ];

        $residentesCreados = [];
        foreach ($residentes1 as $data) {
            $residentesCreados[] = Residente::create(array_merge($data, ['coto_id' => $coto1->id]));
        }
        foreach ($residentes2 as $data) {
            $residentesCreados[] = Residente::create(array_merge($data, ['coto_id' => $coto2->id]));
        }

        // ── Pagos ─────────────────────────────────────────────────
        $meses = [
            now()->subMonths(2)->startOfMonth(),
            now()->subMonth()->startOfMonth(),
            now()->startOfMonth(),
        ];

        foreach ($residentesCreados as $index => $residente) {
            foreach ($meses as $i => $mes) {
                // Algunos residentes tienen adeudos
                $estado = ($index === 2 && $i === 2) ? 'pendiente'
                        : (($index === 4 && $i >= 1) ? 'vencido' : 'pagado');

                Pago::create([
                    'residente_id'   => $residente->id,
                    'monto'          => 850.00,
                    'fecha'          => $mes->copy()->addDays(rand(1, 5)),
                    'periodo_mes'    => $mes,
                    'estado'         => $estado,
                    'metodo_pago'    => $estado === 'pagado' ? collect(['efectivo', 'transferencia', 'tarjeta'])->random() : null,
                    'registrado_por' => $admin->id,
                ]);
            }
        }
    }
}
