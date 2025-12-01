<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Component;
use App\Models\Loan;
use App\Models\DecommissionedComponent;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. CREAR EL ADMIN 
        User::create([
            'rut' => '99999999', 
            'nombre' => 'Administrador',
            'apellido' => 'Sistemas',
            'email' => 'admin@admin', 
            'password' => Hash::make('admin'),  
            'is_admin' => true 
        ]);

        // 2. CARGAR ALUMNOS (Solo prestatarios, no pueden entrar)
        $users = [
            ["rut" => "21203647", "nombre" => "Diego", "apellido" => "Henríquez"],
            ["rut" => "12345678", "nombre" => "Alex", "apellido" => "Negrón"],
            ["rut" => "23456789", "nombre" => "Carlos", "apellido" => "Márquez"],
            ["rut" => "20201919", "nombre" => "Stefan", "apellido" => "Lazo"],
            ["rut" => "22712987", "nombre" => "Mario", "apellido" => "Sanzana"],
            ["rut" => "21484848", "nombre" => "Benjamín", "apellido" => "Navarrete"],
            ["rut" => "19093920", "nombre" => "Matías", "apellido" => "Rodríguez"],
            ["rut" => "17902098", "nombre" => "Eduardo", "apellido" => "Silva"],
        ];

        foreach ($users as $user) {
            User::create([
                'rut' => $user['rut'],
                'nombre' => $user['nombre'],
                'apellido' => $user['apellido'],
                'email' => null, 
                'password' => null, 
                'is_admin' => false 
            ]);
        }

        // 3. CARGAR COMPONENTES
        $components = [
            [
                "id" => 1,
                "nombre" => "Led Amarillo",
                "imagen" => "ledamarillo.png",
                "descripcion" => "Diodo emisor de luz...",
                "cantidad" => 75,
                "inventario" => "Oficina secretario de estudios"
            ],
            [
                "id" => 2,
                "nombre" => "Led Rojo",
                "imagen" => "ledrojo.png",
                "descripcion" => "Diodo emisor de luz...",
                "cantidad" => 50,
                "inventario" => "Oficina secretario de estudios"
            ],
            [
                "id" => 3,
                "nombre" => "Led Azul",
                "imagen" => "ledazul.png",
                "descripcion" => "Diodo emisor de luz...",
                "cantidad" => 52,
                "inventario" =>" Oficina secretario de estudios"
            ],
            [
                "id" => 4,
                "nombre" => "Led Negro",
                "imagen" => "lednegro.png",
                "descripcion" => "Diodo emisor de luz...",
                "cantidad" => 10,
                "inventario" => "Oficina secretario de estudios"
            ],
            [
                "id" => 5,
                "nombre" => "Keypad 4x4",
                "imagen" => "keypadmodule.png",
                "descripcion" => "Módulo de teclado matricial 4x4...",
                "cantidad" => 4,
                "inventario" => "Oficina secretario de estudios"
            ],
            [
                "id" => 6,
                "nombre" => "Lector tarjeta SD",
                "imagen" => "lectorsd.png",
                "descripcion" => "Modulo lector de tarjetas SD...",
                "cantidad" => 10,
                "inventario" => "Oficina secretario de estudios"
            ],
            [
                "id" => 7,
                "nombre" => "Botón verde",
                "imagen" => "botonverde.png",
                "descripcion" => "Interruptor pulsador verde...",
                "cantidad" => 4,
                "inventario" => "Oficina secretario de estudios"
            ],
            [
                "id" => 8,
                "nombre" => "Botón blanco",
                "imagen" => "botonblanco.png",
                "descripcion" => "Interruptor pulsador blanco...",
                "cantidad" => 2,
                "inventario" => "Oficina secretario de estudios"
            ],
            [
                "id" =>9,
                "nombre" => "Sensor de nivel de agua",
                "imagen" => "sensornivelagua.png",
                "descripcion" => "Sensor de nivel de agua para tanques...",
                "cantidad" => 7,
                "inventario" => "Oficina secretario de estudios"
            ],
            [
                "id" =>10,
                "nombre" => "Pantalla LCD 16x2",
                "imagen" => "pantalla16x2.png",
                "descripcion" => "Pantalla LCD de 16 caracteres y 2 líneas...",
                "cantidad" => 3,
                "inventario" => "Oficina secretario de estudios"
            ],
            [
                "id"=>11,
                "nombre" =>"Passive Buzzer",
                "imagen" =>"passivebuffer.png",
                "descripcion" =>"Zumbador pasivo para señales acústicas...",
                "cantidad" =>12,
                "inventario" =>"Oficina secretario de estudios"
            ],
            [
                "id"=>12,
                "nombre" =>"Microscopio digital",
                "imagen" =>"microscopiodigital.png",
                "descripcion" =>"Microscopio con cámara integrada para visualización en PC...",
                "cantidad" =>1,
                "inventario" =>"Oficina director de carrera"
            ],
            [
                "id"=>13,
                "nombre" =>"Raspberry Pi 5",
                "imagen" =>"raspberry5.png",
                "descripcion" =>"Computador de placa reducida para proyectos avanzados...",
                "cantidad" =>1,
                "inventario" =>"Oficina director de carrera"
            ]
        ];

        foreach ($components as $comp) {
            Component::create([
                'id' => $comp['id'],
                'nombre' => $comp['nombre'],
                'imagen' => $comp['imagen'],
                'descripcion' => $comp['descripcion'],
                'cantidad' => $comp['cantidad'],
                'inventario' => $comp['inventario']
            ]);
        }

        // 4. CARGAR PRÉSTAMO DE EJEMPLO
        // El RUT debe existir en la lista de alumnos de arriba
        Loan::create([
            'user_rut' => "21203647", 
            'component_id' => 2, 
            'cantidad' => 4,
            'comentario' => "nada",
            'estado' => 'activo'
        ]);
        
        // 5. CARGAR BAJAS (Decommissioned)
        $eliminados = [
                [
                    "nombre" => "Arduino Uno (no original)",
                    "imagen" => "arduino_no_original.png",
                    "descripcion" => "Microcontrolador de fácil uso",
                    "cantidad" => 3,
                    "inventario" => "Oficina director de carrera",
                    "motivo" => "Quemado"
                ],
                [
                    "nombre" => "ESP8266",
                    "imagen" => "esp8266.png",
                    "descripcion" => "Microcontrolador de fácil uso con chip WIFI integrado",
                    "cantidad" => 2,
                    "inventario" => "Oficina director de carrera",
                    "motivo" => "No devuelto"
                ]
            ];

            foreach ($eliminados as $baja) {
                DecommissionedComponent::create([
                    'nombre' => $baja['nombre'],
                    'imagen' => $baja['imagen'],
                    'descripcion' => $baja['descripcion'],
                    'cantidad' => $baja['cantidad'],
                    'inventario' => $baja['inventario'],
                    'motivo' => $baja['motivo']
                ]);
            }
        }
    }
        
