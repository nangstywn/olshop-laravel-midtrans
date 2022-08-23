<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/styles/single_styles.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/styles/single_responsive.css')); ?>">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<style>
.addqty {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    text-align: center;
}

.qty {
    width: 40px;
    height: 25px;
    text-align: center;
    border: 1px solid gainsboro;
}

input.qtyplus {
    width: 30px;
    height: 25px;
    cursor: pointer;
    border: 1px solid gainsboro;
}

input.qtyminus {
    width: 30px;
    height: 25px;
    cursor: pointer;
    border: 1px solid gainsboro;
}

.add-cart,
.add-cart:hover {
    border: 1px solid #D1001B;
    border-radius: 0;
    color: #D1001B;
    background-color: #FAEAED;
    margin-right: 10px;
}

.buy,
.buy:hover {
    border-radius: 0;
    color: white;
    background-color: #D1001B;
}
</style>

<div class="container single_product_container">
    <div class="row">
        <div class="col">
            <!-- Breadcrumbs -->
            <div class="breadcrumbs d-flex flex-row align-items-center">
                <ul>
                    <li><a href="/">Home</a></li>
                    <?php $__currentLoopData = $bcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="/category/<?php echo e($bc->slug); ?>"><i class="fa fa-angle-right"
                                aria-hidden="true"></i><?php echo e($bc->category_name); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li class="active"><a href="<?php echo e(route('product', $product->slug)); ?>"><i class="fa fa-angle-right"
                                aria-hidden="true"></i><?php echo e($product->product_name); ?>

                        </a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="single_product_pics">
                <div class="row">
                    <div class="col-lg-3 thumbnails_col order-lg-1 order-2">
                        <div class="single_product_thumbnails">
                            <ul>
                                <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="item">
                                    <img src="<?php echo asset('uploads/thumb_'.$image->name); ?>" alt=""
                                        data-image="<?php echo asset('uploads/'.$image->name); ?>">
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>


                    </div>

                    <div class="col-lg-9 image_col order-lg-2 order-1">
                        <div class="single_product_image">
                            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="single_product_image_background" style="background-image:url('<?php echo e(asset("
                                uploads/thumb_".$image->name)); ?>')"></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="product_details">
                <div class="product_details_title">
                    <h2><?php echo e($product->product_name); ?></h2>
                    <p><?php echo $product->product_detail; ?></p>
                </div>

                <div class="original_price"><?php echo e(Rupiah::getRupiah($product->original_price)); ?></div>
                <div class="product_price"><?php echo e(Rupiah::getRupiah($product->product_price)); ?></div>

                <div class="product_details_title">
                    <span>Quantity:</span>
                    <p class="addqty">
                        <input type='button' value='-' class='qtyminus minus' field='quantity' />
                        <input type='text' name='quantity' id="quantity" value='1' class='qty' />
                        <input type='button' value='+' class='qtyplus plus' field='quantity' />
                    </p>
                    <!-- <input style="width: 50px; margin-right: 10px;" type="number" class="quantity" id="quantity" name="quantity" value="1"> -->

                </div>
                <div>
                    <a class="btn add-cart" href="<?php echo e(route('basket.create', ['id' => $product->id])); ?>"><i
                            class="fa fa-shopping-cart"></i> Add to
                        Cart</a>
                    <a class="btn buy" href="<?php echo e(route('basket.create', ['id' => $product->id])); ?>"> Buy Now</a>

                </div>
            </div>
        </div>
    </div>

</div>



<!-- Benefit -->

<div class="benefit">
    <div class="container">
        <div class="row benefit_row">
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>free shipping</h6>
                        <p>Suffered Alteration in Some Form</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-money" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>cash on delivery</h6>
                        <p>The Internet Tend To Repeat</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-undo" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>45 days return</h6>
                        <p>Making it Look Like Readable</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>opening all week</h6>
                        <p>8AM - 09PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>


<script>
$('.add-cart').click(function(event) {
    event.preventDefault();
    var quantity = $(this).parent().prev().find('input[name="quantity"]').val();
    $.ajax({
        type: "POST",
        url: $(this).attr('href'),
        data: {
            quantity: quantity
        },
        success: function(data) {
            $('#checkout_items').html(data.cartCount);
        },
        error: function() {
            window.location.href = "<?php echo e(route('login')); ?>"
        }
        // return false; //for good measure
    });
});

$('.addqty').on('click', '.plus', function(e) {
    let $input = $(this).prev('input.qty');
    let val = parseInt($input.val());
    $input.val(val + 1).change();
});

$('.addqty').on('click', '.minus',
    function(e) {
        let $input = $(this).next('input.qty');
        var val = parseInt($input.val());
        if (val > 0) {
            $input.val(val - 1).change();
        }
    });

$(document).ready(function() {
    let img = $('.item img').attr('data-image')
    $('.single_product_image_background').css('background-image', 'url(' + img + ')')
})
</script>

<script src="<?php echo e(asset('assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/single_custom.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>