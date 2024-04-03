<?php

// echo '<pre>';
// print_r($orders);
// echo '</pre>';

?>
<div class="container">


<table class="table table-bordered text-center mb-0 mt-5 w-100">
    <thead class="bg-secondary text-dark">
        <tr>
        <th>STT</th>
        <th>Mã đơn hàng</th>
        <th>Thông tin người nhận</th>
        <th>Địa chỉ</th>
        <th>Ngày đặt</th>
        <th>Thanh toán bằng</th>
        <th>Tình trạng</th>
        <th>Đã thanh toán</th>
        <th>Tổng đơn hàng</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        <?php
            if(!empty($orders)):
                $stt = 0;
                foreach ($orders as $key => $value):

        ?>
        <tr>
            <!-- <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;"><?php echo $value['name'] ?></td> -->
            <td class="align-middle"><?php echo ++$stt ?></td>

            <td class="align-middle">
                    <a href="?url=detailOrder&id=<?php echo $value['id'] ?>">
                    <?php echo $value['code'] ?>
                    </a>
            </td>

            <td class="align-middle" style="text-align: left;">
                <span class="d-block">Tên: 
                <?php echo $value['fullname'] ?>
                </span>
                <span class="d-block">Email: 
                <?php echo $value['email'] ?>
                </span>
                <span class="d-block">Số điện thoại: 
                <?php echo $value['phone'] ?>
                </span>
            </td>
            
            <td class="align-middle">
                <?php echo $value['address']; ?>
            </td>

            <td class="align-middle">
                <?php
                    echo $value['created_at'];
                ?>
            </td>
            
            <td class="align-middle">
                <?php
                    if($value['type'] == 1){
                        echo '<span>Tiền mặt</span>';
                    }else if($value['type'] == 2){
                        echo '<span>Thanh toán online</span>';
                    }
                ?>
            </td>

            <td class="align-middle">
                <?php
                    if($value['status'] == 0){
                        echo '<span>Đơn mới</span>';
                    }else if($value['status'] == 1){
                        echo '<span>Đang xử lí</span>';
                    }else if($value['status'] == 2){
                        echo '<span>Đang giao</span>';
                    }else if($value['status'] == 3){
                        echo '<span>Đã giao</span>';
                    }else if($value['status'] == 4){
                        echo '<span>Đã hủy</span>';
                    }
                ?>
            </td>

            <td class="align-middle">
                <?php
                    if($value['thanhtoan'] == 0){
                        echo '<span>Chưa</span>';
                    }else if($value['thanhtoan'] == 1){
                        echo '<span>Rồi</span>';
                    }
                ?>
            </td>

            <td class="align-middle">
                <?php
                    echo $value['total'];
                ?>
                VNĐ
            </td>
     
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>


</div>
