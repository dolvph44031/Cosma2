<table class="table table-dark">


    <tr>
        <th>STT</th>
        <th>Mã đơn hàng</th>
        <th>Thông tin người dùng</th>
        <th>Địa chỉ</th>
        <th>Ngày đặt</th>
        <th>Thanh toán bằng</th>
        <th>Đã thanh toán</th>
        <th>Trạng thái</th>
        <th>Tổng đơn</th>
    </tr>

    <?php
    
        if(!empty($orders)):
            $stt = 0;
            foreach ($orders as $key => $value):
    ?>
        <tr>
            <td><?php echo ++$stt ?></td>
            <td><a href="?url=detail-order&id=<?php echo $value['id'] ?>"><?php echo $value['code'] ?></a></td>
            <td><?php 
                echo '<span class="d-block">Tên:'.$value['fullname'].'</span>';
                echo '<span class="d-block">Email:'.$value['email'].'</span>';
                echo '<span class="d-block">Số điện thoại:'.$value['phone'].'</span>';
            ?></td>
            <td>
                <?php echo $value['address'] ?>
            </td>
            <td>
                <?php echo $value['created_at'] ?>
            </td>
            <td class="">
                <?php
                    if($value['type'] == 1){
                        echo '<span>Tiền mặt</span>';
                    }else if($value['type'] == 2){
                        echo '<span>Thanh toán online</span>';
                    }
                ?>
            </td>
            <td class="align-middle">
                <a href="?url=changeThanhToan&id=<?php echo $value['id'] ?>" class="btn btn-success">
                <?php
                    if($value['thanhtoan'] == 0){
                        echo '<span>Chưa</span>';
                    }else if($value['thanhtoan'] == 1){
                        echo '<span>Rồi</span>';
                    }
                ?>
                </a>
            </td>
            <td>
                <a href="?url=order-status&id=<?php echo $value['id'] ?>" class="btn btn-success">
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
                </a>
            </td>
            <td><?php echo $value['total'] ?></td>
        </tr>
    <?php
        endforeach; else:
    ?>

        <tr>
            <td colspan="10" class="text-center text-danger">Chưa có đơn nào</td>
        </tr>

    <?php endif; ?>


</table>