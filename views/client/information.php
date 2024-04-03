
<?php  

    $user = $_SESSION['account'];

?>

<div class="container">

    <?php alertError(getFlashData('msg')); ?>

    <form action="?url=informationPost" method="post">

    <div class="mb-3">
        <label for="">Tên người dùng</label>
        <input type="text" name="fullname" class="form-control" value="<?php echo $user['fullname']; ?>">
    </div>

    <div class="mb-3">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>">
    </div>

    <div class="mb-3">
        <input type="submit" value="Lưu" class="btn btn-primary">
    </div>


    </form>

</div>