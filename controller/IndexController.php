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
    function createComment(){

        $id = $_POST['id'];

        if(empty($_SESSION['account'])){
            setFlashData('msg', 'Vui lòng đăng nhập để bình luận');
            redirect('?url=detail&id='.$id);
        }

        $data = [
            'comment' => $_POST['comment'],
            'user_id' => $_SESSION['account']['id'],
            'pro_id' => $id,
            'created_at' => date("Y-m-d H:i:s")
        ];

        CURDModel::Create('comments', $data);
        
        setFlashData('msg', 'Bạn đã bình luận');
        redirect('?url=detail&id='.$id);

    }
    // cart
    public function addCart($id){

        if(!$_SESSION['cart']){

            $_SESSION['cart'][] = [
                'id' => $id,
                'quantity' => 1
            ];

        }else{

            $check = true;
            foreach ($_SESSION['cart'] as $key => $value) {
                if($value['id'] == $id){
                    $quantity = $_SESSION['cart'][$key]['quantity'];
                    $_SESSION['cart'][$key]['quantity'] = $quantity + 1;
                    $check = false;
                    break;
                }
            }

            if($check){
                $_SESSION['cart'][] = [
                    'id' => $id,
                    'quantity' => 1
                ];
            }

        }

        redirect('?url=cart');

    }

    function downCart($id){


        if($_SESSION['cart']){

            $index = 0;

            foreach ($_SESSION['cart'] as $key => $value) {
                if($value['id'] == $id){
                    $quantity = $_SESSION['cart'][$key]['quantity'];
                    $_SESSION['cart'][$key]['quantity'] = $quantity - 1;
                    $index = $key;
                    break;
                }
            }

            if($_SESSION['cart'][$index]['quantity'] <= 0){
                unset($_SESSION['cart'][$index]);
            }

        }

        redirect('?url=cart');

    }

    function cart(){


        $cart = $this->giohang(); 
        $categories = $this->categories();


        layout('header');
        layout('sidebar', 'client', compact('categories'));

        view('cart', 'client', compact(['cart']));


        layout('footer');

    }
    
    function removeCart($key){

        if($_SESSION['cart']) unset($_SESSION['cart'][$key]);

        redirect('?url=cart');

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
    
    function checkvnpay(){

        if($_GET['vnp_TransactionStatus'] == 00){
    
            $order = getFlashData('order');
    
            $order['thanhtoan'] = 1;

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

        }else{

            setFlashData('msg', "Thanh toán online thất bại");
            redirect('?url=pay');


        }

    }

    function checkout($amount){

    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://127.0.0.1/-cosma/mvc/?url=checkvnpay";
    $vnp_TmnCode = "8F13Z1Z0";//Mã website tại VNPAY 
    $vnp_HashSecret = "RJAWQPLQASWTMZXUGXQLAVBSFFQYRNML"; //Chuỗi bí mật
    
    // $vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_TxnRef = rand(0, 9999999999999);
    // $vnp_OrderInfo = $_POST['order_desc'];
    $vnp_OrderInfo = "Nội dung trong bài";
    $vnp_OrderType = "billpayment";
    $vnp_Amount = $amount * 100;
    // $vnp_Locale = $_POST['language'];
    $vnp_Locale = "vn";
    // $vnp_BankCode = $_POST['bank_code'];
    $vnp_BankCode = "NCB";
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //Add Params of 2.0.1 Version
    // $vnp_ExpireDate = $_POST['txtexpire'];
    //Billing
    // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
    // $vnp_Bill_Email = $_POST['txt_billing_email'];
    // $fullName = trim($_POST['txt_billing_fullname']);
    // if (isset($fullName) && trim($fullName) != '') {
    //     $name = explode(' ', $fullName);
    //     $vnp_Bill_FirstName = array_shift($name);
    //     $vnp_Bill_LastName = array_pop($name);
    // }
    // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
    // $vnp_Bill_City=$_POST['txt_bill_city'];
    // $vnp_Bill_Country=$_POST['txt_bill_country'];
    // $vnp_Bill_State=$_POST['txt_bill_state'];
    // // Invoice
    // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
    // $vnp_Inv_Email=$_POST['txt_inv_email'];
    // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
    // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
    // $vnp_Inv_Company=$_POST['txt_inv_company'];
    // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
    // $vnp_Inv_Type=$_POST['cbo_inv_type'];
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
        
        // "vnp_ExpireDate"=>$vnp_ExpireDate,
        // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
        // "vnp_Bill_Email"=>$vnp_Bill_Email,
        // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
        // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
        // "vnp_Bill_Address"=>$vnp_Bill_Address,
        // "vnp_Bill_City"=>$vnp_Bill_City,
        // "vnp_Bill_Country"=>$vnp_Bill_Country,
        // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
        // "vnp_Inv_Email"=>$vnp_Inv_Email,
        // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
        // "vnp_Inv_Address"=>$vnp_Inv_Address,
        // "vnp_Inv_Company"=>$vnp_Inv_Company,
        // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
        // "vnp_Inv_Type"=>$vnp_Inv_Type

    );
    
    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
    //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    // }
    
    //var_dump($inputData);
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }
    
    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);
        // if (isset($_POST['redirect'])) {
        if (true) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
    

    }
    function orders(){

        $categories = $this->categories();
    
        $user_id = $_SESSION['account']['id'];

        $orders = CURDModel::Query("SELECT * FROM orders WHERE user_id='$user_id'");

        layout('header');
        layout('sidebar', 'client', compact('categories'));

        layout('menuInfor', 'client', compact(['categories']));

        view('orders', 'client', compact(['categories', 'orders']));

        layout('footer');


    }


    function detailOrder(){

        $categories = $this->categories();
    
        $id = $_GET['id'];

        if(empty($id)) redirect('?url=orders');

        $detailOrders = CURDModel::Query("SELECT do.*, p.image, p.name, p.price FROM order_carts AS do INNER JOIN products AS p ON do.pro_id=p.id WHERE do.order_id='$id'");

        if(empty($detailOrders)) redirect('?url=orders');

        layout('header');
        layout('sidebar', 'client', compact('categories'));

        layout('menuInfor', 'client', compact(['categories']));

        view('detail-order', 'client', compact(['detailOrders']));

        layout('footer');


    }

}



