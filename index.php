<?php

session_start();

ob_start();

date_default_timezone_set('Asia/Ho_Chi_Minh');

// Đường dẫn tuyệt đối
define('_WEB_PATH_ROOT',  __DIR__);
define('_WEB_HOST_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/duan/-cosma/mvc/');
define('_PATH_IMAGE', _WEB_HOST_ROOT . "/public/image");

// phpmailer
require './helper/phpmailer/Exception.php';
require './helper/phpmailer/PHPMailer.php';
require './helper/phpmailer/SMTP.php';


// helper
require "./helper/functions.php";

// config
require_once "models/env.php";
require_once "models/db.php";

// model

require "./models/UserModel.php";
require "./models/CategoryModel.php";
require "./models/ProductModel.php";
require "./models/IndexModel.php";
require "./models/CURDModel.php";

// controller
require "./controller/UserController.php";
require "./controller/CategoryController.php";
require "./controller/ProductController.php";
require "./controller/IndexController.php";


// Create controlelr
$user = new UserController();
$cate = new CategoryController();
$product = new ProductController();
$index = new IndexController();

$url = isset($_GET['url']) ? $_GET['url'] : "/";



// echo '<pre>';
// print_r($_GET);
// echo '</pre>';

switch ($url) {
    case "/":

        $index->home();
        break;


    case "category":
        $index->productForCategory();
        break;

    case "createComment":
        $index->createComment();
        break;

    case "activeComment":
        $product->activeComment();
        break;

        // curd users

    case "cate-index":
        if (!$_SESSION['account']['permission']) redirect();
        $cate->index();
        break;
    case "cate-add":
        if (!$_SESSION['account']['permission']) redirect();

        $cate->add();
        break;
    case "cate-add-post":
        if (!$_SESSION['account']['permission']) redirect();

        $cate->addpost();
        break;

    case "cate-edit":
        if (!$_SESSION['account']['permission']) redirect();

        $id = $_GET['id'];
        $cate->edit($id);
        break;
    case "cate-edit-post":
        if (!$_SESSION['account']['permission']) redirect();

        $cate->editpost();
        break;
    case "cate-delete":
        if (!$_SESSION['account']['permission']) redirect();

        $id = $_GET['id'];
        $cate->delete($id);
        break;

        // crud users 
    case "user-index":
        if (!$_SESSION['account']['permission']) redirect();

        $user->index();
        break;
    case "user-add":
        if (!$_SESSION['account']['permission']) redirect();

        $user->add();
        break;
    case "user-add-post":
        if (!$_SESSION['account']['permission']) redirect();

        $user->addpost();
        break;

    case "user-edit":
        if (!$_SESSION['account']['permission']) redirect();

        $id = $_GET['id'];
        $user->edit($id);
        break;
    case "user-edit-post":
        if (!$_SESSION['account']['permission']) redirect();

        $user->editpost();
        break;
    case "user-delete":
        if (!$_SESSION['account']['permission']) redirect();

        $id = $_GET['id'];
        $user->delete($id);
        break;

        // curd products

    case "product-index":
        if (!$_SESSION['account']['permission']) redirect();

        $product->index();
        break;
    case "product-add":
        if (!$_SESSION['account']['permission']) redirect();

        $product->add();
        break;
    case "product-add-post":
        if (!$_SESSION['account']['permission']) redirect();

        $product->addpost();
        break;

    case "product-edit":
        if (!$_SESSION['account']['permission']) redirect();

        $id = $_GET['id'];
        $product->edit($id);
        break;
    case "product-edit-post":
        if (!$_SESSION['account']['permission']) redirect();

        $product->editpost();
        break;
    case "product-delete":
        if (!$_SESSION['account']['permission']) redirect();

        $id = $_GET['id'];
        $product->delete($id);
        break;
        // comment 
    case "comment-index":

        $product->comments();

        break;

    case "removeComment":

        $product->removeComment();

        break;

    case "home":
        $index->home();
        break;

    case "detail":
        $id = $_GET['id'];
        $index->detail($id);
        break;
        // auth
    case "login":
        $index->login();
        break;
    case "login-post":
        $index->loginPost();
        break;

    case "forgot":
        $index->forgot();
        break;

    case "forgot-post":
        $index->forgotPost();
        break;


    case "logout":
        $index->logout();
        break;
    case "register":
        $index->register();
        break;

    case "register-post":
        $index->registerPost();
        break;

    case "information":
        $index->information();
        break;

    case "informationPost":
        $index->informationPost();
        break;
    default:
        echo "404";
        break;
}
