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
//---------------- ROUTES AUTHENTIFICATION -----------------------

Route::post('/connexion',[AdminController::class ,'verifyEmail']);


// ---------------- ROUTES ABOUT ARTICLE (Admin)-----------------------------
Route::get('/articles',[AdminController::class ,'GetArticle']);
Route::get('/articles/{id}',[AdminController::class ,'GetArticleById']);
Route::get('/admin/magasin/{id}/commercials',[AdminController::class ,'GetCommercialByMagasinId']);
Route::get('/admin/magasin/{id}/clients',[AdminController::class ,'GetClientByMagasinId']);
Route::post('/articles',[AdminController::class ,'AddArticle']);
// Route::post('/articles/{id}/edit',[AdminController::class ,'UpdateArticle']);
Route::post('/articles/{id}/edit',[AdminController::class ,'EditArticle']);
Route::delete('/articles/{id}',[AdminController::class ,'DeleteArticle']);
Route::get('/admin/historique',[AdminController::class ,'historiqueCommande']);
Route::get('/admin/commercial/commande',[AdminController::class ,'GetCommandeCommercial']);
Route::get('/admin/client/commande',[AdminController::class ,'GetCommandeClient']);
Route::get('/admin/notification',[AdminController::class ,'GetNotificationAdmin']);
Route::get('/admin/notificationNoRead',[AdminController::class ,'GetNotificationAdminNoRead']);
Route::get('/admin/demandes',[AdminController::class ,'GetDemande']);



// -------------------------- ROUTE ABOUT MAGASIN (Admin)--------------------

Route::get('/magasins',[MagasinController::class ,'GetMagasin']);
Route::get('/magasins/{id}',[MagasinController::class ,'GetMagasinById']);


Route::post('/magasin/add',[MagasinController::class ,'AddMagasin']);
Route::Delete('/magasin/{id}',[MagasinController::class ,'DeleteMagasin']);
// Route::get('/magasins/{id}/articles',[MagasinController::class ,'getMagasinsMerch']);
Route::get('/magasins/{id}/articles',[AdminController::class ,'GetArticleByMagasinId']);
Route::post('/magasins/{id}/articles/add',[MagasinController::class ,'AddArticleMagasin']);
Route::get('/magasins/{MagasinId}/articles/{refarticle}/{prix}',[MagasinController::class ,'GetArticleMagasinById']);
Route::post('/magasins/{id}/commercial/add',[MagasinController::class ,'AddCommercial']);
// Route::get('/magasins/{id}/commercials',[MagasinController::class ,'GetCommercials']);
Route::get('/magasins/{id}/commercials',[AdminController::class ,'GetCommercialByMagasinId']);

// Route::get('/magasins/{id}/clients',[MagasinController::class ,'GetClient']);
Route::get('/magasins/{id}/clients',[AdminController::class ,'GetClientByMagasinId']);

Route::post('/magasins/{id}/client/add',[MagasinController::class ,'AddClient']);
Route::get('/magasins/{id}/logout',[MagasinController::class ,'logoutMagasin']);  // deconnexion magasin route
Route::get('/magasins/{id}/historique',[MagasinController::class ,'HistoriqueByMaasin']);
Route::get('/magasins/{id}/info',[AdminController::class ,'infoMagasin']);
Route::post('/magasins/{id}/info/change',[MagasinController::class ,'ChangeInfoMagasin']);
Route::post('/magasins/{id}/changePassword',[MagasinController::class ,'ChnagePassword']);
Route::get('/magasins/{id}/notification',[MagasinController::class ,'GetNotificationMagasin']);
Route::get('/magasins/{id}/notification/noread',[MagasinController::class ,'GetNotificationMagasinNoRead']);
// Route::get('/testart',[AdminController::class ,'GetArticleByMagasinId']);
Route::get('/testcom',[AdminController::class ,'GetCommercialByMagasinId']);
Route::post('/bloque-magasin',[AdminController::class ,'BloqueMagasin']);


Route::get('/testclien',[AdminController::class ,'GetClientByMagasinId']);
Route::get('/magasin/{idm}/commercial/{id}',[MagasinController::class ,'GetCommercialInfo']);
Route::get('/magasin/{idm}/client/{id}',[MagasinController::class ,'GetClientInfo']);
Route::get('/magasinc/{id}/commercial/articles',[MagasinController::class ,'GetArticlesInInfo']);
Route::get('/magasin/{id}/client/articles',[MagasinController::class ,'GetArticlesInInfo']);


Route::get('/visiteur/articles/{id}',[MagasinController::class ,'getArticleUtilisateur']);
Route::post('/magasins/{id}/edit',[MagasinController::class ,'ModifierMagasin']);
Route::post('/magasins/{idm}/client/{id}/edite',[MagasinController::class ,'ModifierClientInMagasin']);

Route::post('/visiteur/articles/filterPrice',[MagasinController::class ,'FilterByPrice']);
Route::post('/visiteur/articles/filterDate',[MagasinController::class ,'FilterByDate']);












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
Route::post('/magasin-enligne/create',[MagasinController::class ,'AddMagasinEnligne']);
Route::post('/demande/{id}/active',[MagasinController::class ,'activemagasin']);
Route::get('/demande/{id}/supprimer',[MagasinController::class ,'DeleteDemande']);
Route::get('/testapi',[MagasinController::class ,'getAllArticles']);
Route::get('/testapi1/{refArticle}/{prix}',[MagasinController::class ,'getInfoArticle']);
Route::post('/testapicommande',[MagasinController::class ,'enregistrerCommande']);
Route::post('/testapicommande1/{idbl}',[MagasinController::class ,'sendArticleCommande']);


// Route::get('/testapiimage/{idar}',[MagasinController::class ,'imageapi']);

Route::get('/get-photo/{id}', [MagasinController::class, 'getPhotoArticle']);







// Route::post('/commercial/{id}/article',[MagasinController::class ,'ChnagePassword']);









// todo route post article in magasin
//TODO  admin post magasin









