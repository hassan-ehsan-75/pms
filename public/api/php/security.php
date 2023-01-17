<?php

require('includes.php');
$isPublicToken=false;


/* $response Always contains success: boolean */




if(isset($_GET['token'])){
    if(!verifyToken($_GET['token']))
        throwError('Authentication failed');

     $token=json_decode(getTokenByToken($_GET['token']));
     $isPublicToken=($token->type == 'public');

}else{
        throwError('Authentication token required');
}


function throwError($message){
    $response=new stdClass();
       $response->success=false;
       $response->message=$message;
       die(json_encode($response));
}

function putResponse($content){
     $response=new stdClass();
     $response->success=true;
     $response->response=$content;
     die(json_encode($response));
}

?>