<?php

class User{
    private $_idnumber;
    private $_password;
    private $_salt;

    public function getIdnumber(){
        return $this->_idnumber;
    }

    public function setIdnumber($idnumber){
        $this->_idnumber=$idnumber;
    }

    public function getPassword(){
        return $this->_password;
    }

    public function setPassword($password){
        $this->_password = $password;
    }
    
    public function getSalt(){
        return $this->_salt;
    }

    public function setSalt($salt){
        $this->_salt = $salt;
    }

}
?>