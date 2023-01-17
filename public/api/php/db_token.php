<?php

function verifyToken($token_in){
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

	$tokenById=json_decode(getTokenById($id));

	//check if it acctually returns somthing otherwise return false

	if(empty($tokenById))
		return false;


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

function getTokenByToken($token){
    $database=new DatabaseConnect();

	$stmt = $database->getConnection()->prepare("SELECT * FROM api_tokens WHERE token =?");
	$stmt->bind_param("s", $token_par);

	$token_par =$token;

    $stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $platform, $salt,$secret_iv,$secret_key,$token_ret,$created_at,$updated_at,$type);

	$token_obj=new stdClass();
	while($stmt->fetch()){
		$token_obj->id= $id;
		$token_obj->platform= $platform;
		$token_obj->salt= $salt;
		$token_obj->secret_iv= $secret_iv;
		$token_obj->secret_key= $secret_key;
		$token_obj->token= $token_ret;

		$token_obj->created_at= $created_at;
		$token_obj->updated_at= $updated_at;
		$token_obj->type= $type;
	}

	$stmt->close();
	$database->close();

	return json_encode($token_obj);
}


//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//
function getTokenById($token_id){
	$database=new DatabaseConnect();
	
	$stmt = $database->getConnection()->prepare("SELECT * FROM api_tokens WHERE id =?");
	$stmt->bind_param("i", $token_par);
	
	$token_par =$token_id;
	
    $stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $platform, $salt,$secret_iv,$secret_key,$token_ret,$created_at,$updated_at,$type);

	$token_obj=new stdClass();
	while($stmt->fetch()){
		$token_obj->id= $id;
		$token_obj->platform= $platform;
		$token_obj->salt= $salt;
		$token_obj->secret_iv= $secret_iv;
		$token_obj->secret_key= $secret_key;
		$token_obj->token= $token_ret;

		$token_obj->created_at= $created_at;
		$token_obj->updated_at= $updated_at;
		$token_obj->type= $type;
	}
	
	$stmt->close();
	$database->close();
	
	return json_encode($token_obj);
}


?>