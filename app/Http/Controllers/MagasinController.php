<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\stocks;
use App\Models\Article;
use App\Models\Magasin;
use App\Models\commande;
use App\Models\commercials;
use Illuminate\Http\Request;
use App\Models\detailCommande;
use App\Models\NotificationAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MagasinController extends Controller
{
    public function GetMagasin(){ 
        $magasins = Magasin::all();
        foreach ($magasins as $magasin) {
            $IdVille = $magasin->IdVille; 
            $IdDepot = $magasin->IdDepot; 
            $Villes = DB::select('select Ville from ville where IdVille = ?', [$IdVille]);
            $VilleName = [];
        foreach ($Villes as $Ville) {
            $VilleName[] = $Ville->Ville;
        }

        $magasin->VilleName = $VilleName;
        $Depots = DB::select('select NomDepot from depot where IdDepot = ?', [$IdDepot]);
        $DepotName = [];
        foreach ($Depots as $Depot) {
            $DepotName[] = $Depot->NomDepot;
        }

        $magasin->DepotName = $DepotName;
    }
        return response()->json($magasins, 200);
    }
    public function GetMagasinById($id){ 
        $magasins = DB::select('select * from magasin where IdMagasin  = ?',[$id]);
        foreach($magasins as $magasin)
        $IdVille=$magasin->IdVille; 
        $ville = DB::select('select Ville from ville where IdVille = ?',[$IdVille]);
        return response()->json([$magasin,$ville],200);
    }
    public function AddMagasin(request $request){ 
        $request->validate([
            'NomMagasin' => 'required',
            'Tele' => 'required|numeric',
            'Adresse' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'Fax' => 'required|numeric',
        ]);
        $NameMagasin = $request->NomMagasin;
        $ImageMagasin =$request->file('image')->store('MagasinIMG','public');
        $AdressMagasin = $request->Adresse;
        $FaxMagasin = $request->Fax;
        $TeleMagasin = $request->Tele;
            Magasin::create([
                'NomMagasin'=>$NameMagasin,
                'ImageEP'=>$ImageMagasin,
                'Adresse'=>$AdressMagasin,
                'Tele'=>$TeleMagasin,
                'Fax'=>$FaxMagasin,
                'IdDepot'=>1,
                'IdVille'=>4,
                'Supprime'=>false,



            ]);
        return response()->json(['message'=>'Magasin added successfuly'], 200);
    }
    public function EditMagasin($id){ 
        dd($id);
    }
    public function DeleteMagasin($id){ 
        dd($id);
    }
    // public function getMagasinsMerch($id) { 
    //     $MagasinStock = DB::connection('mysql_second')->table('stocks')->select('*')->get();
    //     $Substitu = DB::select('select * from article_x_substitut ');
    //     $articleIds = [];
    //     $articleQuantities = [];
        
    //     foreach ($MagasinStock as $magasin) {
    //         $articleIds[] = $magasin->IdArticle;
    //         $articleQuantities[$magasin->IdArticle] = $magasin->quantité;
    //     }
        
    //     $articles = DB::table('articles')
    //         ->whereIn('articles.IdArticle', $articleIds)
    //         ->leftJoin('article_x_substitut', 'articles.IdArticle', '=', 'article_x_substitut.IdArticle')
    //         ->select('articles.*', 'article_x_substitut.libellesubstitut')
    //         ->get();
        
    //     foreach ($articles as $article) {
    //         if (isset($articleQuantities[$article->IdArticle])) {
    //             $article->quantité = $articleQuantities[$article->IdArticle];
    //         }
    //     }
        
    //     return response()->json($articles, 200);
        
    // }
    public function getMagasinsMerch($id) { 
        $MagasinStock = DB::connection('mysql_second')->table('stocks')->select('*')->get();
        $substitut = DB::select('select * from article_x_substitut ');
        
        $ArticleSub = [];
        $articleIds = [];
        $articleQuantities = [];
        
        foreach ($MagasinStock as $magasin) {
            $articleIds[] = $magasin->IdArticle; 
            $articleQuantities[$magasin->IdArticle] = $magasin->quantité; 
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
    }        
// public function AddArticleMagasin(Request $request){
//         $NomArticle = $request->Designation
// }
    public function GetArticleMagasinById($MagasinId,$id ){
        // Fetching data from the stocks table
$MagasinStock = DB::connection('mysql_second')->table('stocks')->select('*')->get();

// Fetching one LibelleSubstitut for each IdArticle from the article_x_substitut table
$libelles = DB::select("SELECT IdArticle, LibelleSubstitut FROM article_x_substitut WHERE IdArticle IN (?) LIMIT 1", [$id]);

// Initializing arrays to store data
$articleQuantities = []; 
$articlePrix1 = []; 
$articlePrix2 = []; 
$articlePrix3 = []; 
$articlePrixTtc = [];
$libelleSubstitut = []; 

// Converting $id to an array if it's not already one
$id = is_array($id) ? $id : [$id];

// Storing LibelleSubstitut for each IdArticle
foreach ($libelles as $libelle) {
    $libelleSubstitut[$libelle->IdArticle] = $libelle->LibelleSubstitut;
}

// Storing other relevant data from MagasinStock
foreach ($MagasinStock as $magasin) {
    $articleQuantities[$magasin->IdArticle] = $magasin->quantité; 
    $articlePrix1[$magasin->IdArticle] = $magasin->prix_ht_1_magasin; 
    $articlePrix2[$magasin->IdArticle] = $magasin->prix_ht_2_magasin; 
    $articlePrix3[$magasin->IdArticle] = $magasin->prix_ht_3_magasin; 
    $articlePrixTtc[$magasin->IdArticle] = $magasin->prix_ttc_magasin;
}

// Fetching articles data
$articles = DB::table('articles')->whereIn('IdArticle', $id)->get();

// Assigning relevant data to articles
foreach ($articles as $article) {
    if (isset($articleQuantities[$article->IdArticle])) {
        $article->quantité = $articleQuantities[$article->IdArticle];
        $article->Prix1 = $articlePrix1[$article->IdArticle];
        $article->Prix2 = $articlePrix2[$article->IdArticle];
        $article->Prix3 = $articlePrix3[$article->IdArticle];
        $article->PrixTtc = $articlePrixTtc[$article->IdArticle];
        $article->Libellsubstitut = isset($libelleSubstitut[$article->IdArticle]) ? $libelleSubstitut[$article->IdArticle] : null;
    }
}

return response()->json($articles, 200);

    }
    
    public function GetCommercials(){
        $Commercials = DB::connection('mysql_second')->table('commercials')->select('*')->get();
        return response()->json($Commercials,200);

}
public function AddCommercial(request $request){
    $request->validate([
        'nom'=>'required',
        'prenom'=>'required',
    ]);
        $NomCommercial = $request->nom;
        $PrenomCommercial = $request->prenom;
        $telephone = $request->télephone;
        $IdMagasin= $request->IdMagasin;
        $ville = $request->ville;
        $credit = $request->credit;
        $vente = $request->vente;
        $annulé = $request->annulé;
        $remboursé = $request->remboursé;
        commercials::create([
            "nom"=>$NomCommercial,
            "prenom"=>$PrenomCommercial,
            "télephone"=>$telephone,
            "ville"=>$ville,
            "email"=>$NomCommercial.".".$PenomCommercial."@gmail.com",
            "password"=>$PrenomCommercial."1",
            'IdMagasin'=>$IdMagasin,
            'credit'=>$credit,
            'vente'=>$vente,
            'annulé'=>$annulé,
            'remboursé'=>$remboursé,

        ]);
        return response()->json('commercial bien ajouter', 200);


}
public function AddClient(request $request){
    $request->validate([
        'NomClient'=>'required',
        'PrenomClient'=>'required',
        'Ville'=>'required',
        'ICE'=>'required|min:6|max:6',


    ]);
        $NomClient = $request->NomClient;
        $PrenomClient = $request->PrenomClient;
        $CreditClient = $request->Credit;
        $ville = $request->Ville;
        $NumTele = $request->NumTele;
        $ICE = $request->ICE;

        client::create([
            "NomClient"=>$NomClient,
            "PrenomClient"=>$PrenomClient,
            "Credit"=>$CreditClient,
            "Ville"=>$ville,
            "EmailClient"=>$NomClient.".".$PrenomClient."@gmail.com",
            "PasswordClient"=>$PrenomClient."2",
            "NumTele"=>$NumTele,
            "AddresseFacturation"=>"0",
            "SoldeMaximum"=>"0",
            "Patente"=>"0",
            "I_F"=>"0",
            "ICE"=>$ICE,


        ]);
        return response()->json("good", 200);


}
public function GetClient(){
    $Clients = DB::connection('mysql_second')->table('clients')->select('*')->get();
    return response()->json($Clients,200);

}
public function AddArticleMagasin(request $request){
    $NomArticle=$request->Designation;
    $PrixVenteArticleTTC=$request->PrixVenteArticleTTC;
    $Prix1Article=$request->prix_ht_1_magasin;
    $Prix2Article=$request->prix_ht_2_magasin;
    $Prix3Article=$request->prix_ht_3_magasin;
    $RefArticle=$request->RefArticle;
    $Quantité=$request->quantité;
    $Description=$request->Description;
    $Unite=$request->Unite;
    $Image = $request->file('image')->store('ArticleIMG', 'public');

    $request->validate([
        'Designation' => 'required',
        'image' =>'required|image|mimes:jpeg,png,jpg',
        'PrixVenteArticleTTC' => 'required|numeric',
        'Unite' => 'required|numeric',
        'RefArticle' => 'required',
        "prix_ht_2_magasin"=> 'required',
        "prix_ht_1_magasin"=> 'required',
        "prix_ht_3_magasin"=> 'required',

    ]);
    $article = Article::create([
        "Designation"=>$NomArticle,
        "PrixVenteArticleTTC"=>$PrixVenteArticleTTC,
        "RefArticle"=>$RefArticle,
        "Description"=>$Description,
        "Unite"=>$Unite,
        "Image"=>$Image,
        "stock"=>100,

    ]);

    stocks::create([
        "IdArticle"=>$article->IdArticle,
        "prix_ht_1_magasin"=>$Prix1Article,
        "prix_ht_2_magasin"=>$Prix2Article,
        "prix_ht_3_magasin"=>$Prix3Article,
        "prix_ttc_magasin"=>$PrixVenteArticleTTC,
        "quantité"=>$Quantité,
    ]);

    return response()->json(['message'=>'article added successfuly'], 200);
    

}
public function logoutMagasin(){
    session::flush();
    Auth::logout();
    return response()->json("logout successfuly", 200);
}
public function Commande(request $request){
    $NomClient = $request->NomClient;
    $Adresse = $request->Adresse;
    $TotalCommandeHT= $request->TotalCommandeHT;
    $TotalRemise = $request->TotalRemise;
    $detail = $request->detail;
    $Statut=$request->Statut;
    $IdMagasin = $request->IdMagasin;
    $NomMagasin = $request->NomMagasin;
    $IdClient = $request->IdClient;
    $DateCommande=$request->DateCommande;

    $commande = commande::create([
        'NomClient'=>$NomClient,
        'Adresse'=>$Adresse,
        'IdMagasin'=>$IdMagasin,
        'NomMagasin'=>$NomMagasin,
        'IdClient'=>$IdClient,
        'TotalCommandeHT'=>$TotalCommandeHT,
        'DateCommande'=>$DateCommande,
        'Statut' =>$Statut,
    ]);
    foreach($detail as $detaile){
    detailCommande::create([
        'idCommande'=>$commande->id,
        'RefArticle'=>$detaile['refArticle'],
        'NomArticle'=>$detaile['designation'],
        'quantity'=>$detaile['quantity'],
        'Statut'=>$Statut,
        'prix'=>$detaile['prix'],
    ]);
    }
    NotificationAdmin::create([
        'Notification_Title'=>'Nouvel commande',
        'Notification_Content'=>'Une nouvelle commande a été ajoutée par '.$NomMagasin,
    ]);
    return response()->json('good', 200);

}
public function affichedetailscommande($idcommande){
    $detailcommande=DB::select('select * from detail_commandes where idCommande  = ?', [$idcommande]);
        // foreach($detailcommande as $detail)  
    return response()->json($detailcommande);

}
public function InfoMagasin($id){
    $Accounts = DB::connection('mysql_second')->table('magasins')->where("id", $id)->get();
    return response()->json($Accounts, 200);

}
public function ChangeInfoMagasin(Request $request , $id){
    $Accounts = DB::connection('mysql_second')->table('magasins')->where("id", $id)->get();

$validated_magasin = $request->validate([
    'Nom_complet_propriétaire' => 'required',
    'adresse de siège' => '',
]);

foreach ($Accounts as $Account) {
    DB::connection('mysql_second')
        ->table('magasins')
        ->where('id', $Account->id)
        ->update($validated_magasin);
}

return response()->json("magasin bien modifier", 200);

}
public function ChnagePassword(Request $request, $id)
{
    $Account = DB::connection('mysql_second')->table('magasins')->where("id", $id)->first();

        $OldPassword = $request->password;
        $NewPassword = $request->NewPassword;
        
        if ($OldPassword == $Account->password) {
            DB::connection('mysql_second')->table('magasins')
                ->where('id', $id)
                ->update(['password' => $NewPassword]);
            
            
            } else {
                dd("false");
            }
            return response()->json("password bien modifier", 200);
}

public function image(){
    $image=$image->imag;
    $decoding_img=base64_decode($img_bas64);
    file_put_contents(public_path("tem/premierPhotoDecoding.png"),$decoding_img);
    // dd($img_bas64);
}
public function HistoriqueByMaasin($id){
    // dd($id);
    $historique = DB::select('select * from commandes where IdMagasin = ?', [$id]);
    return response()->json($historique, 200);
}
public function getArticleCommercial($id)
{
    // Fetch all records from the 'stocks' table in the secondary MySQL connection
    $articles = DB::connection('mysql_second')->table('stocks')->select('*')->get();
    
    // Initialize an empty array to hold the article stocks
    $articleStocks = [];

    // Loop through each article in the stocks table
    foreach ($articles as $article) {
        // Fetch the corresponding articles from the primary database
        $articleStock = DB::select('select * from articles where IdArticle = ?', [$article->IdArticle]);
        
        // Merge the result into the $articleStocks array
        $articleStocks = array_merge($articleStocks, $articleStock);
    }

    // Return the accumulated article stocks as JSON
    return response()->json($articleStocks);
    
}
public function GetCommercialsById($id){
    $commercial = DB::connection('mysql_second')->table('commercials')->where('id', $id)->get();
    return response()->json($commercial, 200);
}
public function GetCientsById($id){
    $commercial = DB::connection('mysql_second')->table('clients')->where('IdClient', $id)->get();
    return response()->json($commercial, 200);
}
public function GetNotificationMagasin(){
    $notification = DB::connection('mysql_second')->table('notification')->where('IdRole', 1)->get();
    // dd($notification);
    return response()->json($notification, 200);

}
public function GetNotificationMagasinNoRead(){
    $notificationNoRead = DB::connection('mysql_second')->table('notification')->where('Statut', 'not readable')->get();
    // dd($notification);
    return response()->json($notificationNoRead, 200);

}

// public function ArticleClient(){
//     $articles = DB::select('select * from users where active = ?', [1])
// }
}

