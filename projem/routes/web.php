<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SupportFormController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class, "index"])->name("home");
Route::get("/about", [HomeController::class, "about"])->name("about");
Route::get("/contact", [HomeController::class, "showForm"])->name("contact");
Route::post("/contact" , [ContactController::class, "contact"]);
Route::post("/user/{id}/{name?}", [ContactController::class,"user"])->name("user")->where(["id"=>"[0-9]+","name" => "[a-z]+"]);
Route::match(['get','post'],"/support-form", [SupportFormController::class , "support"])->name("support-form.support");

Route::patch("/users/{id}/guncelle" , [UserController::class, "update"])->name("user.update");
/*
  Patch => Kullanıcının sadece bir bilgisi güncellenmek isteniyorsa kullanılır. Örneğin yanlızca email.
  Put => Kullanıcının tüm bilgilerini güncelleyebiliriz.  
*/ 
Route::put("/users/{id}/tumunu-guncelle" , [UserController::class, "updateAll"])->name("user.updateAll");
Route::delete("/users/{id}/sil" , [UserController::class, "delete"])->name("user.delete");

Route::any("hersey", function(){
  dd("herşey geldi");
});

Route::resource("/article", "ArticleController");
Route::apiResource("/api/article", "Api/ArticleController");

Route::get("/user/{name}",[UserController::class, "showName"])
->name("user.show")
->whereAlpha("name");

Route::get("/user/{role}",[UserController::class, "roleCheck"])
->name("user.roleCheck")
->whereAlpha("role", ['admin',"user"]);

