<?php

function createUser($user_name,$password,$full_name,$role,$phone,$email,$photo_url){
		$database=new DatabaseConnect();		
		
		$stmt = $database->getConnection()->prepare("INSERT INTO users (user_name,password, full_name, role,phone,email,photo_url) VALUES (?,?, ?, ?,?,?,?)");
		$stmt->bind_param("sssssss", $user_name_par,$password_par,$full_name_par,$role_par,$phone_par,$email_par,$photo_url_par);
		
		$user_name_par=$user_name;
		$password_par=$password;
		$full_name_par=$full_name;
		$role_par=$role;
		$phone_par=$phone;
		$email_par=$email;
		$photo_url_par=$photo_url;
		
		$status=$stmt->execute();
		$newID=mysqli_insert_id($database->getConnection());
		$stmt->close();
		$database->close();
		
		if ($status) {
			return  $newID;
		} else {
			return 0;
		}
}
//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//
function getUserTitleByID($id_par){
	$database=new DatabaseConnect();
	
	$stmt = $database->getConnection()->prepare("SELECT title_name FROM titles WHERE id=(SELECT title_id from user_titles WHERE user_id=?)");
	$stmt->bind_param("i", $id_bind);
	
	$id_bind=$id_par;
	
    $stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($title_name_ret);

	$title=null;
	while($stmt->fetch()){
		$title= $title_name_ret;
	}
	
	$stmt->close();
	$database->close();
	
	return $title;
}
//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//
function getUserByID($id){
	$database=new DatabaseConnect();
	
	$stmt = $database->getConnection()->prepare("SELECT * FROM users WHERE id=?");
	$stmt->bind_param("i", $id_par);
	
	$id_par=$id;
	
    $stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id_ret, $user_name, $password,$full_name,$role,$phone,$email,$photo_url,$reg_date);

	$user_obj=new stdClass();
	while($stmt->fetch()){
		$user_obj->id= $id_ret;
		$user_obj->user_name= $user_name;
		$user_obj->password= $password;
		$user_obj->full_name= $full_name;
		$user_obj->role= $role;
		$user_obj->phone= $phone;
		$user_obj->email= $email;
		$user_obj->photo_url= $photo_url;
		$user_obj->reg_date= $reg_date;
	}
	$stmt->close();
	$database->close();
	
	return json_encode($user_obj);
}
//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//
function deleteUserByID($id){
	$database=new DatabaseConnect();
		$u=json_decode(getUserByID($id));
	if ($u->photo_url!=null)
		unlink($u->photo_url);
	$stmt = $database->getConnection()->prepare("DELETE FROM users WHERE id=?");
	$stmt->bind_param("i", $id_par);
	
	$id_par=$id;
    $stmt->execute();
	
	$stmt->close();
	$database->close();
	return true;
}
//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//
function updateUserByID($id,$user_name,$full_name,$role,$phone,$email,$photo_url){
		$database=new DatabaseConnect();
		
		$stmt = $database->getConnection()->prepare("UPDATE users SET user_name=?,full_name=?, role=?,phone=?,email=? ,photo_url=? WHERE id=?");
		$stmt->bind_param("ssssssi", $user_name,$full_name_par,$role_par,$phone_par,$email_par,$photo_url_par,$id_par);

		$id_par=$id;
		$user_name_par=$user_name;
		$full_name_par=$full_name;
		$role_par=$role;
		$phone_par=$phone;
		$email_par=$email;
		$photo_url_par=$photo_url;
		
		$stmt->execute() ;
		$stmt->close();
		$database->close();
}
//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//
function updatePassword($id,$password){
		$database=new DatabaseConnect();
		
		$stmt = $database->getConnection()->prepare("UPDATE users SET password=? WHERE id=?");
		$stmt->bind_param("si", $password_par,$id_par);

		$id_par=$id;
		$password_par=$password;
		
		$stmt->execute() ;
		$stmt->close();
		$database->close();
}
//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//
function getAllUsers($public=false){
	$database=new DatabaseConnect();
	if($public)
	$sql = "SELECT * FROM users WHERE activated=1 AND user_name!='nasable_user' AND user_name!='admin'";
	else
	$sql = "SELECT * FROM users";
	$result = $database->getConnection()->query($sql);

	$users_obj=new stdClass();
	//PUSH TOTAL USERS
	$users_obj->total=$result->num_rows;
	$users_array=array();
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$user_obj=new stdClass();

			$user_obj->email= $row["email"];

			$user_obj->twitter= $row["twiter"];
			$user_obj->linkedin= $row["linkedin"];

			$user_obj->full_name= $row["full_name"];
			$user_obj->about= $row["about"];
			$user_obj->title=getUserTitleByID($row["id"]);
		
			
			if(!$public){
			$user_obj->location= $row["location"];
			$user_obj->skills= $row["skills"];
			$user_obj->updated_at= $row["updated_at"];
			$user_obj->updated_at= $row["created_at"];
			$user_obj->facebook= $row["facebook"];
			$user_obj->activated= $row["activated"];
			$user_obj->user_id= $row["user_id"];
			$user_obj->user_name= $row["user_name"];
			$user_obj->phone= $row["phone"];
			$user_obj->skype= $row["skype"];
			$user_obj->id= $row["id"];
			$user_obj->photo=getUserPictureUrlById($row["id"]);
			}else{
				$user_obj->photo=CDN_LINK.basename(getUserPictureUrlById($row["id"]));
			}


	//add photo
			array_push($users_array,$user_obj);
		}
	} 
	$users_obj->users=$users_array;
	$database->close();
	return json_encode($users_obj);
}


?>