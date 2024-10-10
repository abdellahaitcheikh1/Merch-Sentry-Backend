<?php

namespace App\Http\Controllers;
use App\Models\client;

use App\Models\stocks;
use App\Models\Article;
use App\Models\demande;
use App\Models\Magasin;
use App\Models\commande;
use App\Models\commercials;
use Illuminate\Http\Request;
use App\Models\detailCommande;
use App\Models\NotificationAdmin;
use Illuminate\Support\Facades\DB;
use App\Models\Utilisateur_Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Schema\Blueprint;
use App\Notifications\RegisterNotification;
use App\Notifications\ActiveMagasinNotification;
use App\Models\User; // Make sure this line is present
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MagasinController extends Controller
{
    public function getAllArticles(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 30;
        $cacheKey = "articles_page_{$page}";
        $cacheAllDataKey = "all_articles"; // Cache key for all articles
    
        // Check if cached data for the current page exists
        if (Cache::has($cacheKey)) {
            $cachedArticles = Cache::get($cacheKey);
            return response()->json($cachedArticles);
        }
    
        // Check if cached data for all articles exists
        if (Cache::has($cacheAllDataKey)) {
            $articleArray = Cache::get($cacheAllDataKey);
        } else {
            $xmlPayload = '<?xml version="1.0" encoding="utf-8"?>' .
                '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
                '<soap:Body>' .
                '<GetAllArticle1 xmlns="http://tempuri.org/" />' .
                '</soap:Body>' .
                '</soap:Envelope>';
    
            // Initialize cURL session
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://www.pagec.ma/API/GetAllArticle.asmx");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: text/xml; charset=utf-8',
                'Content-Length: ' . strlen($xmlPayload),
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlPayload);
    
            $response = curl_exec($ch);
    
            if (curl_errno($ch)) {
                return response()->json(['error' => curl_error($ch)], 500);
            }
    
            curl_close($ch);
    
            if (empty($response)) {
                return response()->json(['error' => 'Empty response received from the SOAP API'], 500);
            }
    
            try {
                // Parse and clean up the XML response
                $response = str_replace(['soap:', 'm:', 'diffgr:', 'msdata:'], '', $response);
                $xmlObject = new \SimpleXMLElement($response, LIBXML_NOERROR | LIBXML_ERR_NONE);
                $articles = $xmlObject->Body->GetAllArticle1Response->GetAllArticle1Result->diffgram->DataSet->Table;
                $articleArray = [];
    
                foreach ($articles as $article) {
                    $articleArray[] = [
                        'IdArticle' => (int) $article->IdArticle,
                        'RefArticle' => (string) $article->RefArticle,
                        'Designation' => (string) $article->Designation,
                        'DesignationAr' => (string) $article->DesignationAr,
                        'LibelleFamArticle' => (string) $article->LibelleFamArticle,
                        'NomMarque' => (string) $article->NomMarque,
                        'PrixVenteArticleHT' => (float) $article->PrixVenteArticleHT,
                        'urlImage' => (string) $article->urlImage,
                    ];
                }
    
                // Cache all articles for 60 minutes
                Cache::put($cacheAllDataKey, $articleArray, 60);
    
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('XML Parsing Error: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to parse XML: ' . $e->getMessage()], 500);
            }
        }
    
        // Paginate backend data (30 articles per page)
        $totalArticles = count($articleArray);
        $offset = ($page - 1) * $perPage;
        $paginatedArticles = array_slice($articleArray, $offset, $perPage);
    
        // Prepare pagination metadata
        $paginationData = [
            'current_page' => (int) $page,
            'per_page' => (int) $perPage,
            'total' => $totalArticles,
            'last_page' => ceil($totalArticles / $perPage),
            'data' => $paginatedArticles,
            'alldata' => $articleArray,
        ];
    
        // Cache the paginated result for 60 minutes
        Cache::put($cacheKey, $paginationData, 1);
    
        return response()->json($paginationData);
    }
    
    
    public function getInfoArticle($refArticle){
        $xmlPayload = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">' .
        '<soap:Body>' .
        '<GetInfoArticle1 xmlns="http://tempuri.org/">' .
        '<RefArticle>' . $refArticle . '</RefArticle>' .
        '</GetInfoArticle1>' .
        '</soap:Body>' .
        '</soap:Envelope>';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.pagec.ma/API/GetInfoArticle.asmx");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: text/xml; charset=utf-8',
            'Content-Length: ' . strlen($xmlPayload),
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlPayload);
        $response = curl_exec($ch);
            if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }
        curl_close($ch);
        \Illuminate\Support\Facades\Log::info('SOAP Response: ' . $response);
    
        if (empty($response)) {
            return response()->json(['error' => 'Empty response received from the SOAP API'], 500);
        }
        try {
            $cleanedResponse = str_replace(['soap:', 'm:', 'diffgr:', 'msdata:'], '', $response);
                $xmlObject = new \SimpleXMLElement($cleanedResponse, LIBXML_NOERROR | LIBXML_ERR_NONE);
                $articleInfo = $xmlObject->Body->GetInfoArticle1Response->GetInfoArticle1Result->diffgram->DataSet->Table;
                $articleData = [
                'RefArticle' => (string) $articleInfo->RefArticle,
                "Designation"=>(string) $articleInfo->Designation,
                "urlImage"=>(string) $articleInfo->urlImage,
                "MontantHTBrut"=>(float) $articleInfo->MontantHTBrut,
                "MontantNetHT"=>(float) $articleInfo->MontantNetHT,
                "MontantRemise"=>(float) $articleInfo->MontantRemise,
                "PrixNetHT"=>(float) $articleInfo->PrixNetHT,
                "PrixHT"=>(float) $articleInfo->PrixHT,
                'QteQtock' => (float) $articleInfo->QteQtock,
                'Remise' => (float) $articleInfo->Remise,
                'TauxRemise' => (float) $articleInfo->TauxRemise,
                'Qte' => (float) $articleInfo->Qte,
            ];
                return response()->json($articleData);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('XML Parsing Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to parse XML: ' . $e->getMessage()], 500);
        }
    }
    public function getPhotoArticle($articleId){
        $url = 'http://www.pagec.ma/API/GetPhotoArticle.asmx';
        $xmlRequest = '<?xml version="1.0" encoding="utf-8"?>' .
            '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">' .
            '<soap:Body>' .
            '<GetPhotoArticle1 xmlns="http://tempuri.org/">' .
            '<IdArticle>' . $articleId . '</IdArticle>' .
            '</GetPhotoArticle1>' .
            '</soap:Body>' .
            '</soap:Envelope>';
        // Set up cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: text/xml; charset=utf-8",
            "Content-Length: " . strlen($xmlRequest)
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
        // Send the request and get the response
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            \Illuminate\Support\Facades\Log::error('cURL Error: ' . curl_error($ch));
            return 'cURL Error: ' . curl_error($ch);
        }

        curl_close($ch);
        \Illuminate\Support\Facades\Log::info('Raw API Response: ' . $response);
        return response($response);  // This will help you see if you are getting an error or malformed response
        $response = trim($response);

        // Parse the XML response
        $xml = simplexml_load_string($response);
        if (!$xml) {
            \Illuminate\Support\Facades\Log::error('Failed to parse XML: ' . $response);
            return 'Failed to parse XML';
        }
        $result = $xml->children($namespaces['soap'])->Body
            ->children($namespaces[''])->GetPhotoArticle1Response
            ->GetPhotoArticle1Result->children('http://tempuri.org/')
            ->Table->Image;
        if (!$result) {
            \Illuminate\Support\Facades\Log::error('No image data found');
            return 'No image data found';
        }
        $imageData = base64_decode((string)$result);
        if (!$imageData) {
            \Illuminate\Support\Facades\Log::error('Failed to decode image data');
            return 'Failed to decode image data';
        }

        return response($imageData)
            ->header('Content-Type', 'image/jpeg');
    }
public function enregistrerCommande(Request $request)
{
    $TotalHT = $request->TotalHT;
    $Remarque = $request->Remarque;
    $xmlPayload = '<?xml version="1.0" encoding="utf-8"?>' .
    '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">' .
    '<soap:Body>' .
    '<EnregistrerCommande1 xmlns="http://tempuri.org/">' .
    '<NomClient></NomClient>' .
    '<TotalHT>' . $TotalHT . '</TotalHT>' .
    '<TotalTTC></TotalTTC>' .
    '<TotalRemise></TotalRemise>' .
    '<Ville></Ville>' .
    '<Adresse></Adresse>' .
    '<Remarque>' . $Remarque . '</Remarque>' .
    '</EnregistrerCommande1>' .
    '</soap:Body>' .
    '</soap:Envelope>';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.pagec.ma/API/EnregistrerCommande.asmx");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: text/xml; charset=utf-8',
        'Content-Length: ' . strlen($xmlPayload),
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlPayload);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return response()->json(['error' => curl_error($ch)], 500);
    }
    curl_close($ch);

    \Illuminate\Support\Facades\Log::info('Raw SOAP Response: ' . $response);

    if (empty($response)) {
        return response()->json(['error' => 'Empty response received from the SOAP API'], 500);
    }

    try {
        $response = str_replace(['soap:', 'm:', 'diffgr:', 'msdata:'], '', $response);
        $xmlObject = new \SimpleXMLElement($response, LIBXML_NOERROR | LIBXML_ERR_NONE);
        $result = $xmlObject->Body->EnregistrerCommande1Response->EnregistrerCommande1Result;

        // Return the result (IdBL) to be used in sendArticleCommande
        return (string)$result;
        return response()->json($result, 200);

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('XML Parsing Error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to parse XML: ' . $e->getMessage()], 500);
    }
}

public function sendArticleCommande($idBL, Request $request)
{
    // Dynamic XML Payload
    $IdArticle = $request->IdArticle ;
    $dataTable = $request->input('DataTable');
    if (is_array($dataTable)) {
        foreach ($dataTable as $detaile) {
        $xmlPayload  = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">' .
        '<soap:Body>' .
        '<EnregistrerArticleCommande1 xmlns="http://tempuri.org/">' .
        '<IdBL>' . $idBL . '</IdBL>' .
        '<IdArticle>' . $detaile['IdArticle'] . '</IdArticle>' .
        '<Qte>' . $detaile['quantity'] . '</Qte>' .
        '<Prix>' . $detaile['prix'] . '</Prix>' .
        '<PrixTTC></PrixTTC>' .
        '<TauxTVA></TauxTVA>' .
        '<Designation>' . $detaile['designation'] . '</Designation>' .
        '<Index></Index>' .
        '<TauxRemise>' . $detaile['TauxRemise'] . '</TauxRemise>' .
        '<Remise>' . $detaile['Remise'] . '</Remise>' .
        '<MontantRemise>' . $detaile['MontantRemise'] . '</MontantRemise>' .
        '<TypePrix></TypePrix>' .
        '</EnregistrerArticleCommande1>' .
        '</soap:Body>' .
        '</soap:Envelope>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.pagec.ma/API/EnregistrerArticleCommande.asmx");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: text/xml; charset=utf-8',
            'Content-Length: ' . strlen($xmlPayload),
            'SOAPAction: "http://tempuri.org/EnregistrerArticleCommande1"'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlPayload);
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }
        curl_close($ch);
    
        \Illuminate\Support\Facades\Log::info('Raw SOAP Response: ' . $response);
    
        if (empty($response)) {
            return response()->json(['error' => 'Empty response received from the SOAP API'], 500);
        }
    
        try {
            $response = str_replace(['soap:', 'm:', 'diffgr:', 'msdata:'], '', $response);
            $xmlObject = new \SimpleXMLElement($response, LIBXML_NOERROR | LIBXML_ERR_NONE);
            $result = $xmlObject->Body->EnregistrerArticleCommande1Response->EnregistrerArticleCommande1Result;
            $resultArray = [
                'status' => "en coure",
                'message' => "bien envoyer",
            ];
    
            return response()->json($resultArray);
    
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('XML Parsing Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to parse XML: ' . $e->getMessage()], 500);
        }
    }
}

   
}

public function processCommande(Request $request)
{
    // Call enregistrerCommande and get IdBL
    $idBL = $this->enregistrerCommande($request);

    if (!$idBL) {
        return response()->json(['error' => 'Failed to create command.'], 500);
    }

    // Pass the IdBL and request data to sendArticleCommande
    return $this->sendArticleCommande($idBL, $request);
}
    
// ------------ active magasin ---------------
    public function GetMagasin(){ 
        $magasins = Magasin::where('NomMagasin', '!=', 'PAGEC')->get();
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

        if ($request->hasFile('image')) {
            $ImageMagasin = $request->file('image')->store('MagasinIMG', 'public');
        } else {
            $ImageMagasin ="";
        }
        $NameMagasin = $request->NomMagasin;
        $AdressMagasin = $request->Adresse;
        $EmailMagasin = $request->email;
        $TeleMagasin = $request->Tele;
        $Nom_complet_propriétaire=$request->Nom_complet_propriétaire;

                $databaseName = "merch_sentry_magasin_" . $NameMagasin;
    $this->createDatabase($databaseName);
    $this->createTables($databaseName,$EmailMagasin,$NameMagasin ,$Nom_complet_propriétaire,$AdressMagasin);
    $ACCOUNT = Utilisateur_Account::where('email', $EmailMagasin)->first();

            Magasin::create([
                'IdMagasin'=>$ACCOUNT->id,
                'email'=>$EmailMagasin,
                'NomMagasin'=>$NameMagasin,
                'ImageEP'=>$ImageMagasin,
                'Adresse'=>$AdressMagasin,
                'Tele'=>$TeleMagasin,
                'Fax'=>" ",
                'IdDepot'=>1,
                'IdVille'=>4,
                'Supprime'=>false,
            ]);

    if ($ACCOUNT) {
        $passwordMagasin = $ACCOUNT->password;
    
        $ACCOUNT->notify(new ActiveMagasinNotification(
            $EmailMagasin,
            $NameMagasin,
            $Nom_complet_propriétaire,
            $AdressMagasin,
            $passwordMagasin
        ));
    }
    
    return response()->json("ajouter avec succese", 200);
}

protected function createDatabase($databaseName)
{
    // Create the database
    DB::statement("CREATE DATABASE IF NOT EXISTS `$databaseName`");
}

protected function createTables($databaseName ,$EmailMagasin ,$NameMagasin ,$Nom_complet_propriétaire,$AdressMagasin)
{
    // Change the default connection to the new database
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

    // Clear the connection cache and reconnect
    DB::purge('dynamic_mysql');
    DB::reconnect('dynamic_mysql');

    // Create tables in the new database
    Schema::connection('dynamic_mysql')->create('magasins', function (Blueprint $table) {
        $table->id();
            $table->string('NomMagasin');
            $table->string('Nom_complet_propriétaire');
            $table->string('email');
            $table->string('password');
            $table->string('status');
            $table->string('adresse de siège');
            $table->string('rc');
            $table->string('patente');
            $table->string('ice');
            $table->timestamps();
    });

    // Repeat the Schema::create() calls for other tables

    Schema::connection('dynamic_mysql')->create('commercials', function (Blueprint $table) {
        $table->id();
            $table->string('Nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('password');
            $table->string('IdMagasin');
            $table->string('télephone');
            $table->string('cin');
            $table->string('credit');
            $table->string('vente');
            $table->string('annulé');
            $table->string('remboursé');
            $table->string('ville');
            $table->timestamps();
    });

    Schema::connection('dynamic_mysql')->create('clients', function (Blueprint $table) {
        $table->id('IdClient');
        $table->integer('IdFamilleClient');
        $table->integer('RefClt');
        $table->string('NomClient');
        $table->string('PrenomClient');
        $table->string('Description');
        $table->string('NumTele');
        $table->string('NumFax');
        $table->string('EmailClient');
        $table->string('PasswordClient');
        $table->string('SiteWebClient');
        $table->string('ContactClient');
        $table->string('Adresse');
        $table->DATETIME('DateCreation');
        $table->DATETIME('DateModification');
        $table->string('Supprime');
        $table->string('isBloque');
        $table->integer('AddresseFacturation');
        $table->integer('Banque');
        $table->integer('Agence');
        $table->integer('Compte');
        $table->integer('Debit');
        $table->string('Credit');
        $table->string('SoldeMaximum');
        $table->string('Ville');
        $table->string('Progstring');
        $table->integer('NumClient');
        $table->integer('IdRepresentant');
        $table->string('AssuranceGarantie');
        $table->string('Patente');
        $table->string('I_F');
        $table->integer('IdDevise');
        $table->string('IsSousClient');
        $table->integer('IdSecteur');
        $table->integer('IdVille');
        $table->integer('IdTypePrix');
        $table->string('IsEnCompte');
        $table->string('IsRemiseGlobale');
        $table->string('RemiseGlobale');
        $table->string('NbrCopieFacture');
        $table->string('NbrCopieBL');
        $table->string('CodeComptableClient');
        $table->string('IsProspect');
        $table->string('ICE');
        $table->integer('IdTypeReglement');
        $table->string('PrintRemarque');
        $table->timestamps();
        // Define the columns for the 'clients' table
    });

    Schema::connection('dynamic_mysql')->create('commandes', function (Blueprint $table) {
        $table->id('IdCommande');
        $table->integer('IdDevis');
        $table->integer('IdClient');
        $table->string('RefCommande');
        $table->integer('NumCommande');
        $table->DATETIME('DateCreation');
        $table->DATETIME('DateModification');
        $table->DATETIME('DateCommande');
        $table->integer('Remarque');
        $table->integer('Supprime')->default(0);
        $table->integer('IdMagasin');
        $table->integer('IdUser');
        $table->integer('IdExercice');
        $table->integer('IsReported');
        $table->string('Ville')->nullable();
        $table->string('Adresse');
        $table->string('TotalCommandeHT');
        $table->string('TotalCommandeTTC');
        $table->string('IdRepresentant');
        $table->string('NbreLines');
        $table->string('EsCompte');
        $table->string('MontantAvecEsCompte');
        $table->string('RefCommandeClient');
        $table->integer('IdSousClient');
        $table->integer('IdExpediteur');
        $table->integer('TotalRemise');
        $table->integer('IdModeReglement');
        $table->string('RemiseGlobale');
        $table->integer('RemiseSur');
        $table->string('TypeRemise');
        $table->string('NomClient');
    });

    Schema::connection('dynamic_mysql')->create('historique_commande_commercials', function (Blueprint $table) {
        $table->id();
            $table->timestamps();
    });

    Schema::connection('dynamic_mysql')->create('historique_commande_clients', function (Blueprint $table) {
        $table->id('id');
            $table->integer('IdClient');
            $table->string('NomClient');
            $table->string('Adresse');
            $table->decimal('Total');
            $table->string('Statut');
            $table->timestamp('Date');
    });

    Schema::connection('dynamic_mysql')->create('detail_commande_commercials', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('IdCommande');
        $table->string('RefArticle');
        $table->string('NomArticle');
        $table->integer('quantity');
        $table->string('Statut')->default('en coure...');
        $table->decimal('prix', 10, 2);
        $table->foreign('IdCommande')->references('id')->on('historique_commande_commercials')->onDelete('cascade');
    });

    Schema::connection('dynamic_mysql')->create('detail_commande_clients', function (Blueprint $table) {
        $table->id();
            $table->unsignedBigInteger('IdCommande');
            $table->string('RefArticle');
            $table->string('NomArticle');
            $table->integer('quantity');
            $table->string('Statut')->default('en coure...');
            $table->decimal('prix', 10, 2);
            $table->foreign('IdCommande')->references('id')->on('historique_commande_clients')->onDelete('cascade');    
    });

    Schema::connection('dynamic_mysql')->create('role', function (Blueprint $table) {
        $table->id('id');
            $table->string('NomRole');
    });

    Schema::connection('dynamic_mysql')->create('notifications', function (Blueprint $table) {
        $table->id('id');
            $table->string('IdRole');
            $table->string('Notification_Title');
            $table->string('Notification_Content');
            $table->string('Statut')->default('not readable');
            $table->timestamp('Date');
    });

    Schema::connection('dynamic_mysql')->create('stocks', function (Blueprint $table) {
        $table->id('idStock');
            $table->integer('IdArticle');
            $table->integer('prix_ht_1_magasin');
            $table->integer('prix_ht_2_magasin');
            $table->integer('prix_ht_3_magasin');
            $table->integer('prix_ttc_magasin');
            $table->string('quantité')->default(0);
        // Define the columns for the 'stock' table
    });

    $insertedAccountId = DB::table('utilisateur__accounts')->insertGetId([
        'email' => $EmailMagasin,
        'password' => "aaa",
        'database_name' => $databaseName,
        'Account_type' => "magasins",
    ]);
    DB::connection('dynamic_mysql')->table('magasins')->insert([
        'id' => $insertedAccountId,
        'NomMagasin' => $NameMagasin,
        'Nom_complet_propriétaire' => $Nom_complet_propriétaire,
        'email' => $EmailMagasin,
        'password' => "aaa",
        'status' => "active",
        'adresse de siège' => $AdressMagasin,
        'rc' => 0,
        'patente' => 0,
        'ice' => 0,

    ]);
}

// --------------create function magasin en ligne -----------------
public function AddMagasinEnligne(Request $request){
    $request->validate([
        'nom'=>'required',
        'email'=>'required',
        'password'=>'required',
        'adress'=>'required',
        'NomMagasin'=>'required',
    ]);
    $nom = $request->nom;
    $email = $request->email;
    $password = $request->password;
    $adress = $request->adress;
    $tele = $request->tele;
    $NomMagasin = $request->NomMagasin;
    $lat=$request->latitude;
    $long=$request->longitude;


    demande::create([
        'nom'=>$nom,
        'email'=>$email,
        'password'=>$password,
        'adress'=>$adress,
        'tele'=>$tele,
        'NomMagasin'=>$NomMagasin,
        'type'=>"demande magasin",
        "latitude"=>$lat,
        "longitude"=>$long,
    ]);

    $user = Utilisateur_Account::where('email', 'mcat92664@gmail.com')->first();
    $user->notify(new RegisterNotification());
    return response()->json("demande ajouté avec succès", 200);

}
// ----------------------------------------------------------------
// -----------------------Active Magasin -------------------------
public function activemagasin(Request $request,$id){
    $active = "active";
    DB::update('update demandes set status = ? where id = ?', [$active, $id]);
    $email = demande::where('id', $id)->first();
    $passwordMagasin=$email->password;
    $NameMagasin = $email->NomMagasin;
    $AdressMagasin = $email->adress;    
    $EmailMagasin = $email->email;
    $FaxMagasin = "";
    $TeleMagasin = $email->tele;
    $Nom_complet_propriétaire=$email->nom;
        Magasin::create([
            'email'=>$EmailMagasin,
            'NomMagasin'=>$NameMagasin,
            'ImageEP'=>"",
            'Adresse'=>$AdressMagasin,
            'Tele'=>$TeleMagasin,
            'Fax'=>$FaxMagasin,
            'IdDepot'=>1,
            'IdVille'=>4,
            'Supprime'=>false,

        ]);
    $databaseName = "merch_sentry_magasin_" . $NameMagasin;
    $this->createDatabase($databaseName);

    // Create tables in the new database
    $this->createTables($databaseName,$EmailMagasin,$NameMagasin ,$Nom_complet_propriétaire,$AdressMagasin);

    // return response()->json(['message' => 'Magasin added successfully and database created'], 200);
        $email->notify(new ActiveMagasinNotification($EmailMagasin, 
        $NameMagasin, 
        $Nom_complet_propriétaire, 
        $AdressMagasin,$passwordMagasin));
        DB::delete('delete from demandes where id = ?', [$id]);
        return response()->json("votre magasin activé avec succès", 200);

    
}
// ------------------------delete magasin ---------------------------
public function DeleteDemande($id){
    // return response()->json($id, 200);
    DB::delete('delete from demandes where id = ?', [$id]);
    return response()->json("le magasin a éte supprimer avec succés", 200);
}
// ----------------------------------------------------------------
    public function EditMagasin($id){ 
        dd($id);
    }
    public function DeleteMagasin($id){ 
        dd($id);
    }
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
    public function GetArticleMagasinById($refArticle,$prix){
        // Fetching data from the stocks table
        $xmlPayload = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
          <soap:Body>
            <GetInfoArticle1 xmlns="http://tempuri.org/">
              <RefArticle>{$refArticle}</RefArticle>
            </GetInfoArticle1>
          </soap:Body>
        </soap:Envelope>
        XML;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.pagec.ma/API/GetInfoArticle.asmx");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: text/xml; charset=utf-8',
            'Content-Length: ' . strlen($xmlPayload),
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlPayload);
        $response = curl_exec($ch);
            if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }
        curl_close($ch);
        \Illuminate\Support\Facades\Log::info('SOAP Response: ' . $response);
    
        if (empty($response)) {
            return response()->json(['error' => 'Empty response received from the SOAP API'], 500);
        }
        try {
            $cleanedResponse = str_replace(['soap:', 'm:', 'diffgr:', 'msdata:'], '', $response);
                $xmlObject = new \SimpleXMLElement($cleanedResponse, LIBXML_NOERROR | LIBXML_ERR_NONE);
                $articleInfo = $xmlObject->Body->GetInfoArticle1Response->GetInfoArticle1Result->diffgram->DataSet->Table;
                $articleData = [
                'RefArticle' => (string) $articleInfo->RefArticle,
                "Designation"=>(string) $articleInfo->Designation,
                "urlImage"=>(string) $articleInfo->urlImage,
                "MontantHTBrut"=>(float) $articleInfo->MontantHTBrut,
                "MontantNetHT"=>(float) $articleInfo->MontantNetHT,
                "MontantRemise"=>(float) $articleInfo->MontantRemise,
                'QteQtock' => (float) $articleInfo->QteQtock,
                'Remise' => (float) $articleInfo->Remise,
                'TauxRemise' => (float) $articleInfo->TauxRemise,
                'Qte' => (float) $articleInfo->Qte,
            ];
                return response()->json($articleData);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('XML Parsing Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to parse XML: ' . $e->getMessage()], 500);
        }

}
public function AddCommercial(request $request , $id){
    $NomCommercial = $request->nom;
    $PrenomCommercial = $request->prenom;
    $telephone = $request->télephone;
    $IdMagasin = $id;
    $ville = $request->ville;
    $credit = $request->credit;
    $vente = $request->vente;
    $annulé = $request->annulé;
    $remboursé = $request->remboursé;

    // Determine the database connection dynamically
    $account = $this->getAccountBySomeLogic($id); // Your logic to determine the account and database

    if ($account) {
        // Set the dynamic database connection
        config(['database.connections.dynamic_mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => $account->database_name, // Use dynamic database name
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]]);

        // Clear the connection cache and reconnect
        DB::purge('dynamic_mysql');
        DB::reconnect('dynamic_mysql');

        // Perform the insert operation on the dynamic connection
        try {
            // Insert into utilisateur__accounts and get the inserted ID
            $insertedAccountId = DB::table('utilisateur__accounts')->insertGetId([
                'email' => $NomCommercial . "." . $PrenomCommercial . "@gmail.com",
                'password' => $PrenomCommercial . "1",
                'database_name' => $account->database_name,
                'Account_type' => "commercials",
            ]);

            // Insert into the commercials table using the dynamic connection
            DB::connection('dynamic_mysql')->table('commercials')->insert([
                'id' => $insertedAccountId,
                'nom' => $NomCommercial,
                'prenom' => $PrenomCommercial,
                'télephone' => $telephone,
                'ville' => $ville,
                'email' => $NomCommercial . "." . $PrenomCommercial . "@gmail.com",
                'password' => $PrenomCommercial . "1",
                'IdMagasin' => $IdMagasin,
                'credit' =>0,
                'vente' => 0,
                'annulé' => 0,
                'remboursé' => 0,
            ]);

            return response()->json('Commercial bien ajouté', 200);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the database operation
            return response()->json(['error' => 'Failed to add commercial: ' . $e->getMessage()], 500);
        }
    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
}


public function AddClient(request $request , $id){
        $NomClient = $request->NomClient;
        $PrenomClient = $request->PrenomClient;
        $CreditClient = $request->Credit;
        $IdMagasin = $id;
        $ville = $request->Ville;
        $NumTele = $request->NumTele;
        $ICE = $request->ICE;

        $account = $this->getAccountBySomeLogic($id); // Your logic to determine the account and database

    if ($account) {
        // Set the dynamic database connection
        config(['database.connections.dynamic_mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => $account->database_name, // Use dynamic database name
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]]);

        // Clear the connection cache and reconnect
        DB::purge('dynamic_mysql');
        DB::reconnect('dynamic_mysql');

        // Perform the insert operation on the dynamic connection
        try {
            // Insert into utilisateur__accounts and get the inserted ID
            $insertedAccountId = DB::table('utilisateur__accounts')->insertGetId([
                'email' => $NomClient.".".$PrenomClient."@gmail.com",
                'password' => $PrenomClient."2",
                'database_name' => $account->database_name,
                'Account_type' => "clients",
            ]);

            // Insert into the commercials table using the dynamic connection
            DB::connection('dynamic_mysql')->table('clients')->insert([
                'IdClient' => $insertedAccountId,
                "NomClient"=>$NomClient,
                "PrenomClient"=>$PrenomClient,
                "Credit"=>$CreditClient,
                "Ville"=>$ville,
                'IdMagasin' => $IdMagasin,
                "EmailClient"=>$NomClient.".".$PrenomClient."@gmail.com",
                "PasswordClient"=>$PrenomClient."2",
                "NumTele"=>$NumTele,
                "AddresseFacturation"=>"0",
                "SoldeMaximum"=>"0",
                "Patente"=>"0",
                "I_F"=>"0",
                "ICE"=>$ICE,
            ]);

            return response()->json('client bien ajouté', 200);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the database operation
            return response()->json(['error' => 'Failed to add client: ' . $e->getMessage()], 500);
        }
    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }


}
protected function getAccountBySomeLogic($IdMagasin)
{

    return DB::table('utilisateur__accounts')->where('id', $IdMagasin)->first();

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
public function databaseExists($databaseName)
{
    try {
        DB::connection()->getPdo()->exec("USE `{$databaseName}`");
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

public function Commande(Request $request)
{
    $NomClient = $request->NomClient;
    $Adresse = $request->Adresse;
    $TotalCommandeHT = $request->TotalCommandeHT;
    $TotalRemise = $request->TotalRemise;
    $detail = $request->detail;
    $Statut = $request->Statut;
    $IdMagasin = $request->IdMagasin;
    $NomMagasin = $request->NomMagasin;
    $IdClient = $request->IdClient;
    $DateCommande = $request->DateCommande;

    $commande = Commande::create([
        'NomClient' => $NomClient,
        'Adresse' => $Adresse,
        'IdMagasin' => $IdMagasin,
        'NomMagasin' => $NomMagasin,
        'IdClient' => $IdClient,
        'TotalCommandeHT' => $TotalCommandeHT,
        'DateCommande' => $DateCommande,
        'Statut' => $Statut,
    ]);

    foreach ($detail as $detaile) {
        DetailCommande::create([
            'idCommande' => $commande->id,
            'RefArticle' => $detaile['refArticle'],
            'NomArticle' => $detaile['designation'],
            'quantity' => $detaile['quantity'],
            'Statut' => $Statut,
            'prix' => $detaile['prix'],
        ]);
    }
            $link = url('http://localhost:3000/historiques/' .$commande->id);

// Create the notification with the link
        NotificationAdmin::create([
            'Notification_Title' => 'Nouvelle commande',
            'Notification_Content' => 'Une nouvelle commande a été ajoutée par ' . $NomMagasin ,
            'url' =>$link,
        ]);



    $account = DB::table('utilisateur__accounts')->where('id', $IdMagasin)->first();

    if ($account && $this->databaseExists($account->database_name)) {
        // Set the dynamic database connection
        Config::set('database.connections.dynamic_mysql', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $account->database_name,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Connect to the dynamic database
        DB::purge('dynamic_mysql');
        DB::reconnect('dynamic_mysql');

        DB::connection('dynamic_mysql')->table('commandes')->insert([
            'NomClient' => $NomClient,
            'Adresse' => $Adresse,
            'IdMagasin' => $IdMagasin,
            'NomMagasin' => $NomMagasin,
            'IdClient' => $IdClient,
            'TotalCommandeHT' => $TotalCommandeHT,
            'DateCommande' => $DateCommande,
            'Statut' => $Statut,
        ]);
    }

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
    $account = Utilisateur_Account::where('id', $id)->first();
    $OldPassword = $request->password;
    $NewPassword = $request->NewPassword;
    
    if ($account) {
        // Set the dynamic database connection
        config(['database.connections.dynamic_mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => $account->database_name,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]]);
    
        // Connect to the dynamic database
        DB::purge('dynamic_mysql');
        DB::setDefaultConnection('dynamic_mysql');
    
        // Query the specific account from the dynamic magasins table
        $accountInDynamicDB = DB::connection('dynamic_mysql')
                                ->table('magasins')
                                ->where('id', $id)
                                ->first();
    
        if ($accountInDynamicDB && $OldPassword == $accountInDynamicDB->password) {
            // Switch back to the default connection for Utilisateur_Account update
            Utilisateur_Account::on('mysql')->where('id', $id)->update(['password' => $NewPassword]);
    
            // Update password in the dynamic database magasins table
            DB::connection('dynamic_mysql')->table('magasins')
                ->where('id', $id)
                ->update(['password' => $NewPassword]);
    
            return response()->json("Password updated successfully", 200);
        } else {
            return response()->json("Old password does not match", 400);
        }
    } else {
        return response()->json("Account not found", 404);
    }
    

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
public function GetNotificationMagasin($id){
    $account = Utilisateur_Account::where('id', $id)->first();
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
        $notifications = DB::connection('dynamic_mysql')->table('notification')->get();
            return response()->json($notifications);


    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
    return response()->json($account->database_name, 200);

}
public function GetNotificationMagasinNoRead($id){
    $account = Utilisateur_Account::where('id', $id)->first();
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
        $notifications = DB::connection('dynamic_mysql')->table('notification')->get();
            return response()->json($notifications);


    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
    return response()->json($account->database_name, 200);
}

public function GetCommercialInfo(Request $request){
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
        $commercials = DB::connection('dynamic_mysql')->table('commercials')->where('id', $id)->get();
            return response()->json($commercials);


    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
}
public function GetClientInfo(Request $request){
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
        $commercials = DB::connection('dynamic_mysql')->table('clients')->where('IdClient', $id)->get();
            return response()->json($commercials);


    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
}
public function GetArticlesInInfo(Request $request){
    
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
        $stocks = DB::connection('dynamic_mysql')->table('stocks')->get();
        
            return response()->json($stocks);


    } else {
        return response()->json(['error' => 'no'], 404);
    }
}
public function getArticleUtilisateur($id){
    $articles=DB::select('select * from articles where IdArticle =?', [$id]);
    foreach($articles as $article)
    return response()->json($article,200);
}

// --------------------- new ----------------------- 
public function FilterByPrice(Request $request){
    $min=$request->min;
    $max=$request->max;
    $articles=DB::select('select * from articles where PrixVenteArticleHT between ? and ? ', [$min,$max]);
    return response()->json($articles,200);
}
public function FilterByDate(Request $request){
    $date = $request->date;
    $articles = Article::query();
    switch ($date) {
        case 'Ce jour':
            $articles->whereDate('DateCreation', Carbon::today());
            break;
        case 'Cette semaine':
            $articles->whereBetween('DateCreation', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            break;
        case 'Ce mois':
            $articles->whereBetween('DateCreation', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            break;
        case 'Cette année':
            $articles->whereYear('DateCreation', Carbon::now()->year);
            break;
    }
    $filter=$articles->get();
    return response()->json($filter, 200);
}

public function ModifierMagasin(Request $request, $id) {
    $nom = $request->nommagasins;
    $nom_proprietaire = $request->nom_proprietaire;
    $email = $request->email;
    $password = $request->password;
    $localisation = $request->localisation;
    // Fetch the user account details
    $account = Utilisateur_Account::where('id', $id)->first();
    DB::update('update utilisateur__accounts set email = ?, password = ? where id = ?', 
        [$email ?? $account->email, $password ?? $account->password, $id]);
        $nmagasins=DB::select('select NomMagasin from magasins where IdMagasin = ?',[$id]);
        foreach($nmagasins as $nmagasin){
            
    DB::update('update magasins set NomMagasin = ? where IdMagasin  = ?', 
        [$nom ?? $nmagasin->NomMagasin, $id]);
    }
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
    
        // Retrieve the specific magasin record
        $magasin = DB::connection('dynamic_mysql')->table('magasins')->where('id', $id)->first();
    
        if ($magasin) {
            // Update the magasin information with conditional logic
            DB::connection('dynamic_mysql')->table('magasins')
                ->where('id', $id)
                ->update([
                    'NomMagasin' => $nom ?? $magasin->NomMagasin,
                    'Nom_complet_propriétaire' => $nom_proprietaire ?? $magasin->Nom_complet_propriétaire,
                    'email' => $email ?? $magasin->email,
                    'password' => $password ?? $magasin->password,
                    'adresse de siège' => $localisation ?? $magasin->{'adresse de siège'},
                ]);

            return response()->json(['success' => 'Magasin updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Magasin not found'], 404);
        }
    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
}

public function ModifierClientInMagasin(Request $request, $idm , $id) {
    $nom = $request->NomClient;
    $prenom = $request->PrenomClient;
    $email = $nom . $prenom ."@gmail.com";
    $numero = $request->NumTele;
    $solde = $request->Credit;
    $ville = $request->Ville;
    $ice = $request->ICE;

    // Fetch the user account details
    $account = Utilisateur_Account::where('id', $id)->first();
    DB::update('update utilisateur__accounts set email = ? where id = ?', 
        [$email ?? $account->email, $id]);
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
        DB::setDefaultConnection('dynamic_mysql');
        $client = DB::connection('dynamic_mysql')->table('clients')->where('IdClient', $id)->first();
        if ($client) {
            DB::connection('dynamic_mysql')->table('clients')
                ->where('IdClient', $id)
                ->update([
                    'NomClient' => $nom ?? $client->NomClient,
                    'PrenomClient' => $prenom ?? $client->PrenomClient,
                    'EmailClient' => $email ?? $client->EmailClient,
                    'NumTele' => $numero ?? $client->NumTele,
                    'Ville' => $ville ?? $client->Ville,
                    'Credit' => $solde ?? $client->Credit,
                    'ICE' => $ice ?? $client->ICE,
                ]);

            return response()->json(['success' => 'client updated successfully'], 200);
        } else {
            return response()->json(['error' => 'client not found'], 404);
        }
    } else {
        return response()->json(['error' => 'Database not found or account does not exist'], 404);
    }
}
}


