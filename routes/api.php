<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MagasinController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// ROUTES AUTHENTIFICATION 
// Route::post('/connexion',[Authentication::class ,'login']);
// ROUTES ABOUT ARTICLE (Admin)
Route::get('/articles',[AdminController::class ,'GetArticle']);
Route::get('/articles/{id}',[AdminController::class ,'GetArticleById']);

Route::get('/admin/magasin/{id}/commercials',[AdminController::class ,'AfficheCommercialAdmin']);
Route::get('/admin/magasin/{id}/clients',[AdminController::class ,'AffcheClientAdmin']);


Route::post('/articles',[AdminController::class ,'AddArticle']);
// Route::post('/articles/{id}/edit',[AdminController::class ,'UpdateArticle']);
Route::post('/articles/{id}/edit',[AdminController::class ,'EditArticle']);
Route::delete('/articles/{id}',[AdminController::class ,'DeleteArticle']);
Route::get('/admin/historique',[AdminController::class ,'historiqueCommande']);

Route::get('/admin/commercial/commande',[AdminController::class ,'GetCommandeCommercial']);
Route::get('/admin/client/commande',[AdminController::class ,'GetCommandeClient']);
Route::get('/admin/notification',[AdminController::class ,'GetNotificationAdmin']);
Route::get('/admin/notificationNoRead',[AdminController::class ,'GetNotificationAdminNoRead']);


// ROUTE ABOUT MAGASIN (Admin)

Route::get('/magasins',[MagasinController::class ,'GetMagasin']);
Route::get('/magasins/{id}',[MagasinController::class ,'GetMagasinById']);
Route::post('/magasins',[MagasinController::class ,'AddMagasin']);
Route::Delete('/magasin/{id}',[MagasinController::class ,'DeleteMagasin']);
// Route::get('/magasins/{id}/articles',[MagasinController::class ,'getMagasinsMerch']);
Route::get('/magasins/{id}/articles',[AdminController::class ,'GetArticleByMagasinId']);
Route::post('/magasins/{id}/articles/add',[MagasinController::class ,'AddArticleMagasin']);
Route::get('/magasins/{MagasinId}/articles/{id}',[MagasinController::class ,'GetArticleMagasinById']);
Route::post('/magasins/{id}/commercial/add',[MagasinController::class ,'AddCommercial']);
// Route::get('/magasins/{id}/commercials',[MagasinController::class ,'GetCommercials']);
Route::get('/magasins/{id}/commercials',[AdminController::class ,'GetCommercialByMagasinId']);

// Route::get('/magasins/{id}/clients',[MagasinController::class ,'GetClient']);
Route::get('/magasins/{id}/clients',[AdminController::class ,'GetClientByMagasinId']);

Route::post('/magasins/{id}/client/add',[MagasinController::class ,'AddClient']);
Route::get('/magasins/{id}/logout',[MagasinController::class ,'logoutMagasin']);  // deconnexion magasin route
Route::get('/magasins/{id}/historique',[MagasinController::class ,'HistoriqueByMaasin']);
Route::get('/magasins/{id}/info',[MagasinController::class ,'InfoMagasin']);
Route::post('/magasins/{id}/info/change',[MagasinController::class ,'ChangeInfoMagasin']);
Route::post('/magasins/{id}/changePassword',[MagasinController::class ,'ChnagePassword']);
Route::get('/magasins/{id}/notification',[MagasinController::class ,'GetNotificationMagasin']);
Route::get('/magasins/{id}/notification/noread',[MagasinController::class ,'GetNotificationMagasinNoRead']);
Route::post('/connexion',[AdminController::class ,'verifyEmail']);
// Route::get('/testart',[AdminController::class ,'GetArticleByMagasinId']);
Route::get('/testcom',[AdminController::class ,'GetCommercialByMagasinId']);
Route::get('/testbloque',[AdminController::class ,'BloqueMagasin']);

Route::get('/testclien',[AdminController::class ,'GetClientByMagasinId']);






// -------------- update name of route -----------

Route::post('/magasins/{id}/commande',[MagasinController::class ,'Commande']);
Route::get('/admin/historique/{idcommande}',[MagasinController::class ,'affichedetailscommande']);

// ----------------- Routes no working only for tests ----------
// Route::get('/test',[MagasinController::class ,'image']);
Route::get('/magasins/{id}/refArticle',[AdminController::class ,'GetRefArticle']);
Route::get('/client/{id}/articles',[AdminController::class ,'ArticleClient']);
Route::get('/commercial/{id}/articles',[MagasinController::class ,'getArticleCommercial']);
Route::get('/commercial/{id}',[MagasinController::class ,'GetCommercialsById']);
Route::get('/client/{id}',[MagasinController::class ,'GetCientsById']);

// Route::post('/commercial/{id}/article',[MagasinController::class ,'ChnagePassword']);









// todo route post article in magasin
//TODO  admin post magasin









