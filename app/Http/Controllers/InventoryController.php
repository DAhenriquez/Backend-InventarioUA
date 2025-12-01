<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Component;
use App\Models\Loan;
use App\Models\DecommissionedComponent;

class InventoryController extends Controller
{
    // 1. Listar componentes disponibles
    public function index() {
        return Component::all();
    }

    // 2. Crear un nuevo componente
    // Función para crear componentes nuevos
    public function store(Request $request) {
        
        // Opcional: Validar que no llegue vacío
        $request->validate([
            'nombre' => 'required',
            'cantidad' => 'required|integer',
            'inventario' => 'required'
        ]);

        // Si envían un ID manual, Laravel intentará usarlo.
        // Si no lo envían, SQLite pondrá el autoincremental.
        try {
            $component = Component::create($request->all());
            return response()->json($component, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 3. Realizar un préstamo (Bajar stock)
    public function prestar(Request $request) {
        
        // 1. VALIDACIÓN: Verificar si el usuario existe
        $usuarioExiste = User::where('rut', $request->rut)->exists();

        if (!$usuarioExiste) {
            return response()->json([
                'error' => 'El usuario con ese RUT no está registrado en el sistema.'
            ], 404); // 404 Not Found
        }

        // 2. Buscamos el componente
        $component = Component::find($request->component_id);
        
        if (!$component) {
            return response()->json(['error' => 'Componente no encontrado'], 404);
        }

        // 3. Verificamos stock
        if ($component->cantidad < $request->cantidad) {
            return response()->json(['error' => 'Stock insuficiente'], 400);
        }

        // 4. Crear el préstamo
        $loan = Loan::create([
            'user_rut' => $request->rut,
            'component_id' => $request->component_id,
            'cantidad' => $request->cantidad,
            'comentario' => $request->comentario,
            'estado' => 'activo'
        ]);

        // 5. Restar inventario
        $component->cantidad -= $request->cantidad;
        $component->save();

        return response()->json(['message' => 'Préstamo realizado con éxito', 'loan' => $loan]);
    }

    // 4. Ver préstamos activos (Para la pantalla "Ver préstamos")
    public function verPrestamos() {
        return Loan::with('component')->where('estado', 'activo')->get();
    }

    // 5. Devolver componente (Subir stock)
    public function devolver($id) {
        $loan = Loan::find($id);

        if ($loan->estado == 'devuelto') {
            return response()->json(['error' => 'Este préstamo ya fue devuelto'], 400);
        }

        // 1. Marcar como devuelto
        $loan->estado = 'devuelto';
        $loan->save();

        // 2. Recuperar el stock en el inventario
        $component = Component::find($loan->component_id);
        $component->cantidad += $loan->cantidad;
        $component->save();

        return response()->json(['message' => 'Componente devuelto correctamente']);
    }

    public function getUsers() {
        return \App\Models\User::all();
    }

    // 7. Obtener componentes dados de baja 
    public function getBajas() {
        return DecommissionedComponent::all();
    }
}