<?php



?>


<?php alertError(getFlashData('msg')); ?>


<table class="table table-dark table-striped">
  <tr>
    <th width="10%">STT</th>
    <th>Tên</th>
    <th width="10%">Sửa</th>
    <th width="10%">Xóa</th>
  </tr>

  <?php
    foreach ($categories as $key => $value):
  ?>
  <tr>
    <td><?php echo $key+1 ?></td>
    <td><?php echo $value['name'] ?></td>
    <td>
        <a href="?url=cate-edit&id=<?php echo $value['id'] ?>" class="btn btn-warning">Sửa</a>
    </td>
    <td>
        <a onclick="return confirm('bạn có chắc muốn xóa')" href="?url=cate-delete&id=<?php echo $value['id'] ?>" class="btn btn-danger">Xóa</a>
    </td>
    </tr>
    <?php
    endforeach;
    ?>
</table>

<hr>
<a href="?url=cate-add" class="btn btn-primary">Thêm</a>
