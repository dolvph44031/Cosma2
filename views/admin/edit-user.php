

<?php alertError(getFlashData('msg')) ?>


<form action="?url=user-edit-post" method="post">
    <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tên</label>
    <input type="text" class="form-control" disabled name="fullname" value="<?php echo $user['fullname'] ?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input type="email" class="form-control" disabled name="email" value="<?php echo $user['email'] ?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
    <input type="password" class="form-control" disabled name="password" value="<?php echo $user['password'] ?>">
  </div>
</form>
<hr>
<a href="?url=user-index" class="btn btn-primary">Danh sách</a>