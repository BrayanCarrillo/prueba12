<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MesaController,
    OrdenController,
    AuthController,
    MenuCategoryController,
    MenuPlatoController,
    EmployeeController,
    GananciasController,
    ListaVentasController,
    InsertarOrdenController,
    ContrasenaController,
    ChefController,
    ConsultasController,
    BackupController
};
use App\Models\{
    Staff,
    Admin,
    Mesa,
    MenuItem,
    Menu,
    Order,
    OrderDetail
};

// Middleware CORS
Route::options('{any}', function () {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
})->where('any', '.*');

// Ruta específica para GET en la raíz
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to your Laravel application']);
});

// Rutas de autenticación
Route::post('/login', [AuthController::class, 'login'])->middleware('auth:sanctum');


// Controladores adicionales
Route::get('/backup', [BackupController::class, 'createBackup']);
Route::post('/restore', [BackupController::class, 'restoreBackup']);

// General para todos los usuarios
Route::put('api/menu-platos/{itemID}/estado', [MenuPlatoController::class, 'cambiarEstadoPlato']);
Route::get('/detalles-mesa', [ConsultasController::class, 'mostrarDetallesDeMesa']);

// Dashboards
Route::get('/admin_dashboard', [AuthController::class, 'adminDashboard'])->name('admin_dashboard');
Route::get('/chef_dashboard', [AuthController::class, 'chefDashboard'])->name('chef_dashboard');
Route::get('/mesero_dashboard', [AuthController::class, 'meseroDashboard'])->name('mesero_dashboard');

// Lista de órdenes listas
Route::get('/ordenes/listas', [OrdenController::class, 'listarOrdenesListas']);

// Contraseñas
Route::get('/empleados', [ContrasenaController::class, 'index'])->name('empleados.index');
Route::put('/empleados/{id}/cambiar-contrasena', [ContrasenaController::class, 'cambiarContrasena'])->name('empleados.cambiar_contrasena');

Route::put('/cambiar-contrasena/{userID}', function ($userID, Request $request) {
    $request->validate([
        'password' => 'required|string|min:6',
        'role' => 'required|in:admin,staff',
    ]);

    $user = null;
    if ($request->role === 'admin') {
        $user = Admin::find($userID);
    } elseif ($request->role === 'staff') {
        $user = Staff::find($userID);
    }

    if (!$user) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }

    $user->password = bcrypt($request->password);
    $user->save();

    return response()->json(['message' => 'Contraseña cambiada correctamente'], 200);
});

// Administración de empleados
Route::get('/employees', function () {
    $employees = Staff::all(['username', 'status']);
    return response()->json(['employees' => $employees]);
});

Route::put('/empleados/{id}/actualizar-nombre', [EmployeeController::class, 'actualizarNombreEmpleado']);
Route::put('/empleados/{id}/estado', [EmployeeController::class, 'actualizarEstadoEmpleado']);
Route::get('/empleados', [EmployeeController::class, 'listarEmpleados']);
Route::post('/empleados', [EmployeeController::class, 'agregarEmpleado']);
Route::delete('/empleados/{id}', [EmployeeController::class, 'eliminarEmpleado']);
Route::put('/empleados/{id}', [EmployeeController::class, 'actualizarEmpleado']);
Route::put('/empleados/{id}/rol', [EmployeeController::class, 'actualizarRolEmpleado']);

// Administración de menú
Route::get('/menu-platos/categoria/{menuID}', [MenuPlatoController::class, 'obtenerPlatosPorCategoria']);
Route::get('/menu-categories', [MenuCategoryController::class, 'index']);
Route::get('/menu-categories/{id}', [MenuCategoryController::class, 'show']);
Route::post('/menu-categories', [MenuCategoryController::class, 'store']);
Route::put('/menu-categories/{id}', [MenuCategoryController::class, 'update']);
Route::delete('/menu-categories/{id}', [MenuCategoryController::class, 'destroy']);
Route::put('/menu-categorias/{id}/cambiar-estado', [MenuCategoryController::class, 'cambiarEstadoCategoria']);

Route::get('/menu-items', [MenuPlatoController::class, 'obtenerPlatos']);
Route::get('/menu/{menu_id?}', function ($menu_id = null) {
    if ($menu_id !== null) {
        $menu = Menu::find($menu_id);
        if ($menu) {
            $menu_items = MenuItem::where('menuID', $menu_id)->get();
            return response()->json(["menu" => $menu->toArray(), "menu_items" => $menu_items->toArray()]);
        } else {
            return response()->json(["error" => "Categoría no encontrada"], 404);
        }
    } else {
        $all_menus = Menu::all();
        return response()->json(["menus" => $all_menus->toArray()]);
    }
});
Route::get('/menu-platos/{itemID}', [MenuPlatoController::class, 'obtenerPlato']);
Route::post('/menu-platos', [MenuPlatoController::class, 'agregarPlato']);
Route::put('/menu-platos/{itemID}', [MenuPlatoController::class, 'editarPlato']);
Route::delete('/menu-platos/{itemID}', [MenuPlatoController::class, 'eliminarPlato']);
Route::put('/platos/{itemID}/estado', [MenuPlatoController::class, 'cambiarEstadoPlato'])->name('platos.estado');

// Administración de mesas
Route::put('/mesas/{id}/cambiar-estado', [MesaController::class, 'cambiarEstadoMesa']);
Route::get('/mesas', [MesaController::class, 'index']);
Route::get('/mesas/{id}', [MesaController::class, 'show']);
Route::post('/mesas', [MesaController::class, 'store']);
Route::put('/mesas/{id}', [MesaController::class, 'update']);
Route::delete('/mesas/{id}', [MesaController::class, 'destroy']);

// Administración de ventas
Route::get('/ganancias/hoy', [GananciasController::class, 'gananciasHoy']);
Route::get('/ganancias/semana', [GananciasController::class, 'gananciasSemana']);
Route::get('/ganancias/mes', [GananciasController::class, 'gananciasMes']);
Route::get('/ganancias/todo-el-tiempo', [GananciasController::class, 'gananciasTodoElTiempo']);
Route::get('/ordenes', [ListaVentasController::class, 'listarOrdenes']);

// Administración de órdenes
Route::get('obtener-mesas', [InsertarOrdenController::class, 'obtenerMesas']);
Route::get('/categorias-platos', [InsertarOrdenController::class, 'obtenerCategoriasPlatos']);
Route::post('/insertar-orden', [InsertarOrdenController::class, 'insertarOrden']);

// Administración de cocina
Route::get('/chef/all-orders', [ChefController::class, 'getAllOrdersWithDetails']);
Route::put('/chef/update-order-status/{orderId}', [ChefController::class, 'updateOrderStatus']);
Route::delete('/chef/delete-order/{orderId}', [ChefController::class, 'deleteOrder']);
Route::get('/order-details/{orderId}', function ($orderId) {
    $orderDetails = OrderDetail::where('orderID', $orderId)->get();
    return response()->json($orderDetails);
});
Route::put('/order-status/{orderId}', function (Request $request, $orderId) {
    $request->validate([
        'status' => 'required|in:preparando,Esperando,listo',
    ]);
    $order = Order::findOrFail($orderId);
    $order->status = $request->status;
    $order->save();
    return response()->json(['message' => 'Estado de orden actualizado con éxito']);
});
Route::get('/orders', function () {
    $orders = Order::all();
    return response()->json($orders);
});
Route::delete('/orders/{orderId}', function ($orderId) {
    $order = Order::findOrFail($orderId);
    $order->delete();
    OrderDetail::where('orderID', $orderId)->delete();
    return response()->json(['message' => 'Orden y detalles de orden eliminados correctamente']);
});

// Otras rutas adicionales según sea necesario

