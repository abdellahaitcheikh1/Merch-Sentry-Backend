<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Authentication extends Controller
{
    public function login(Request $request){
        // $email=$request->CompteEmail;
        // $password=$request->Password;
        // $Account = ["CompteEmail"=>$email,"password"=>$Password];
        // if(Auth::attempt($Account)){
        //     dd("good");
        // }
        //     return back()->with('message',"Il n'y a pas de compte avec ces informations");



// TODO Utiliser jwt ou autre pour savoir quelle type utilisateur fait la requete 


        $email=$request->CompteEmail;
        $Password=$request->Password;
        $Accounts=DB::select('select * from utilisateurs where CompteEmail = ? and Password=?', [$email,$Password]);
        foreach($Accounts as $Account)
        if($Account->IDRole==1){
            return response()->json("superAdmin", 200);
            }elseif($Account->IDRole==3){
                $EmailMagasin=$Account->CompteEmail;
                $PasswordMagasin=$Account->Password;
                $AccountMagasins = DB::connection('mysql_second')->table('magasins')->select('*')
                    ->where('email', $EmailMagasin)
                    ->where('password', $PasswordMagasin)
                    ->get();
                foreach($AccountMagasins as $AccountMagasin)
                return response()->json(['message'=> 'magasin' ,"account"=>$AccountMagasin], 200);
            }
            elseif($Account->IDRole==2){
                $EmailCommercial=$Account->CompteEmail;
                $PasswordCommercial=$Account->Password;
                $AccountCommercials = DB::connection('mysql_second')->table('commercials')
                    ->select('*')
                    ->where('email', $email)
                    ->where('password', $Password)
                    ->get();
                    foreach($AccountCommercials as $AccountCommercial)
                return response()->json(['message'=> 'commercial' ,"account"=>$AccountCommercial], 200);
            }elseif($Account->IDRole==6){
                $EmailClient=$Account->CompteEmail;
                $PasswordClient=$Account->Password;
                $AccountClients = DB::connection('mysql_second')->table('clients')->select('*')
                    ->where('EmailClient', $EmailClient)
                    ->where('PasswordClient', $PasswordClient)
                    ->get();
                foreach($AccountClients as $AccountClient)
                return response()->json(['message'=> 'Client' ,"account"=>$AccountClient], 200);
            }
            else{
                return response()->json(['message'=>'no account have'], 200);

            }
            


    }
}
