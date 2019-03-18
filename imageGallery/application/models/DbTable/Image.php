<?php


class Application_Model_DbTable_Image extends Zend_Db_Table_Abstract
{
    protected $_name = 'images';
    protected $_primary = 'id';

    public function create($data) {

        $dataTime = date("Y-m-d H:i:s");
        $data["dateTime"] = $dataTime;

        $this->insert($data);
        return true;
    }

    public function updateViews($imgID){
        $db = $this->getDbConfig();
        $db->query("UPDATE images SET views=views+1 where id='$imgID'");
    }

    public function updateDownloads($imgID){
        $db = $this->getDbConfig();
        $db->query("UPDATE images SET downloads=downloads+1 where id='$imgID'");
    }


    public function getDbConfig(){
        $dbHost = 'localhost';
        $dbUsername = 'root';
        $dbPassword = 'root';
        $dbName = 'image_gallery';
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        return $db;
    }




}

