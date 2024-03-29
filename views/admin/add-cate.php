



<form action="?url=cate-add-post" method="post">

<?php alertError(getFlashData('msg')); ?>

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tên</label>
    <input type="text" class="form-control" name="name">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<hr>
<a href="?url=cate-index" class="btn btn-primary">Danh sách</a>