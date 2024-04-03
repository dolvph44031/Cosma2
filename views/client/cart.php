 
 <?php
 
 $tatol = 0;

 ?>
 
 
 <!-- Cart Start -->
 <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php
                            if(!empty($cart)):
                                foreach ($cart as $key => $value):

                        ?>
                        <tr>
                            <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;"><?php echo $value['name'] ?></td>
                            <td class="align-middle"><?php echo $value['price'] ?></td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <a href="<?php echo "?url=down-cart&id=".$value['id'] ?>" class="btn btn-sm btn-primary btn-minus" >
                                        <i class="fa fa-minus"></i>
                                        </a>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary text-center" disabled value="<?php echo $value['quantity']; ?>">
                                    <div class="input-group-btn">
                                        <a href="<?php echo "?url=add-cart&id=".$value['id'] ?>" class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle"><?php
                             $tatol += $value['price']*$value['quantity'];
                             echo $value['price']*$value['quantity'];
                             ?></td>
                            <td class="align-middle"><a onclick="return confirm('Bạn có chắc muốn xóa')" href="?url=remove-cart&key=<?php echo $key; ?>" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></a></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="10" class="text-danger text-center">Chưa có sản phẩm nào</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <!-- <form class="mb-5" action="">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form> -->
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Tổng đơn hàng</h4>
                    </div>
                    <!-- <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div> -->
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold"><?php echo $tatol; ?></h5>
                        </div>
                        <a  class="btn btn-block btn-primary my-3 py-3" <?php echo empty($cart)? '' : 'href="?url=pay"' ?> >Thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->