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
Route::options('{any}', function (Request $request) {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
})->where('any', '.*');

// Rutas para la autenticación
Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');

// Rutas para realizar copias de seguridad y restauración
Route::get('/backup', [BackupController::class, 'createBackup']);
Route::post('/restore', [BackupController::class, 'restoreBackup']);

// Rutas para la administración de empleados
Route::get('/empleados', [EmployeeController::class, 'index']);
Route::post('/empleados', [EmployeeController::class, 'agregarEmpleado']);
Route::get('/empleados/{id}', [EmployeeController::class, 'listarEmpleados']);
Route::put('/empleados/{id}', [EmployeeController::class, 'actualizarEmpleado']);
Route::delete('/empleados/{id}', [EmployeeController::class, 'eliminarEmpleado']);
Route::put('/empleados/{id}/actualizar-nombre', [EmployeeController::class, 'actualizarNombreEmpleado']);
Route::put('/empleados/{id}/estado', [EmployeeController::class, 'actualizarEstadoEmpleado']);
Route::put('/empleados/{id}/rol', [EmployeeController::class, 'actualizarRolEmpleado']);
Route::put('/empleados/{id}/cambiar-contrasena', [ContrasenaController::class, 'cambiarContrasena']);

// Rutas para la administración de menú
Route::get('/menu-categories', [MenuCategoryController::class, 'index']);
Route::post('/menu-categories', [MenuCategoryController::class, 'store']);
Route::get('/menu-categories/{id}', [MenuCategoryController::class, 'show']);
Route::put('/menu-categories/{id}', [MenuCategoryController::class, 'update']);
Route::delete('/menu-categories/{id}', [MenuCategoryController::class, 'destroy']);
Route::put('/menu-categorias/{id}/cambiar-estado', [MenuCategoryController::class, 'cambiarEstadoCategoria']);

Route::get('/menu-items', [MenuPlatoController::class, 'obtenerPlatos']);
Route::get('/menu-categories/{menuID}', [MenuPlatoController::class, 'obtenerPlatosPorCategoria']);
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

// Rutas para la administración de mesas
Route::get('/mesas', [MesaController::class, 'index']);
Route::post('/mesas', [MesaController::class, 'store']);
Route::get('/mesas/{id}', [MesaController::class, 'show']);
Route::put('/mesas/{id}', [MesaController::class, 'update']);
Route::delete('/mesas/{id}', [MesaController::class, 'destroy']);
Route::put('/mesas/{id}/cambiar-estado', [MesaController::class, 'cambiarEstadoMesa']);

// Rutas para la administración de ganancias y ventas
Route::get('/ganancias/hoy', [GananciasController::class, 'gananciasHoy']);
Route::get('/ganancias/semana', [GananciasController::class, 'gananciasSemana']);
Route::get('/ganancias/mes', [GananciasController::class, 'gananciasMes']);
Route::get('/ganancias/todo-el-tiempo', [GananciasController::class, 'gananciasTodoElTiempo']);
Route::get('/ordenes', [ListaVentasController::class, 'listarOrdenesListas']);

// Rutas para la administración de órdenes
Route::get('obtener-mesas', [InsertarOrdenController::class, 'obtenerMesas']);
Route::get('/categorias-platos', [InsertarOrdenController::class, 'obtenerCategoriasPlatos']);
Route::post('/insertar-orden', [InsertarOrdenController::class, 'insertarOrden']);

// Rutas para la administración de cocina
Route::prefix('/chef')->group(function () {
    Route::get('/all-orders', [ChefController::class, 'getAllOrdersWithDetails']);
    Route::put('/update-order-status/{orderId}', [ChefController::class, 'updateOrderStatus']);
    Route::delete('/delete-order/{orderId}', [ChefController::class, 'deleteOrder']);
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
});

// Otras rutas específicas según tus necesidades
// ...

