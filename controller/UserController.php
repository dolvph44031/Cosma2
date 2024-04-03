<?php


class UserController extends UserModel{


    public function index(){

         if(empty($_SESSION['account']['permission'])) redirect();

        $users = $this->users();

        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('index-user', 'admin', compact('users'));

        layout('footer', 'admin');

    }

    

    public function add(){

         if(empty($_SESSION['account']['permission'])) redirect();


        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('add-user', 'admin');

        layout('footer', 'admin');

    }


    public function edit($id){

         if(empty($_SESSION['account']['permission'])) redirect();

        $user = $this->user($id);

        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('edit-user', 'admin', compact('user'));

        layout('footer', 'admin');

    }

    function addpost(){

         if(empty($_SESSION['account']['permission'])) redirect();

        $request = $_POST;

        $fullname = $request['fullname'];
        $email = $request['email'];
        $password = $request['password'];
        $permission = 0;

        if(empty($fullname) || empty($email) || empty($password)){
            setFlashData('msg', 'Vui lòng điền đủ trường');
            redirect('?url=user-add');
        }else{
            if(CURDModel::Query("SELECT * FROM users WHERE email='$email'")){
                setFlashData('msg', 'Email đã có người sử dụng');
                redirect('?url=user-add');
            }
        }

        $sql = "INSERT INTO `users` (`fullname`, `email`, `password`, `permission`) VALUES ('$fullname', '$email', '$password', '$permission')";

        $this->runSql($sql);
        setFlashData('msg', 'Thêm thành công');

        redirect('?url=user-index');


    }


    function editpost(){

        redirect('?url=user-index');

         if(empty($_SESSION['account']['permission'])) redirect();

        $request = $_POST;

        $fullname = $request['fullname'];
        $email = $request['email'];
        $password = $request['password'];
        $id = $request['id'];


        if(empty($fullname) || empty($email) || empty($password)){
            setFlashData('msg', 'Vui lòng điền đủ trường');
            redirect('?url=user-edit&id='.$id);
        }else{
            if(CURDModel::Query("SELECT * FROM users WHERE email='$email' AND id<>'$id'")){
                setFlashData('msg', 'Email đã có người sử dụng');
                redirect('?url=user-edit&id='.$id);
            }
        }

        $sql = "UPDATE users SET `fullname`='$fullname', `email`='$email', `password`='$password' WHERE `id`='$id'";

        $this->runSql($sql);
        setFlashData('msg', 'Sửa thành công');

        redirect('?url=user-edit&id='.$id);


    }

    function delete($id){

         if(empty($_SESSION['account']['permission'])) redirect();

        $comments = CURDModel::Query("SELECT * FROM comments WHERE user_id='$id'");
        $orders = CURDModel::Query("SELECT * FROM orders WHERE user_id='$id'");

        if(!empty($comments) || !empty($orders)){
            setFlashData('msg', 'Không thể xóa đơn hàng vì đã được đặt hàng hoặc đã có comment');
            redirect('?url=user-index');
        }

        $sql = "DELETE FROM users WHERE id='$id'";

        $this->runSql($sql);

        setFlashData('msg', 'Xóa tài khoản thành công');

        redirect('?url=user-index');

    }



}