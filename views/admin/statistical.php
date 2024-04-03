<table class="table table-dark">

    <tr>
        <th>STT</th>
        <th>Tên</th>
        <th>Số sản phẩm cùng loại</th>
    </tr>

    <?php
    
    $stt = 0;

    foreach ($proCate as $key => $value) {
        echo '

        <tr>
            <td>'.++$stt.'</td>
            <td>'.$value['cate']['name'].'</td>
            <td>'.$value['count'].'</td>
        </tr>

        ';
    }
    
    ?>


</table>


<table class="table table-dark">

    <tr>
        <th>STT</th>
        <th>Tên</th>
        <th>Số lượng bán được</th>
    </tr>

    <?php
    
    $stt = 0;

    foreach ($proBuy as $key => $value) {
        echo '

        <tr>
            <td>'.++$stt.'</td>
            <td>'.$value['product']['name'].'</td>
            <td>'.$value['count'].'</td>
        </tr>

        ';
    }
    
    ?>


</table>


<table class="table table-dark">

    <tr>
        <th>STT</th>
        <th>Tên</th>
        <th>Doanh thu của các sản phẩm</th>
    </tr>

    <?php
    
    $stt = 0;

    foreach ($proPrice as $key => $value) {
        echo '

        <tr>
            <td>'.++$stt.'</td>
            <td>'.$value['product']['name'].'</td>
            <td>'.$value['price'].'</td>
        </tr>

        ';
    }
    
    ?>


</table>