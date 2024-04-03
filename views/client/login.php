


<div class="px-5">

<?php

if(!empty($_SESSION['email'])){

    echo $_SESSION['email'];

    unset($_SESSION['email']);
    
}

?>

<form action="?url=login-post" method="post">
  <!-- <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">User Name</label>
    <input autocomplete="false" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="user">
  </div> -->

  <?php alertError(getFlashData('msg')); ?>

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input autocomplete="false" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
  </div>
  <!-- <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div> -->

  <button type="submit" class="btn btn-primary">Đăng Nhập</button>
  <!-- <a class="btn btn-primary" href="?url=register">Đăng Ký</a> -->
</form>
<hr>
<a class="btn btn-primary" href="?url=forgot">Quên mật khẩu</a>
<a class="btn btn-primary" href="?url=register">Đăng ký</a>
</div>