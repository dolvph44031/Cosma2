<?php

class CategoryModel extends db{

    function categories(){

        $sql = "SELECT * FROM categories";

        $response = $this->getData($sql);

        return $response;

    }


    function category($id){

        $sql = "SELECT * FROM categories WHERE id = '$id'";

        $response = $this->getData($sql, false);

        return $response;

    }

}
