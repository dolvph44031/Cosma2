<?php

class UserModel extends db{

    function users(){

        $sql = "SELECT * FROM users";

        $response = $this->getData($sql);

        return $response;

    }


    function user($id){

        $sql = "SELECT * FROM users WHERE id = '$id'";

        $response = $this->getData($sql, false);

        return $response;

    }

}