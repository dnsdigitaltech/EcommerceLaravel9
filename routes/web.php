<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/usuario/perfil', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/usuario/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/usuario/senha/atualizar', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');
}); //Group Middleware End

/*Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});*/
//Admin Dashboard
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/perfil', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/perfil/atualiza', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/senha', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/senha/atualiza', [AdminController::class, 'AdminUpdatePassword'])->name('update.password');
});

//Vendor Dashboard
Route::middleware(['auth', 'role:vendor'])->group(function(){
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/perfil', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/perfil/atualiza', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('/vendor/senha', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/senha/atualiza', [VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');
});

Route::get('/admin/login', [AdminController::class, 'AdminLogin']);
Route::get('/fornecedor/login', [VendorController::class, 'vendorLogin'])->name('vendor.login');
Route::get('/torne-se/fornecedor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/fornecedor/registrar', [VendorController::class, 'VendorRegister'])->name('vendor.register');

Route::middleware(['auth', 'role:admin'])->group(function(){
    //Brand Routes
    Route::controller(BrandController::class)->group(function(){
        Route::get('/todas/marcas', 'AllBrand')->name('all.brand');
        Route::get('/adicionar/marca', 'AddBrand')->name('add.brand');
        Route::post('/adicionar/marca', 'StoreBrand')->name('store.brand');
        Route::get('/editar/marca/{id}', 'EditBrand')->name('edit.brand');
        Route::post('/update/marca', 'UpdateBrand')->name('update.brand');
        Route::get('/delete/marca/{id}', 'DeleteBrand')->name('delete.brand');
    });

    //Category Routes
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/todas/categorias', 'AllCategory')->name('all.category');
        Route::get('/adicionar/categoria', 'AddCategory')->name('add.category');
        Route::post('/adicionar/categoria', 'StoreCategory')->name('store.category');
        Route::get('/editar/categoria/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/categoria', 'UpdateCategory')->name('update.category');
        Route::get('/delete/categoria/{id}', 'DeleteCategory')->name('delete.category');
    });

    //SubCategory Routes
    Route::controller(SubCategoryController::class)->group(function(){
        Route::get('/todas/subcategorias', 'AllSubCategory')->name('all.subcategory');
        Route::get('/adicionar/subcategoria', 'AddSubCategory')->name('add.subcategory');
        Route::post('/adicionar/subcategoria', 'StoreSubCategory')->name('store.subcategory');
        Route::get('/editar/subcategoria/{id}', 'EditSubCategory')->name('edit.subcategory');
        Route::post('/update/subcategoria', 'UpdateSubCategory')->name('update.subcategory');
        Route::get('/delete/subcategoria/{id}', 'DeleteSubCategory')->name('delete.subcategory');
        Route::get('/subcategoria/ajax/{category_id}', 'GetSubCategory');
    });

    //Vendor Routes
    Route::controller(AdminController::class)->group(function(){
        Route::get('/forncedores/inativos', 'InactiveVendor')->name('inactive.vendor');
        Route::get('/forncedores/ativos', 'ActiveVendor')->name('active.vendor');
        Route::get('/forncedores/inativos/detalhes/{id}', 'InactiveVendorDetails')->name('inactive.vendor.details');
        Route::post('/forncedores/ativos', 'ActiveVendorApprove')->name('active.vendor.approve');
        Route::get('/forncedores/ativos/detalhes/{id}', 'ActiveVendorDetails')->name('active.vendor.details');
        Route::post('/forncedores/inativos', 'InactiveVendorApprove')->name('inactive.vendor.approve');
    });

    //Product Routes
    Route::controller(ProductController::class)->group(function(){
        Route::get('/todos/produtos', 'AllProduct')->name('all.product');
        Route::get('/adicionar/produto', 'AddProduct')->name('add.product');
    });
}); //End Middleware

require __DIR__.'/auth.php';