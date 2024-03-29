



<form action="?url=cate-edit-post" method="post">
<?php alertError(getFlashData('msg')); ?> 

    <input type="hidden" name="id" value="<?php echo $category['id'] ?>">
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tên</label>
    <input type="text" class="form-control" name="name" value="<?php echo $category['name'] ?>">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<hr>
<a href="?url=cate-index" class="btn btn-primary">Danh sách</a>