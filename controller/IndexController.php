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



}



