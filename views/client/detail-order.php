<div class="container">


<table class="table">

    <tr class="bg-primary">
        <th>STT</th>
        <th width="40%">Sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Tổng</th>
    </tr>

    <?php
        $stt = 0;
        $total = 0;
        foreach ($detailOrders as $key => $do):
            
    ?>

        <tr>
            <td><?php echo ++$stt ?></td>
            <td class="row mx-0">
                <div class="col-4">
                    <img src="<?php echo _PATH_IMAGE."/".$do['image'] ?>" width="90%" alt="">
                </div>
                <div class="col-8">
                    <?php echo $do['name']; ?>
                </div>
            </td>
            <td>
                <?php 
                    echo $do['price']
                ?>
                VND
            </td>
            <td><?php echo $do['quantity'] ?></td>
            <td>
                <?php 

                    $itemTotal = $do['price'] * $do['quantity'];
                    $total += $itemTotal;
                    echo $itemTotal;
                ?>
                VND
            </td>
        </tr>

    <?php endforeach; ?>

</table>

<h1 class="py-3">Tổng đơn: <?php echo $total; ?>VND</h1>


</div>