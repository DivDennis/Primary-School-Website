<?php 

require_once dirname(__FILE__).'/../classes\Events.php'; 
require_once dirname(__FILE__).'/../common/DatabaseService.php'; 

class EventService 
{
    private $_count;
    private $_LIMIT;

    public function __construct(){
        $this->_LIMIT = 10;
    }

    public function getNumberOfPages(){
        return ceil($this->_count /$this->_LIMIT);
    }
    
    public function getCount(){
        $db = Database::getInstance();
        $result = $db->query('select count(*) as count from events');
        $this->_count = $result->fetch_assoc()['count'];
        return $this->_count;
    }

    public function getByLimit($page_num = 1, $limit = 10, $event_name = ''){
         global $_CONFIG;
        $db = Database::getInstance();
        $this->_LIMIT = $limit;         
        $this->getCount();
		$start = $this->_LIMIT * ($page_num-1);
	    $list = [];
	    $limitQuery = "{$start},{$limit}";
        $event_name = $db->escape_string($event_name);
	    $event_nameQuery = " event_name like '%{$event_name}%' ";

		if($results = $db->query("select * from events where {$event_nameQuery} order by id desc limit {$limitQuery}"))
		{
          
		    $i =0;
		    while($obj = $results->fetch_assoc()){
               $result = new Event();
               $result->setId($obj["id"]);
               $result->setEvent_Name($obj["event_name"]);
               $result->setDetails($obj["details"]);
               if(isset($obj["photo"])){
                      $result->setPath($_CONFIG["UPLOADS"].$obj["photo"]);
               }
               $result->setDate($obj["date"]);
               
                $list[$i] = $result;
                $i++;
            }
	    }
		 return $list;
    }

    public static function exist($value){
        
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM events WHERE event_name = ? and date = ?")){
            @$statement->bind_param("ss", $value->getEvent_Name(), $value->getEvent_Name());
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                   return true;
                }
            }
        }

        return false;
	}

    public static function findOne($id){
         global $_CONFIG;
        $result = null;
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM events WHERE id = ?")){
            @$statement->bind_param("i", $id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($obj = $rows->fetch_assoc()){
                    $result = new Event();
                    $result->setId($obj["id"]);
                    $result->setEvent_Name($obj["event_name"]);
                    $result->setDetails($obj["details"]);
                    if(isset($obj["photo"])){
                      $result->setPath($_CONFIG["UPLOADS"].$obj["photo"]);
                    }
                    $result->setDate($obj["date"]);
                }
	        }
	    }
        return $result;
	}

    public static function insert($obj, $file){
         global $_CONFIG;
         $newfilename = "";
         if( strcmp($file["name"], "") != 0){
            $temp = explode(".", $file["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            if (!@move_uploaded_file($file["tmp_name"], $_CONFIG["UPLOADS"].$newfilename)) {
                $result = false;
                
                return false;
            } 
            $str ="INSERT INTO events SET event_name = ?, details = ?,  date=?, photo =?";
            if( $statement = @Database::getInstance()->prepare($str)){
                @$statement->bind_param("ssss", $obj->getEvent_Name(),$obj->getDetails(), $obj->getDate(), $file["name"]);
                $statement->execute();
                return true;
            }
         }else{
             $str = "INSERT INTO events SET event_name = ?, details = ?,  date=?";
             if( $statement = @Database::getInstance()->prepare($str)){
                @$statement->bind_param("sss", $obj->getEvent_Name(),$obj->getDetails(), $obj->getDate());
                $statement->execute();
                return true;
            }
         }
        unlink($_CONFIG["UPLOADS"].$newfilename);

        return false;
	}

    public static function update($obj, $file){
        
         global $_CONFIG;
         
         if( strcmp($file["name"], "") != 0){
            $temp = explode(".", $file["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            if (!@move_uploaded_file($file["tmp_name"], $_CONFIG["UPLOADS"].$newfilename)) {
                $result = false;
                
                return false;
            } 
            $str ="UPDATE events SET event_name = ?, details = ?,  date=?, photo =? where id = ?";
            if( $statement = @Database::getInstance()->prepare($str)){
                @$statement->bind_param("ssssi", $obj->getEvent_Name(),$obj->getDetails(), $obj->getDate(), $file["name"], $obj->getId());
                if($statement->execute()){
                    return true;
                }
            }
         }else{
             $str = "UPDATE events SET event_name = ?, details = ?,  date=? where id = ?";
             if( $statement = @Database::getInstance()->prepare($str)){
                @$statement->bind_param("sssi", $obj->getEvent_Name(),$obj->getDetails(), $obj->getDate(),$obj->getId());
                if($statement->execute()){
                    return true;
                }
            }
         }
        return false;
	}

    public static function delete($id){
        global $_CONFIG;
        $paths = [];
        $i = 0;

        Database::getInstance()->autocommit (false);
        if( $statement = @Database::getInstance()->prepare("SELECT photo FROM events WHERE id = ?")){
            $statement->bind_param("i", $id);
            $statement->execute();

            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $path[i] = $row["photo"];
                    $i++;
                }
            }else{
                Database::getInstance()->rollback();
                return false;
            }

            if( $statement = @Database::getInstance()->prepare("DELETE  FROM events WHERE id = ?")){
                $statement->bind_param("i", $id);
                $statement->execute();
           
                    foreach($paths as $path){
                      unlink($_CONFIG["UPLOADS"].$path);
                    }
                     Database::getInstance()->commit();
                    return true;
            }
        }else{
             Database::getInstance()->rollback();
        }
      
        return false;
	}
}
?>