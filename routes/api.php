<?php

//use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\CartProductsController;

use App\Http\Controllers\RecommendationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Ruta para obtener el usuario autenticado
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// Ruta de prueba para verificar si el servidor está en funcionamiento
Route::get('/', function () {
    return response()->json(['message' => 'Hello World!']);

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/cart', [CartProductsController::class, 'showCart'])->name('cart.showCart'); // Se elimina el userId de la ruta
    Route::post('/cart/add', [CartProductsController::class, 'addToCart'])->name('cart.addToCart');
    Route::post('/cart/update-units', [CartProductsController::class, 'updateUnits'])->name('cart.update.units');
    Route::post('/cart/remove-product', [CartProductsController::class, 'removeProductFromCart'])->name('cart.remove.product');
    Route::post('/cart/removeall', [CartProductsController::class, 'removeAllProductsFromCart'])->name('cart.removeAll.product');
});




Route::get('/category', [CartProductsController::class, 'categoriasparagael'])->name('categories.list');




//Route::resource('tickets', TicketController::class);
Route::middleware('auth:sanctum')->post('/tickets/store', [TicketController::class, 'store']);

Route::get('/tickets', [TicketController::class, 'index']);
Route::get('/tickets/{id}', [TicketController::class, 'show']);






// middleware(['auth:sanctum'])->
Route::middleware('auth:sanctum')->get('/recommended/products/category/{categoryId}', [RecommendationController::class, 'getRecommendationByHistory']);
Route::get('/recommended/test/products/category/{categoryId}', [RecommendationController::class, 'testProductImages']);


//Route::get('stores/{storeId}/top-selling-products', [ReportController::class, 'getTopSellingProductsByStore']);


Route::middleware('auth:sanctum')->group(function () {

//Route::post('/tickets/{id}/assign', [TicketController::class, 'assignTicket']);
Route::post('/tickets/{ticket_id}/messages', [TicketController::class, 'addMessage']);

Route::get('/tickets/{ticket_id}/messages', [TicketController::class, 'getMessages']);
Route::Post('/assign-ticket/{id}', [TicketController::class, 'assignTicket']);

Route::get('/unassigned-tickets', [TicketController::class, 'unassignedTickets']);
Route::get('/assigned-tickets', [TicketController::class, 'assignedTickets']);
Route::put('/tickets/{id}/close', [TicketController::class, 'closeTicket']);





Route::middleware(['auth:sanctum'])->get('/products/category/{categoryId}', [RecommendationController::class, 'getCombinedProductsInCategory']);

Route::middleware('auth:sanctum')->get('/recommendationByCart', [RecommendationController::class, 'getRecommendationByCart']);

});




Route::middleware('auth:sanctum')->get('/user-tickets', [TicketController::class, 'userTickets']);

//Route::get('/recommendations', [RecomendationController::class, 'getRecommendations']);



// Rutas para los productos



// Obtener productos por tienda
Route::get('/products/store/{storeId}', [ProductController::class, 'getProductsByStore']);

// Editar un producto
Route::put('/products/{id}', [ProductController::class, 'editProduct']);

// Eliminar un producto
Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);

// Obtener productos por categoria 
Route::get('/products/category/{categoryId}', [ProductController::class, 'getProductsByCategory']);

// Agregar un nuevo producto (acceso sin autenticación si lo deseas)
Route::post('/products', [ProductController::class, 'store']);


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json(['user' => Auth::id()]);
});

