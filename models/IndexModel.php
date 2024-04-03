<?php


class IndexModel extends db{


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


    function giohang(){

        if(!empty($_SESSION['cart'])){
            $cart = [];
            foreach ($_SESSION['cart'] as $key => $value) {
                $id = $value['id'];
                $sql = "SELECT * FROM products WHERE id = '$id'";
                $product = $this->getData($sql, false);
                $cart[$key] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => $value['quantity'],
                ];
            }
            return $cart;
        }

        return [];


    }

    function loginHandle($email, $password){

        $sql = "SELECT * FROM users WHERE email='$email' AND `password`='$password'";

        $user = $this->getData($sql, false);

        if(!empty($user)){

            $_SESSION['account'] = $user;

            redirect();

        }

        setFlashData('msg', 'Đã có lỗi từ email hoặc mật khẩu');

        if(empty($email) || empty($password)) setFlashData('msg', 'Vui lòng nhập đủ các trường');

        redirect('?url=login');


    }


    function user($email){

        $sql = "SELECT * FROM users WHERE email='$email'";
        
        $user = $this->getData($sql, false);
        
        return $user;

    }

}