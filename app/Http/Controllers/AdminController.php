<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Dataarticle;
use App\Models\demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\notificationzenpart;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    // function add Article 

    public function AddArticle(request $request){

        // TODO renomer les variables 
        $request->validate([
            'Designation' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'PrixVenteArticleTTC' => 'required|numeric',
            'Description' => 'required',
            'Unite' => 'required|numeric',
            'stock' => 'required|numeric',
            'RefArticle' => 'required|numeric',


        ]);
        $NameArticle = $request->Designation;
        $ImageArticle =$request->file('image')->store('ArticleIMG','public');
        $PriceArticle = $request->PrixVenteArticleTTC;
        $DescriptionArticle = $request->Description;
        $UniteArticle = $request->Unite;
        $StockArticle = $request->stock;
        $RefArticle = $request->RefArticle;
            Article::create([
                'Designation'=>$NameArticle,
                'Image'=>$ImageArticle,
                'PrixVenteArticleTTC'=>$PriceArticle,
                'Unite'=>$UniteArticle,
                'Description'=>$DescriptionArticle,
                'RefArticle'=>$RefArticle,
                'stock'=>$StockArticle,
            ]);
            notificationzenpart::create([
                'Notification_Title'=>'Découvrez le nouveau produit',
                'IdRole'=>1,
                'Notification_Content'=>'Découvrez le nouveau produit '.$NameArticle.' et soyez les premiers acheteurs sur le marché',
            ]);
            // TODO if create ok add in historiques des operations 
        return response()->json(['message'=>'article added successfuly'], 200);
}
// function show all Article 

public function GetArticle(){ 
    $articles = DB::table('articles')
    ->select('articles.*', 'article_x_substitut.LibelleSubstitut')
    ->leftJoin('article_x_substitut', 'articles.IdArticle', '=', 'article_x_substitut.IdArticle')
    ->get();

return response()->json($articles, 200);

}
// function show Article by id 

public function getArticleById($id) {
    try {
        // Fetch article details
        $article = DB::table('articles')->where('IdArticle', $id)->first();

        // Check if article exists
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        // Fetch substitute label
        $libelle = DB::table('article_x_substitut')->where('IdArticle', $id)->value('LibelleSubstitut');

        $quantityInMagasin = DB::connection('mysql_second')
                            ->table('stocks')
                            ->where('IdArticle', $id)
                            ->value('quantité');
        $prixht1 = DB::connection('mysql_second')
                            ->table('stocks')
                            ->where('IdArticle', $id)
                            ->value('prix_ht_1_magasin');
        $prixht2 = DB::connection('mysql_second')
                            ->table('stocks')
                            ->where('IdArticle', $id)
                            ->value('prix_ht_2_magasin');
        $prixht3 = DB::connection('mysql_second')
                            ->table('stocks')
                            ->where('IdArticle', $id)
                            ->value('prix_ht_3_magasin');
        $prixttc = DB::connection('mysql_second')
                            ->table('stocks')
                            ->where('IdArticle', $id)
                            ->value('prix_ttc_magasin');
        $article->LibelleSubstitut = $libelle;
        $article->quantity_Zenpart = $quantityInMagasin;
        $article->prixht1_Zenpart = $prixht1;
        $article->prixht2_Zenpart = $prixht2;
        $article->prixht3_Zenpart = $prixht3;
        $article->prixttc_Zenpart = $prixttc;



        // Prepare response data
        $responseData = [
            'article' => $article
        ];

        return response()->json($responseData, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error occurred while fetching article details'], 500);
    }
}





// function update Article 

public function UpdateArticle($id){
    $Article = DB::select("select * from articles where IdArticle = ?", [$id]);
    foreach($Article as $article)
    return response()->json($article, 200);
}



// function Edite Article 

public function EditArticle(Request $request , $id){
    $article = Article::find($id);
    $validated_Artcile = $request->validate([
        'Designation' => 'required',
        'PrixVenteArticleTTC' => 'required',
        'Unite' => '',
        'stock' => '',
        'RefArticle' => '',
    ]);

    
    if ($request->hasFile('image')) {
        $article->image = $request->file('image')->store('ArticleIMG', 'public');
    }
    $article->fill($validated_Artcile)->save();
    
    // dd($article);
    // $article->save();
            // TODO if create ok add in historiques des operations 

    return response()->json([
        'message' => 'Article Updated successfully!',
    ]);
}

// function delete Article 
public function DeleteArticle($id){
    
    $Articles_deleting = DB::delete("DELETE from articles where IdArticle = ?", [$id]);
    if($Articles_deleting){
        
        return response()->json([
            'message'=>'The product has been successfully deleted'
        ], 200);
            // TODO if create ok add in historiques des operations 

    }else{
        return response()->json([
            'message'=>'no product with this id '
        ], 200);
    }
}

public function GetRefArticle(){
    $Article = DB::select("select * from articles");
    return response()->json($Article, 200);
}
public function historiqueCommande(){
    $historique = DB::select("select * from commandes");
    return response()->json($historique, 200);
}
public function AfficheCommercialAdmin($id){
    $commercial = DB::connection('mysql_second')->table('commercials')->where("IdMagasin", $id)->get();
    return response()->json($commercial,200);
}
public function AffcheClientAdmin($id){
    $Client = DB::connection('mysql_second')->table('clients')->where("IdMagasin", $id)->get();
    return response()->json($Client,200);
}
public function GetCommandeCommercial(){
    $CommandeCommercial = DB::connection('mysql_second')->table('historique_commande_commercials')->get();
    return response()->json($CommandeCommercial, 200);
}
public function GetCommandeClient(){
    $CommandeClient = DB::connection('mysql_second')->table('historique_commande_clients')->get();
    return response()->json($CommandeClient, 200);
}  
public function GetNotificationAdmin(){
    $Notification = DB::select("select * from notification_admins");
    return response()->json($Notification, 200);
}   
public function GetNotificationAdminNoRead(){
    $notifications = DB::table('notification_admins')
    ->where('Statut', 'not readable')
    ->get();

return response()->json($notifications, 200);
} 

public function verifyEmail(Request $request)
{
//     $CompteEmail = $request->input('CompteEmail');
//     $Password = $request->Password;

//     $databases = DB::select('SHOW DATABASES');
//     $databaseNames = array_map(function($db) {
//         return $db->Database;
//     }, $databases);

//     // Extract the part before the first point in $CompteEmail
//     $emailBeforePoint = substr($CompteEmail, 0, strpos($CompteEmail, '.'));

//     // Extract the part after the first point in $CompteEmail and before the "@"
//     $remainingPart = substr($CompteEmail, strpos($CompteEmail, '.') + 1);
//     $emailAfterFirstPoint = substr($remainingPart, 0, strpos($remainingPart, '@'));

//     // Extract the part after the first point but before the next point if it exists
//     $emailAfterPoint = strtok($emailAfterFirstPoint, '.');

//     $matchFound = false;

//     // Check if any database name contains "magasin_" followed by the part before the first point in $CompteEmail
//     foreach ($databaseNames as $databaseName) {
//         if (strpos($databaseName, 'magasin_') !== false) {
//             $databasePart = substr($databaseName, strpos($databaseName, 'magasin_') + strlen('magasin_'));
//             if ($emailBeforePoint === $databasePart) {
//                 $matchFound = true;
//                 Config::set('database.connections.dynamic', [
//                                     'driver' => 'mysql',
//                                     'host' => '127.0.0.1',
//                                     'port' => '3306',
//                                     'database' => $databaseName,
//                                     'username' => 'root',
//                                     'password' => '',
//                                 ]);
//                 // Check the part after the first point in the email
//                 if ($emailAfterPoint === 'magasin') {
//                     $magasinAccount = DB::connection('dynamic')->table('magasins')->where("email",$CompteEmail)->where('password', $Password)->get();
//                     foreach ($magasinAccount as $magasin) {
//                         return response()->json(['message' => 'magasin', "account" => $magasin], 200);
//                     }
//                 } elseif ($emailAfterPoint === 'commercial') {
//                     $CommercialAccount = DB::connection('dynamic')->table('commercials')->where("email",$CompteEmail)->where('password', $Password)->get();
//                     foreach ($CommercialAccount as $commercial) {
//                             return response()->json(['message' => 'commercials', "account" => $commercial], 200);
//                         }
//                 }elseif ($emailAfterPoint === 'client') {
//                     $ClientAccount = DB::connection('dynamic')->table('clients')->where("EmailClient",$CompteEmail)->where('PasswordClient', $Password)->get();
//                     foreach ($ClientAccount as $client) {
//                         return response()->json(['message' => 'client', "account" => $client], 200);
//                     }                } 
//                 else {
//                     return response()->json(['message' => 'No account']);
//                 }
//             }
//         }
//     }

//     if (!$matchFound) {
//         return response()->json(['message' => 'The parts do not match.']);
//     }
// }
    
$CompteEmail = $request->input('CompteEmail');
    $Password = $request->input('Password');

    $account = DB::table('utilisateur__accounts')
              ->where('email', $CompteEmail)
              ->where('password', $Password)
              ->first();

    // Check if user exists
    if ($account) {
        $databaseName = $account->database_name;
        $AccountType = $account->Account_type;
        if($databaseName=="pro_stock"){
            return response()->json(["message"=>'admin'], 200);

        }else{

            // Change the database connection dynamically
            config(['database.connections.dynamic_mysql' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => $databaseName,
                'username' => 'root',
                'password' =>'',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ]]);
    
            DB::purge('dynamic_mysql');
            DB::setDefaultConnection('dynamic_mysql');
            if($AccountType=="magasins"){
 $magasins = DB::table('magasins')->get();
                foreach($magasins as $magasin){
                    if($magasin->status =="bloqué"){
                    return response()->json(["message"=>'magasin bloqué' ,"status"=>$magasin], 200);
                        
                    }else{
                    return response()->json(["message"=>'magasins' ,"account"=>$magasin], 200);
                }
            }
            }elseif($AccountType=="commercials"){
                $commercials = DB::table('commercials')->get();
                foreach($commercials as $commercial){

                    return response()->json(["message"=>'commercials' ,"account"=>$commercial], 200);
                }
            }elseif($AccountType=="clients"){
                $clients = DB::table('clients')->get();
                foreach($clients as $client){

                    return response()->json(["message"=>'clients' ,"account"=>$client], 200);
                }
            }
    
           
    
        }
    } else {
        return response()->json(['message' => 'False information'], 200);
    }

}


public function GetArticleByMagasinId(Request $request){
    $id = $request->id ;
    $account = DB::table('utilisateur__accounts')->where('id', $id)->first();

    if ($account) {
        // Set the dynamic database connection
        config(['database.connections.dynamic_mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => $account->database_name,
            'username' => 'root',
            'password' =>'',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]]);

        // Connect to the dynamic database
        DB::purge('dynamic_mysql');
        DB::reconnect('dynamic_mysql');

        // Query the stocks table
        $stocks = DB::connection('dynamic_mysql')->table('stocks')->get();
        $substitut = DB::select('select * from article_x_substitut ');
        
        $ArticleSub = [];
        $articleIds = [];
        $articleQuantities = [];
        
        foreach ($stocks as $stock) {
            $articleIds[] = $stock->IdArticle; 
            $articleQuantities[$stock->IdArticle] = $stock->quantité; 
        }
        
        $articles = DB::table('articles')->whereIn('IdArticle', $articleIds)->get();
        
        foreach ($articles as $article) {
            $libelleSubstitutArray = DB::table('article_x_substitut')
                ->where('IdArticle', $article->IdArticle)
                ->pluck('LibelleSubstitut')
                ->toArray();
        
            // Join the LibelleSubstitut array into a single string
            $article->LibelleSubstitut = implode(', ', $libelleSubstitutArray);
        
            if (isset($articleQuantities[$article->IdArticle])) {
                $article->quantité = $articleQuantities[$article->IdArticle];
            }
        }
        
        return response()->json($articles, 200);
    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
}
public function GetCommercialByMagasinId(Request $request){
    $id = $request->id ;
    $account = DB::table('utilisateur__accounts')->where('id', $id)->first();

    if ($account) {
        // Set the dynamic database connection
        config(['database.connections.dynamic_mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => $account->database_name,
            'username' => 'root',
            'password' =>'',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]]);

        // Connect to the dynamic database
        DB::purge('dynamic_mysql');
        DB::setDefaultConnection('dynamic_mysql');

        // Query the stocks table
        $stocks = DB::connection('dynamic_mysql')->table('commercials')->get();

        return response()->json($stocks);
    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
}
public function GetClientByMagasinId(Request $request){
    $id = $request->id ;
    $account = DB::table('utilisateur__accounts')->where('id', $id)->first();

    if ($account) {
        // Set the dynamic database connection
        config(['database.connections.dynamic_mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => $account->database_name,
            'username' => 'root',
            'password' =>'',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]]);
        // Connect to the dynamic database
        DB::purge('dynamic_mysql');
        DB::reconnect('dynamic_mysql');

        // Query the stocks table
        $stocks = DB::connection('dynamic_mysql')->table('clients')->get();

        return response()->json($stocks);
    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
}
public function GetArticleByMagasin(Request $request){
    $id = $request->id ;
    $account = DB::table('utilisateur__accounts')->where('id', $id)->first();

    if ($account) {
        // Set the dynamic database connection
        config(['database.connections.dynamic_mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => $account->database_name,
            'username' => 'root',
            'password' =>'',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]]);
        DB::purge('dynamic_mysql');
        DB::reconnect('dynamic_mysql');
        $stocks = DB::connection('dynamic_mysql')->table('clients')->get();
        return response()->json($stocks);
    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
}
private function databaseExists($database_name) {
    $databases = DB::select("SHOW DATABASES LIKE '{$database_name}'");
    return count($databases) > 0;
}
public function BloqueMagasin(Request $request){
    // Retrieve the id from the request
    $id = $request->input('id');
    
    // Fetch the account associated with the given id
    $account = DB::select('select database_name from utilisateur__accounts where id = ?', [$id]);

    if (!empty($account)) {
        $databaseName = $account[0]->database_name;
        $databases = DB::select('SHOW DATABASES');
        $databaseNames = array_map(function($db) {
            return $db->Database;
        }, $databases);

        // Check if the database exists
        if (in_array($databaseName, $databaseNames)) {
            // Set the dynamic database connection
            Config::set('database.connections.dynamic', [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => $databaseName,
                'username' => 'root',
                'password' => '',
            ]);
            DB::purge('mysql');
            DB::reconnect('dynamic');

            // Fetch magasins and update their status
            $magasins = DB::connection('dynamic')->table('magasins')->get();
            foreach ($magasins as $magasin) {
                $newStatus = ($magasin->status === 'active') ? 'bloqué' : 'active';
                DB::connection('dynamic')->table('magasins')
                    ->where('id', $magasin->id)
                    ->update(['status' => $newStatus]);
            }
            return response()->json($magasins, 200);
        } else {
            return response()->json(['error' => 'Database not found.'], 404);
        }
    } else {
        return response()->json(['error' => 'Account not found.'], 404);
    }
}
public function infoMagasin(Request $request){
    $id=$request->id;
    $account = DB::table('utilisateur__accounts')->where('id', $id)->first();
    if ($account) {
        // Set the dynamic database connection
        config(['database.connections.dynamic_mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => $account->database_name,
            'username' => 'root',
            'password' =>'',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]]);
        DB::purge('dynamic_mysql');
        DB::reconnect('dynamic_mysql');
        $magasins = DB::connection('dynamic_mysql')->table('magasins')->get();
        return response()->json($magasins);
    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
}
Public function GetDemande(){
    $demandes = demande::all();
    return response()->json($demandes,200);
}

}


