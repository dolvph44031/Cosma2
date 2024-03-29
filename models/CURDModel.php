<?php

class CURDModel extends db{

    static function Query($sql, $all = true){

        $model = new static;

        return $model->getData($sql, $all);

    }

    static function Create($table, $data){

        $model = new static;
        
        $keyStr = "";
        $keyIns = "";
    
        foreach ($data as $key => $value) {
            $keyStr .= $key.', ';
            $keyIns .= ':'.$key.', ';
        }
    
        $keyStr = trim($keyStr, ', ');
        $keyIns = trim($keyIns, ', ');
    
        $sql = "INSERT INTO `$table`($keyStr) VALUES ($keyIns)";

        return $model->runSql($sql, $data);

    }

    static function Update($table, $data, $condition=''){

        $model = new static;

        $keyUdt = "";

        foreach ($data as $key => $value) {
            $keyUdt .= $key.'=:'.$key.', ';
        }
    
        $keyUdt = trim($keyUdt, ', ');
    
        if(!empty($condition)){
            $sql = "UPDATE `$table` SET $keyUdt WHERE $condition";
        }else{
            $sql = "UPDATE `$table` SET $keyUdt";
        }
    
        return $model->runSql($sql, $data);

    }

    static function Delete($table, $condition=''){

        $model = new static;

        if(!empty($condition)){
            $sql = "DELETE FROM `$table` WHERE $condition";
        }else{
            $sql = "DELETE FROM `$table`";	
        }
        return $model->runSql($sql);

    }



}