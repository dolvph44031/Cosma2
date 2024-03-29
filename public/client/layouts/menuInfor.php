

<div class="container mb-5">

<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><?php
    
    echo $_SESSION['account']['fullname'];
    
    ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="<?php echo _WEB_HOST_ROOT."?url=information"; ?>">Thông tin tài khoản  </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="<?php echo _WEB_HOST_ROOT."?url=orders"; ?>">Các đơn hàng </a>
        </li>

      </ul>
    </div>
  </div>
</nav>


</div>