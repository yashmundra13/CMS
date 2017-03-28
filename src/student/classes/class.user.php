<?php

require_once 'dbconfig.php';

class USER
{	

	private $conn;
	/**	Constructor function for class**/
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	/**	Runs SQL queries**/
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	/** Retrieves ID of last inserted user **/
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	/**	Inserts the new user into the SQL databse.**/
	public function register($uname,$email,$upass,$code,$class)
	{
		try
		{							
			$password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode,class) 
			                                             VALUES(:user_name, :user_mail, :user_pass, :active_code, :class)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->bindparam(":class",$class);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	/**	Login Function: Checks if entered matches with database. If yes, then redirect to homepage.	**/ 
	public function login($email,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['userStatus']=="Y")
				{
					if($userRow['userPass']==md5($upass))
					{
						$_SESSION['userSession'] = $userRow['userID'];
						return true;
					}
					else
					{
						header("Location: index.php?error");
						exit();
					}
				}
				else
				{
					header("Location: index.php?inactive");
					exit();
				}	
			}
			else
			{
				header("Location: index.php?error");
				exit();
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	/**Checks if session is set with user id **/
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	/** Destroys session **/
	public function logout()
	{
		session_destroy();
		$_SESSION['userSession'] = false;
	}
	
	function send_mail($email,$message,$subject)
	{						
		
		mail($email,$subject,$message);
		
	}	
	public function redirect($url)
	{
		header("Location: $url");
	}

}