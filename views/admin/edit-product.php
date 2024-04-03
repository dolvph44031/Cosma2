<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Thực hiện các hành động cần thiết để cập nhật sản phẩm trong cơ sở dữ liệu

  // Giả sử cập nhật thành công, bạn có thể hiển thị thông báo thành công
  $updateSuccess = true;
}

?>

<form action="?url=product-edit-post" method="post" enctype="multipart/form-data">

<?php alertError(getFlashData('msg')); ?>

    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tên</label>
    <input type="text" class="form-control" name="name" value="<?php echo $product['name'] ?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Ảnh</label>
    <input type="file" class="form-control" name="image">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Giá</label>
    <input type="text" class="form-control" name="price" value="<?php echo $product['price'] ?>">
  </div>
  <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Mô tả</label>
  <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"><?php echo $product['description'] ?></textarea>
</div>
<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Danh mục</label>
    <select name="cate_id" id="" class="form-control">
        <?php
          foreach ($categories as $key => $value):
        ?>
          <option <?php echo $product['cate_id'] == $value['id'] ? 'selected' : '' ?> value="<?php echo $value['id'] ?>"><?php echo $value['name']; ?></option>
        <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary" value="<?php echo isset($updateSuccess) && $updateSuccess ? 'Cập nhật thành công!' : 'Submit'; ?>">
    <?php echo isset($updateSuccess) && $updateSuccess ? 'Cập nhật thành công!' : 'Submit'; ?>
  </button>
</form>
<hr>
<a href="?url=product-index" class="btn btn-primary">Danh sách</a>