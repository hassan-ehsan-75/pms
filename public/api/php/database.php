<?php 
/*----------------------------------------
*	Base database class..
* 	Handles connections
*	USE: @All php and api files with DB operation
*
* ----------------------------------------	
*/
//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//
/*   */
require ("configuration.php");
//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//

/*----------------------------------------
*	DatabaseConnect CLASS
* 	Creates and returns database connection.
* ----------------------------------------	
*/
class DatabaseConnect{
	
	var $conn;
	//---------------------------------------

    function __construct(){
		$this->conn=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die('Could not connect to MySQL server.');
		$this->conn->select_db(DB_DATABASE);
		if ($this->conn->connect_error) {
			echo "<br>Could not find the database" . $conn->connect_error."<br><i>Hint: <b>setup.php</b> first?</i>";
		} 
	}

	//---------------------------------------

    function close(){
		$this->conn->close();
	}

	//---------------------------------------

	function getConnection(){
		return $this->conn;
	}

		
}
//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//

?>