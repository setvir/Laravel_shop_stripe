<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;

Auth::routes(['register' => false]);

/*
//Public ccustomer section
*/
	Route::get('/', [HomePageController::class, 'index'])->name('home');
	Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

	//Buying product
	//Checkout
	Route::get('/checkout/{product}', [CheckoutController::class, 'checkout'])->name('checkout');

	//Payment process
	Route::post('/payment/{product}', [PaymentController::class, 'createPayment'])->name('pay');
	
	Route::get('/payment/success/{transaction}', [PaymentController::class, 'success'])->name('payment.success');
	
    Route::get('/payment/cancel/{transaction}', [PaymentController::class, 'cancel'])->name('payment.cancel');

	Route::post('/webhook/stripe', [WebhookController::class, 'webhook'])->name('webhook.stripe');
//end public sectiontransaction

/*
// Admin section (logged in users only)
*/
	Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
	Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
	Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
	Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
	Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
	Route::delete('/admin/products/{product}', [AdminProductController::class, 'delete'])->name('admin.products.destroy');

//end Admin section