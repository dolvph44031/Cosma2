<?php

?>


  <!-- Products Start -->
  <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm theo danh mục <span class="text-primary"><?php echo $category['name'] ?></span></span></h2>
        </div>
        <div class="row px-xl-5 pb-3">

            <?php foreach ($products as $key => $value): ?>

            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <a href="<?php echo "?url=detail&id=".$value['id']; ?>">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="<?php echo _WEB_HOST_ROOT.'/public/image/'.$value['image']; ?>" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $value['name'] ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php echo $value['price'] ?></h6>
                        </div>
                    </div>
                    </a>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        <a href="?url=add-cart&id=<?php echo $value['id'] ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
                </div>
            </div>


            <?php endforeach; ?>
    
            </div>
        </div>
    </div>
    <!-- Products End -->

