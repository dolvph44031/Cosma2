

<?php alertError(getFlashData('msg')) ?>


<form action="?url=user-add-post" method="post">
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tên</label>
    <input type="text" class="form-control" name="fullname">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input type="email" class="form-control" name="email">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
    <input type="password" class="form-control" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<hr>
<a href="?url=user-index" class="btn btn-primary">Danh sách</a>