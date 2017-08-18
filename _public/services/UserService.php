<?php 
require_once dirname(__FILE__).'/../common/DatabaseService.php'; 
require_once dirname(__FILE__).'/../classes/User.php'; 
	 
class UserService 
{
    public static function getUserSession(){
        return $_SESSION["user"];
    }

	public static function isLogin(){
        return isset($_SESSION["user"]);
    }

    public static function setUserSession($user){
        return $_SESSION["user"] = [
			"idnumber"=>$user->getIdnumber(),
			"password"=>$user->getPassword(),
			"salt"=>$user->getSalt(),];
    }
    
    public static function unsetUserSession(){
        unset($_SESSION["user"]);
    }

	public static function login($user)
	{
        $result = new User();
		$idnumber = $user->getIdnumber();
		if( $statement = @Database::getInstance()->prepare("select * from ps_users where idnumber = ?")){
			$statement->bind_param("s", $idnumber);
			$statement->execute();
		
			if($rows = $statement->get_result()){
				while($row = $rows->fetch_assoc()){
                   $result->setIdnumber($row["idnumber"]);
                   $result->setSalt($row["salt"]);
                   $result->setPassword($row["password"]);
				}
			}
		}
        return $result;
	} 

	public static function create($user){
        if( $statement = @Database::getInstance()->prepare("INSERT INTO ps_users SET idnumber = ?, password = ?, salt=?")){
			@$statement->bind_param("sss", $user->getIdnumber(), $user->getPassword(), $user->getSalt());
		
			if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                die();
            }
			if($rows = $statement->get_result()){
				return true;
			}
            return false;
		}else{
			echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
			die();
        }
	}

    public static function update($user){
        if( $statement = @Database::getInstance()->prepare("UPDATE ps_users SET password = ?, salt=? WHERE idnumber=?")){
			@$statement->bind_param("sss", $user->getPassword(), $user->getSalt(), $user->getIdnumber());
			if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                die();
				return false;
            }
			return true;
            
		}else{
			echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
			die();
        }
		return false;
	}

    
	
}
?>