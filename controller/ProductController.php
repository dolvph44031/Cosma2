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
    function comments(){

        if(empty($_SESSION['account']['permission'])) redirect();

        $comments = CURDModel::Query("SELECT c.*, u.fullname, p.name FROM comments AS c INNER JOIN users AS u ON c.user_id = u.id INNER JOIN products AS p ON c.pro_id=p.id");

        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('index-comment', 'admin', compact('comments'));

        layout('footer', 'admin');

    }

    function removeComment(){

        if(empty($_SESSION['account']['permission'])) redirect();

        $id = $_GET['id'];

        $comment = CURDModel::Query("SELECT * FROM comments WHERE id='$id'");

        if(empty($comment)) redirect('?url=comment-index');

        CURDModel::Delete('comments', "id='$id'");

        redirect('?url=comment-index');

    }

    function activeComment(){

        if(empty($_SESSION['account']['permission'])) redirect();

        $id = $_GET['id'];

        $comment = CURDModel::Query("SELECT * FROM comments WHERE id='$id'", false);

        if(empty($comment)) redirect('?url=comment-index');

        $status = 1;

        if($comment['status'] == 1){
            $status = 0;
        }else{
            $status = 1;
        }

        $data = [
            'status' => $status
        ];

        CURDModel::Update('comments', $data, "id='$id'");


        redirect('?url=comment-index');

    }
    function changeStatus(){

        if(empty($_SESSION['account']['permission'])) redirect();

        $id = $_GET['id'];

        $order = CURDModel::Query("SELECT * FROM orders WHERE id='$id'", false);

        $status = ++$order['status'];

        if($status > 4){
            $status = 0;
        }

        $data = [
            'status' => $status
        ];

        CURDModel::Update('orders', $data, "id='$id'");

        redirect("?url=order-index");

    }

    function changeThanhToan(){

            if(empty($_SESSION['account']['permission'])) redirect();

        $id = $_GET['id'];

        $order = CURDModel::Query("SELECT * FROM orders WHERE id='$id'", false);

        $thanhtoan = $order['thanhtoan'];

        if($thanhtoan == 1){
            $thanhtoan = 0;
        }else{
            $thanhtoan = 1;
        }

        $data = [
            'thanhtoan' => $thanhtoan
        ];

        CURDModel::Update('orders', $data, "id='$id'");

        redirect("?url=order-index");

    }


    function statistical(){

            if(empty($_SESSION['account']['permission'])) redirect();

        $va = 1;

        $categories = CURDModel::Query("SELECT * FROM categories");
        $products = CURDModel::Query("SELECT * FROM products");
        $users = CURDModel::Query("SELECT * FROM users");
        $orderDetail = CURDModel::Query("SELECT * FROM order_carts");
        
        $proCate = [];

        $proBuy = [];

        $proPrice = [];

        foreach ($categories as $key => $value) {
            $id = $value['id'];
            $proCate[] = [
                'cate' => $value,
                'count' => CURDModel::Query("SELECT COUNT(*) FROM products WHERE cate_id='$id'", false)[0]
            ];
        }

        foreach ($products as $key => $value) {

            $pro_id = $value['id'];
 
            $carts = CURDModel::Query("SELECT * FROM order_carts WHERE pro_id='$pro_id'");

            $count = 0;

            foreach ($carts as $key => $a) {
                $count += (int)($a['quantity']);
            }
            
            $proBuy[] = [
                'product' => $value,
                'count' => $count
            ];
        }

        foreach ($products as $key => $value) {
            
            $pro_id = $value['id'];
 
            $carts = CURDModel::Query("SELECT * FROM order_carts WHERE pro_id='$pro_id'");

            $price = 0;

            foreach ($carts as $key => $a) {
                $price += $a['quantity'] * $value['price'];
            }

            $proPrice[] = [
                'product' => $value,
                'price' => $price
            ];


        }

        


        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('statistical', 'admin', compact('va', 'proCate', 'proBuy', 'proPrice'));

        layout('footer', 'admin');

    }
    
}