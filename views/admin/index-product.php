<?php



?>



<?php alertError(getFlashData('msg')); ?>

<table class="table table-dark table-striped">

  <tr>
    <th width="10%">STT</th>
    <th>Tên</th>
    <th width="40%">Mô tả</th>
    <th>Giá</th>
    <th width="10%">Sửa</th>
    <th width="10%">Xóa</th>
  </tr>

  <?php
    foreach ($products as $key => $value):
  ?>
  <tr>
    <td><?php echo $key+1 ?></td>
    <td>
      <p>Tên sản phẩm: <?php echo $value['name'] ?></p>
      <img width="60%" src="<?php echo _WEB_HOST_ROOT.'/public/image/'.$value['image']; ?>" alt="ảnh lỗi">

    </td>
    <td><?php echo $value['description'] ?></td>
    <td><?php echo $value['price'] ?></td>
    <td>
        <a href="?url=product-edit&id=<?php echo $value['id'] ?>" class="btn btn-warning">Sửa</a>
    </td>
    <td>
        <a onclick="return confirm('bạn có chắc muốn xóa')" href="?url=product-delete&id=<?php echo $value['id'] ?>" class="btn btn-danger">Xóa</a>
    </td>
    </tr>
    <?php
    endforeach;
    ?>
</table>

<hr>
<a href="?url=product-add" class="btn btn-primary">Thêm</a>
