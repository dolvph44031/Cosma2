
<?php

class ProductModel extends db{


    function __construct()
    {
         
    }


    function products(){

        $sql = "SELECT * FROM products";

        $response = $this->getData($sql);

        return $response;

    }

    function categories(){

        $sql = "SELECT * FROM categories";

        $response = $this->getData($sql);

        return $response;

    }


    function product($id){

        $sql = "SELECT * FROM products WHERE id = '$id'";

        $response = $this->getData($sql, false);

        return $response;

    }

    // static function productStatic($id){

    //     $sql = "SELECT * FROM products WHERE id = '$id'";

    //     $response = $this->getData($sql, false);

    //     return $response;

    // }



}