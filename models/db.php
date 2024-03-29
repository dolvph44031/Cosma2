<?php

class db
{
    public function getConnect()
    {
        $connect = new PDO(
            "mysql:host=" . DBHOST
                . ";dbname=" . DBNAME
                . ";charset=" . DBCHARSET,
            DBUSER,
            DBPASS
        );
        return $connect;
    }



    // nếu như dùng để lấy danh sách thì sẽ truyền true còn truyền false thì
    //sẽ chạy được các câi truy vấn như thêm sửa xóa
    public function getData($query, $getAll = true)
    {
        $conn = $this->getConnect();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if ($getAll) {
            return $stmt->fetchAll();
        }
        return $stmt->fetch();
    }

    public function runSql($sql, $data = []){

        $conn = $this->getConnect();
        $stmt = $conn->prepare($sql);

        if(!empty($data)){
            $stmt->execute($data);
        }else{
            $stmt->execute();
        }

    }


    
}
