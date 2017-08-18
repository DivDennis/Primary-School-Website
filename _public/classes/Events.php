<?php
class Event{
    private $_id;
    private $_path;
    private $_event_name;
    private $_date;
    private $_details;

    public function getId(){
        return $this->_id;
    }

    public function setId($id){
        $this->_id=$id;
    }

    public function getEvent_Name(){
        return $this->_event_name;
    }

    public function setEvent_Name($event_name){
        $this->_event_name = $event_name;
    }
    
    public function getPath(){
        return $this->_path;
    }

    public function setPath($path){
        $this->_path = $path;
    }
    public function getDetails(){
        return $this->_details;
    }

    public function setDetails($details){
        $this->_details = $details;
    }

    public function getDate(){
        return $this->_date;
    }

    public function setDate($date){
        $this->_date = $date;
    }

    
}