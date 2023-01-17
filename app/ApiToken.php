<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ApiToken extends Model
{

	protected $fillable=['platform','salt','secret_iv','secret_key','token','type'];

    public static function newToken($platform,$secret_key,$type){
	
	//generating an IV
	$salt  = bin2hex(openssl_random_pseudo_bytes(64));
	$secret_iv = substr(hash('sha256', $salt), 0, 16);
	
	$secret_key = hash('sha256', $secret_key);
	$encrypt_method = "AES-256-CBC";
	
	
	$token = openssl_encrypt($platform.$salt, $encrypt_method, $secret_key, 0, $secret_iv);
	
	// store in db ($platform,$salt,$secret_iv ,$secret_key,$token)
	$temp=ApiToken::create([
		'platform'=>$platform,
		'salt'=>$salt,
		'secret_iv'=>$secret_iv,
		'secret_key'=>$secret_key,
		'token'=>$token,
		'type'=>$type
	]);

	$token_id=$temp->id;
	//  when inserting get the new token id===>  $id 
	
	$token = base64_encode($token_id.'-'.$platform.'-'.$token);
	$temp->token=$token;
	$temp->save();
	return $token;
}

/*This is the one that we will use*/
public static function verifyToken($token_in){
	$encrypt_method = "AES-256-CBC";

	try {
	
	$token_in=base64_decode($token_in);
	
	$pieces = explode("-", $token_in);

	if(!isset($pieces[1]) || !isset($pieces[2]))
		return false;

	$id=$pieces[0];
	$platform_in=$pieces[1];
	$token_in=$pieces[2];

	// getTokenById($id)  ==> should return ==> $platform,$salt,$secret_iv ,$secret_key,$token
	$tokenById=ApiToken::find($id);

	//check if it acctually returns somthing otherwise return false
	if(empty($tokenById))
		return false;
	//check the time stamp
	//if(!ApiToken::refreshToken($tokenById->id))
		//return false;
	//get the platform,salt , and keys 
	$platform=$tokenById->platform;
	$salt=$tokenById->salt;
	$secret_key=$tokenById->secret_key;
	$secret_iv=$tokenById->secret_iv;

	$decrypted_token = openssl_decrypt($token_in, $encrypt_method, $secret_key, 0, $secret_iv);
	
	if($decrypted_token===$platform.$salt)
		return true;
	
	} catch (Exception $e) {
		return false;
	}
	
	return false;
}

//here we will see if the time stamp is lease than an hour
//if it is we will refresh it
//if not false will be returned
public static function refreshToken($id)
{	
	//get now time
	$now=Carbon::now();
	
	$token=ApiToken::find($id);
	//check if time diffrenece is greater than one hour
	$diffInHours=$token->updated_at->diffInHours($now);
	//it is not ,then update the time stamp
	if($diffInHours<1)
	{ 
		$token->updated_at=$now;
		$token->save();
		return true;
	}
	//it is ,cancle the process
	else
	{
		return false;
	}
}
}
