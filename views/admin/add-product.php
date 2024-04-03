<form action="?url=product-add-post" method="post" enctype="multipart/form-data">

<?php alertError(getFlashData('msg')); ?>

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tên</label>
    <input type="text" class="form-control" name="name">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Ảnh</label>
    <input type="file" class="form-control" name="image">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Giá</label>
    <input type="text" class="form-control" name="price">
  </div>
  <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Mô tả</label>
  <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>
<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Danh mục</label>
    <select name="cate_id" id="" class="form-control">
        <?php
          foreach ($categories as $key => $value):
        ?>
          <option value="<?php echo $value['id'] ?>"><?php echo $value['name']; ?></option>
        <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<hr>
<a href="?url=product-index" class="btn btn-primary">Danh sách</a>
