<?php $__env->startSection('content'); ?>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-VubQAXOBdzJ2W7jl"></script>
<!-- Checkout Content -->
<div class="container-fluid no-padding checkout-content" style="margin-top: 40px;">
    <!-- Container -->
    <div class="container">
        <div class="row">
            <!-- Order Summary -->
            <div class="col-md-12 order-summary">
                <div class="section-padding"></div>
                <!-- Section Header -->
                <div class="section-header">
                    <h3>BASKET</h3>
                </div><!-- Section Header /- -->
                <div class="order-summary-content">
                    <?php if(count(Cart::content())>0): ?>
                    <table class="shop_cart">
                        <thead>
                            <tr>
                                <th class="product-name">PRODUCT NAME</th>
                                <th class="product-quantity">PRODUCT QUANTITY</th>
                                <th class="product-price">UNIT PRICE</th>
                                <th class="product-remove">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = Cart::content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productCartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="cart_item">


                                <td data-title="<?php echo e($productCartItem->name); ?>" class="product-name">
                                    <a title="<?php echo e($productCartItem->name); ?>"
                                        href="<?php echo e(route('product', $productCartItem->options->slug)); ?>">
                                        <?php echo e($productCartItem->name); ?>

                                    </a>
                                </td>
                                <td data-title="Quantity" class="product-quantity">
                                    <div class="quantity">
                                        <span><?php echo e($productCartItem->qty); ?></span>
                                        <!-- <input type="text" class="quantityf" data-id="<?php echo e($productCartItem->rowId); ?>" value=" <?php echo e($productCartItem->qty); ?>"> -->

                                    </div>
                                </td>

                                <td data-title="Total" class="product-subtotal">
                                    <span><?php echo e(Rupiah::getRupiah($productCartItem->price)); ?></span>
                                </td>
                                <td data-title="Total" class="product-subtotal">
                                    <span><?php echo e(Rupiah::getRupiah(($productCartItem->price) * ($productCartItem->qty))); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <form action="<?php echo e(route('basket.destroy')); ?>" method="POST">
                                        <?php echo e(csrf_field()); ?>

                                        <?php echo e(method_field('DELETE')); ?>

                                        <input type="submit" class="btn pull-left" value="CLEAR ALL">
                                    </form>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Proceed To Checkout -->
                    <div class="col-md-12 col-sm-12 text-right">
                        <div class="wc-proceed-to-checkout">
                            <p>SUBTOTAL <span><?php echo e(Rupiah::getRupiah(Cart::subtotal())); ?> + TAX</span></p>
                            <p>TOTAL <span><?php echo e(Rupiah::getRupiah(Cart::total())); ?></span></p>

                            <a href="#" id="pay-button" class="red_button" title="CHECKOUT">CHECKOUT</a>
                        </div>
                    </div><!-- Proceed To Checkout /- -->

                    <?php else: ?>
                    <div class="container-fluid no-padding checkout-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 order-summary">
                                    <div class="alert alert-danger text-center">
                                        <h2>No items in your basket !</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div><!-- Order Summary /- -->

            <form action="<?php echo e(route('payment')); ?>" id="submit_form" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="json" id="json_callback">
            </form>

        </div>

    </div><!-- Container /- -->
    <div class="section-padding"></div>
</div><!-- Checkout Content /- -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
<script>
$(function() {
    $('.quantityf').on('change', function() {
        var id = $(this).attr('data-id');
        toastr.options.timeOut = 4500;
        $.ajax({
            type: "PATCH",
            url: 'basket/update' + id,
            data: {
                'quantity': this.value,
            },
            success: function(data) {
                console.log(data);

                toastr.success('Updated successfully!');
                window.location.href = "<?php echo e(URL::to('basket/')); ?>";
            }
        });
    });
});

var payButton = document.getElementById('pay-button');
payButton.addEventListener('click', function() {
    // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
    window.snap.pay('<?php echo e($snapToken); ?>', {
        onSuccess: function(result) {
            /* You may add your own implementation here */
            // alert("payment success!");
            send_response(result);
        },
        onPending: function(result) {
            /* You may add your own implementation here */
            // alert("wating your payment!");
            send_response(result);
        },
        onError: function(result) {
            /* You may add your own implementation here */
            // alert("payment failed!");
            send_response(result);
        },
        onClose: function() {
            /* You may add your own implementation here */
            alert('you closed the popup without finishing the payment');
        }
    });
});

function send_response(result) {
    document.getElementById('json_callback').value = JSON.stringify(result);
    $('#submit_form').submit();
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>