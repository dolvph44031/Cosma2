


<?php


class CategoryController extends CategoryModel{


    public function index(){

                 if(empty($_SESSION['account']['permission'])) redirect();
        $categories = $this->categories();

        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('index-cate', 'admin', compact('categories'));

        layout('footer', 'admin');

    }

    

    public function add(){

                 if(empty($_SESSION['account']['permission'])) redirect();

        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('add-cate', 'admin');

        layout('footer', 'admin');

    }


    public function edit($id){

                 if(empty($_SESSION['account']['permission'])) redirect();
        $category = $this->category($id);



        layout('header', 'admin');
        layout('sidebar', 'admin');

        view('edit-cate', 'admin', compact('category'));

        layout('footer', 'admin');

    }

    function addpost(){

                 if(empty($_SESSION['account']['permission'])) redirect();
        if(empty($_POST['name'])){

            setFlashData('msg', "Vui lòng điền");
            redirect('?url=cate-add');

        }

        $request = $_POST;

        $name = $request['name'];

        $sql = "INSERT INTO `categories` (`name`) VALUES ('$name')";

        $this->runSql($sql);
        setFlashData('msg', "Thêm thành công");

        redirect('?url=cate-index');


    }


    function editpost(){

                 if(empty($_SESSION['account']['permission'])) redirect();
        $request = $_POST;

        $name = $request['name'];
        $id = $request['id'];

         if(empty($name) || empty($id)){

            setFlashData('msg', "Vui lòng điền");
            redirect('?url=cate-edit&id='.$id);

        }

        $sql = "UPDATE categories SET `name`='$name' WHERE `id`='$id'";

        $this->runSql($sql);

        setFlashData('msg', "Sửa thành công");

        redirect('?url=cate-index');


    }

    function delete($id){

                 if(empty($_SESSION['account']['permission'])) redirect();
        $products = CURDModel::Query("SELECT * FROM products WHERE cate_id='$id'");

        if(!empty($products)){
            setFlashData('msg', 'Danh mục đang có sản phẩm không xóa được');
            redirect('?url=cate-index');
        }

        $sql = "DELETE FROM categories WHERE id='$id'";

        $this->runSql($sql);

        redirect('?url=cate-index');

    }



}