

<table class="table table-dark">

    <tr>
        <th>STT</th>
        <th>Người bình luận</th>
        <th>Sản phẩm</th>
        <th>Thời gian</th>
        <th>Bình luận</th>
        <th>Duyệt</th>
        <th>Xóa</th>
    </tr>

    <?php

        if(!empty($comments)):
        $stt = 0;

        foreach ($comments as $key => $value):
    ?>

            <tr>
                <td><?php echo ++$stt ?></td>
                <td><?php echo $value['fullname'] ?>
                <?php
                if(!empty($value['status'])){
                    echo '<p class="text-success">Đã duyệt</p>';
                }else{
                    echo '<p class="text-danger">Chưa duyệt</p>';
                }
                ?>
            </td>
                <td><?php echo $value['name'] ?></td>
                <td><?php echo $value['created_at'] ?></td>
                <td><?php echo $value['comment'] ?></td>
                <td>
                    <a href="<?php echo _WEB_HOST_ROOT.'?url=activeComment&id='.$value['id'] ?>" class="btn btn-success">
                        Thay đổi
                    </a>
                </td>
                <td>
                    <a href="<?php echo _WEB_HOST_ROOT.'?url=removeComment&id='.$value['id'] ?>" class="btn btn-danger">
                        Xóa
                    </a>
                </td>
            </tr>

    <?php
        endforeach;
    else:
    ?>

        <tr><td colspan="10" class="text-center text-danger">Không có bình luận</td></tr>

    <?php endif; ?>

</table>