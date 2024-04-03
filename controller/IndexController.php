<?php


class IndexController extends IndexModel{

    public function home(){

        $categories = $this->categories();
        $products = $this->products();

    
        layout('header');
        layout('sidebar', 'client', compact('categories'));

        view('home', 'client', compact(['categories', 'products']));


        layout('footer');

    
    }

    public function detail($id){

        $categories = $this->categories();
        // $products = $this->products();
        $product = $this->product($id);

        if(empty($product)) redirect();

        $comments = CURDModel::Query("SELECT c.*, u.fullname FROM comments AS c INNER JOIN users AS u ON c.user_id = u.id WHERE c.pro_id='$id' AND c.status=1");

        layout('header');
        layout('sidebar', 'client', compact('categories'));

        view('detail', 'client', compact(['categories', 'product', 'comments']));


        layout('footer');

    
    }

    function login(){

        if(!empty($_SESSION['account'])) redirect();

        $categories = $this->categories();
       
        
        layout('header');
        layout('sidebar', 'client', compact('categories'));

        view('login', 'client');


        layout('footer');
        
    }

    function loginPost(){

        if(!empty($_SESSION['account'])) redirect();

        $responses = $_POST;

        $email = $responses['email'];
        $password = $responses['password'];

        $this->loginHandle($email, $password);


    }


    function forgot(){

        if(!empty($_SESSION['account'])) redirect();

        $categories = $this->categories();
        
        layout('header');
        layout('sidebar', 'client', compact('categories'));

        view('forgot', 'client');


        layout('footer');


    }



    function forgotPost(){

        if(!empty($_SESSION['account'])) redirect();

        $responses = $_POST;

        $email = $responses['email'];

        if(empty($email)){ setFlashData('msg', 'Vui lòng nhập mail'); redirect('?url=forgot'); }

        $user = $this->user($email);

        if(empty($user)){
            setFlashData('msg', 'Email không tồn tại trên hệ thống'); redirect('?url=forgot');
        }

        $content = '
        Mậu khẩu của bạn là: '.$user['password'].'
        ';

       $send = sendMail($email, "EMAIL NHẬP MẬT KHẨU ĐÃ QUÊN", $content);

       if($send){
    }
    setFlashData('msg', 'Chúng tôi đã gửi mail đến tài khoản của bạn');           
        redirect('?url=login');

    }


    function logout(){

        if(empty($_SESSION['account'])) redirect();

        unset($_SESSION['account']);

        setFlashData('msg', 'Đăng xuất thành công');     
        redirect('?url=login');

    }

    function productForCategory(){

        $id = $_GET['cate_id'];

        if(empty($id)) redirect();
        
        $products = CURDModel::Query("SELECT * FROM products WHERE cate_id='$id'");

        $categories = $this->categories();

        $category = CURDModel::Query("SELECT * FROM categories WHERE id='$id'", false);
        
        layout('header');
        layout('sidebar', 'client', compact('categories'));

        view('category', 'client', compact('products', 'category'));

        layout('footer');

    }

    function register(){

        $categories = $this->categories();
    
        layout('header');
        layout('sidebar', 'client', compact('categories'));

        view('register', 'client', compact(['categories']));


        layout('footer');


    }
    
    function registerPost(){
    
        if(empty($_POST['fullname']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm'])){

            setFlashData('msg', 'Vui lòng nhập đủ các trường');

        }else{

            if(!empty($this->user($_POST['email']))){
                setFlashData('msg', 'Email đã có người sử dụng');
            }else{

                if($_POST['password'] != $_POST['confirm']){
                    setFlashData('msg', 'Bạn đang xác nhận mật khẩu sai');
                }else{

                    $data = [
                        'fullname' => $_POST['fullname'],
                        'email' => $_POST['email'],
                        'password' => $_POST['password'],
                        'permission' => 0
                    ];

                    CURDModel::Create('users', $data);

                    setFlashData('msg', 'Bạn có thể bằng tài khoản vừa tạo');

                    redirect('?url=login');

                }

            }

        }

        redirect('?url=register');
        
    
    }
    
    function information(){

        $categories = $this->categories();
    
        layout('header');
        layout('sidebar', 'client', compact('categories'));

        layout('menuInfor', 'client', compact(['categories']));


        view('information', 'client', compact(['categories']));


        layout('footer');


    }

    function informationPost(){

        if(empty($_POST['fullname']) || empty($_POST['email'])){
            setFlashData('msg', 'Vui lòng điền đủ các trường');
        }else{

            $email = $_POST['email'];
            $id = $_SESSION['account']['id'];

            if(CURDModel::Query("SELECT * FROM users WHERE email='$email' AND id<>'$id'")){
                setFlashData('msg', 'Email đã có người dùng');
            }else{

                $data = [
                    'email' => $email,
                    'fullname' => $_POST['fullname']
                ];

                
                CURDModel::Update('users', $data, "id='$id'");
                
                $_SESSION['account'] = $this->user($email);

                setFlashData('Đã đổi thông tin thành công');
            }   

        }
        setFlashData('msg', 'Đã đổi thông tin thành công');     
        redirect('?url=information');
    }
    
    function pay(){

        $carts = $this->giohang(); 

        if(empty($carts)){
            redirect('?url=cart');
        }
    
        layout('header');


        view('pay', 'client', compact(['carts']));


        layout('footer');



    }

    function loadPay(){

        $validate = true;

        if(empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['type'])){
            setFlashData('msg', "Vui lòng điền đủ các trường Email, Số điện thoại, Địa chỉ, Phương thức thanh toán");
            $validate = false;
        }else{
            if(!preg_match('~^0[0-9]{9}$~', $_POST['phone'])){
                setFlashData('msg', "Số điện thoại sai định dạng");
                $validate = false;
            }
        }

        if(!$validate) redirect('?url=pay');

        $model = new static;

        $order = [
            'user_id' => $_SESSION['account']['id'],
            'code' => "#" . rand(0, 999),
            'fullname' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'type' => $_POST['type'],
            'total' => $_POST['total'],
            'created_at' => date("Y-m-d H:i:s")
        ];

        setFlashData('order', $order);

        if($_POST['type'] == 1){

            CURDModel::Create('orders', $order);

            $order_id = CURDModel::Query("SELECT id FROM orders ORDER BY id DESC LIMIT 1", false)['id'];

            $carts = $this->giohang(); 

            foreach ($carts as $key => $cr) {
                
                CURDModel::Create('order_carts', [
                    'order_id' => $order_id,
                    'pro_id' => $cr['id'],
                    'quantity' => $cr['quantity']
                ]);

            }

            removeSession('cart');

            setFlashData('thank', true);

            redirect("?url=thank");

        }else if($_POST['type'] == 2){

            $model->checkout($_POST['total']);

        }

    }

    function thank(){

        if(!getFlashData('thank')) redirect('?url=orders'); 

        echo '<img src="'._PATH_IMAGE."/banner.jpg".'" class="" width="100%"/>';

    }



}



