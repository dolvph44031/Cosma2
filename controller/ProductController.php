<?php


class ProductController extends ProductModel{



    public function index(){

        if(empty($_SESSION['account']['permission'])) redirect();

     

        $products = $this->products();

        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('index-product', 'admin', compact('products'));

        layout('footer', 'admin');

    }

    

    public function add(){

        if(empty($_SESSION['account']['permission'])) redirect();

     

        $categories = $this->categories();

        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('add-product', 'admin', compact(['categories']));

        layout('footer', 'admin');

    }


    public function edit($id){

        if(empty($_SESSION['account']['permission'])) redirect();


     

        $product = $this->product($id);

        $categories = $this->categories();

        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('edit-product', 'admin', compact(['categories', 'product']));

        layout('footer', 'admin');
    }

    function addpost(){

        if(empty($_SESSION['account']['permission'])) redirect();

     

        $request = $_POST;

        $name = $request['name'];
        $price = $request['price'];
        $description = $request['description'];
        $cate_id = $request['cate_id'];

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        echo $_FILES['image']['name'];

        if(empty($name) || empty($price) || empty($description) || empty($cate_id) || empty($_FILES['image']['name'])){


            setFlashData('msg', 'vui lòng điền đủ các trường');
            redirect('?url=product-add');

        }else{
            if(!preg_match('~^[0-9]+$~', $price)){
                setFlashData('msg', 'Giá là số dương');
                redirect('?url=product-add');
            }
        }

        if(!empty($_FILES['image']['name'])){
            $image = $_FILES['image'];
            $nameImage = time().'_'.$image['name'];
            $toFile =  _WEB_PATH_ROOT.'/public/image/'.$nameImage;          
            move_uploaded_file($image['tmp_name'], $toFile);
        }

        $sql = "INSERT INTO `products` (`name`, `price`, `description`, `cate_id`, `image`) VALUES ('$name', '$price', '$description', '$cate_id', '$nameImage')";

        $this->runSql($sql);

        setFlashData('msg', 'Thêm thành công');

        redirect('?url=product-index');


    }


    function editpost(){

        if(empty($_SESSION['account']['permission'])) redirect();

        $request = $_POST;

        $name = $request['name'];
        $price = $request['price'];
        $description = $request['description'];
        $cate_id = $request['cate_id'];
        $id = $request['id'];

        $setImg = '';

        if(empty($name) || empty($price) || empty($description) || empty($cate_id)){

            setFlashData('msg', 'vui lòng điền đủ các trường');
            redirect('?url=product-edit&id='.$id);

        }else{
            if(!preg_match('~^[0-9]+$~', $price)){
                setFlashData('msg', 'Giá là số dương');
                redirect('?url=product-edit&id='.$id);
            }
        }

        if(!empty($_FILES['image']['name'])){
            $image = $_FILES['image'];
            $nameImage = time().'_'.$image['name'];
            $toFile =  _WEB_PATH_ROOT.'/public/image/'.$nameImage;          
            move_uploaded_file($image['tmp_name'], $toFile);
            $setImg = ", `image`='$nameImage'";
        }

        $sql = "UPDATE  `products` SET `name`='$name', `price`='$price', `description`='$description', `cate_id`='$cate_id' $setImg WHERE id='$id'";

        // echo $sql;

        // die;

        $this->runSql($sql);

        setFlashData('msg', 'Sửa thành công');

        redirect('?url=product-index');


    }

    function delete($id){

        if(empty($_SESSION['account']['permission'])) redirect();

        $comments = CURDModel::Query("SELECT * FROM comments WHERE pro_id='$id'");
        $order_carts = CURDModel::Query("SELECT * FROM order_carts WHERE pro_id='$id'");

        if(!empty($comments) || !empty($order_carts)){
            setFlashData('msg', 'Không thể xóa sản phẩm vì có bình luận hoặc đã được mua');
            redirect('?url=product-index');
        }

        $sql = "DELETE FROM products WHERE id='$id'";

        $this->runSql($sql);
        setFlashData('msg', 'Đã xóa thành công');
        redirect('?url=product-index');

    }
    
}