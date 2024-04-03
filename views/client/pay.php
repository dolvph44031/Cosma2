<?php

$total = 0;

?>

<div class="container">



<table class="table table-bordered text-center mb-0 mt-5">
    <thead class="bg-secondary text-dark">
        <tr>
        <th>STT</th>
        <th>Sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Tổng</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        <?php
            if(!empty($carts)):
                $stt = 0;
                foreach ($carts as $key => $value):

        ?>
        <tr>
            <!-- <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;"><?php echo $value['name'] ?></td> -->
            <td class="align-middle"><?php echo ++$stt ?></td>
            <td class="align-middle">
                    <?php echo $value['name'] ?>
            </td>

            <td class="align-middle">
                    <?php echo $value['price'] ?>
            </td>
        
            <td class="align-middle">
                <?php echo $value['quantity']; ?>
            </td>
            <td>
                <?php
                    $totalItem = $value['price'] * $value['quantity'];
                    echo $totalItem;
                    $total += $totalItem;
                ?>
            </td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>

<form action="?url=loadPay" class="row mx-0 mt-4 p-3 bg-primary" method="POST">

    <div class="col-lg-7">

        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Tên người nhận ...">
        </div>

        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email ...">
        </div>

        <div class="mb-3">
            <input type="text" name="phone" class="form-control" placeholder="Số điện thoại ...">
        </div>

        <div class="">
            <input type="text" name="address" class="form-control" placeholder="Địa chỉ ...">
        </div>

        <hr>

        <?php alertError(getFlashData('msg')); ?>

    </div>

    <div class="col-lg-5">
    
        <div class="bg-light h-100 p-3">
            <label for="" class="mb-3">Phương thức thanh toán | <a href="?url=cart" class="text-primary">Giỏ hàng</a></label>
            <hr>
            <div class="">
                <input type="radio" name="type" value="1">
                <label for="">Tiền mặt</label>
                <span class="text-primary">|</span>
                <input type="radio" name="type" value="2">
                <label for="">Thanh toán VNPAY</label>
            </div>
            <hr>
            <h3>Tổng đơn: <?php echo $total ?> VNĐ</h3>
            <input type="hidden" name="total" value="<?php echo $total ?>">
            <div class="mt-5">
                <input type="submit" class="btn btn-primary" value="Thanh toán">
            </div>
        </div>

    </div>

</form>


</div>