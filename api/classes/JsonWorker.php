<?php
/*
 * working with json file
*/

class JsonWorker
{
    private $fileConfig = "../../api/config/cofigFile.json";
    private $jsonFile;

    public function __construct()
    {
        $this->jsonFile = json_decode(file_get_contents($this->fileConfig, true), true)["jsonPath"];
    }

    public function readJson()
    {
        if(file_exists($this->jsonFile)){ 
            $jsonData = file_get_contents($this->jsonFile); 
            if (!$jsonData){
                throw new Exception("Cannot access '$jsonData' to read all Users.");
            }
            $data = json_decode($jsonData, true); 
            return $data; 
        }
    }

    public function putJson($user)
    {
        if(!empty($user)){              
            $jsonData = file_get_contents($this->jsonFile); 
            $dataRaw = json_decode($jsonData, true); 
             
            $data = !empty($dataRaw) ? array_filter($dataRaw):$dataRaw; 
            if(!empty($data)){ 
                array_push($data, $user); 
            }else{ 
                $data[] = $user; 
            } 
            $insert = file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT)); 
            if (!$insert){
                throw new Exception("User save error.");
            }
            return $insert; 
        }else{ 
            return false; 
        } 
    }
}
