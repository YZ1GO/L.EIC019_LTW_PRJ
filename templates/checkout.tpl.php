<?php declare(strict_types = 1);

function calculateDeliveryDate($startDay, $endDay) {
    $date1 = new DateTime();
    $date1->modify('+' . $startDay . ' day');
    $date2 = new DateTime();
    $date2->modify('+' . $endDay . ' days');
    return '<p>Estimated delivery ' . $date1->format('l, j F') . ' - ' . $date2->format('l, j F') . '</p>';
}


function drawCheckoutPage($db, $user, $address, $product) { ?>
    <h1 id="checkout-heading">Checkout</h1>
    <div class="checkout-container">
        <div class="checkout-steps">
            <div id="checkoutUserInfo" class="checkout-user-info" data-expanded="true" onclick="toggleUserInfo()">
                <h2>1. User Information</h2>
                <div class="info-box">
                    <label>Username</label>
                    <p class="info-rectangle"><?= $user->username ?></p>
                </div>
                <div class="info-box">
                    <label>Name</label>
                    <p class="info-rectangle"><?= $user->name ?></p>
                </div>
                <div class="info-box">
                    <label>Phone Number</label>
                    <p class="info-rectangle"><?= $user->phoneNumber ?></p>
                </div>
                <div class="info-box">
                    <label>Address</label>
                    <p class="info-rectangle" id="inline">
                        <?=$address->address?>,
                        <?=$address->postalCode?>,
                        <?=$address->city?>,
                        <?=$address->country?>
                    </p>
                </div>
            </div>
            <div id="shippingMethod" class="shipping-method" data-expanded="false" onclick="toggleShippingMethod()">
                <h2>2. Shipping Method</h2>
                <div id="shippingMethodSelect" class="shipping-box">
                    <div class="radio-option">
                        <input type="radio" id="standard" name="shippingMethod" value="standard" checked>
                        <div class="method-delivery">
                            <span class="method">Standard</span>
                            <div class="delivery-date">
                                <?php echo calculateDeliveryDate(3, 5); ?>
                            </div>
                        </div>
                        <span class="cost">Free</span>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="express" name="shippingMethod" value="express">
                        <div class="method-delivery">
                            <span class="method">Express</span>
                            <div class="delivery-date">
                                <?php echo calculateDeliveryDate(1, 3); ?>
                            </div>
                        </div>
                        <span class="cost">€5.99</span>
                    </div>
                </div>
            </div>
            <div id="paymentMethod" class="payment-method" data-expanded="false" onclick="togglePaymentMethod()">
                <h2>3. Payment Method</h2>
                <div id="paymentMethodSelect" class="payment-box">
                    <div class="radio-option rectangle">
                        <input type="radio" id="creditCard" name="paymentMethod" value="creditCard" checked>
                        <span class="method">Credit Card</span>
                        <div class="payment-details">
                            <div class="align-start">
                                <label for="cardHolder">Name on card</label>
                                <input type="text" id="cardHolder" name="cardHolder" placeholder="John Doe">
                            </div>
                            <div class="align-start">
                                <label for="cardNumber">Card number</label>
                                <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="row">
                                <div>
                                    <label for="expiryDate">Expiry date</label>
                                    <div class="expiry">
                                        <input type="text" id="expiryMonth" name="expiryMonth" placeholder="MM" maxlength="2">
                                        <span id="slash">/</span>
                                        <input type="text" id="expiryYear" name="expiryYear" placeholder="YY" maxlength="2">
                                    </div>
                                </div>
                            
                                <div>
                                    <div class="cvv-container">
                                        <label for="cvv">CVC/CVV</label>
                                        <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="radio-option rectangle">
                        <input type="radio" id="mbway" name="paymentMethod" value="mbway">
                        <span class="method">MBWay</span>
                        <div class="payment-details">
                            <div class="align-start">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" id="phoneNumber" name="phoneNumber" maxlength="9">
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
            <form action="waitPayment.php" method="post">
                <input type="hidden" name="productId" value="<?= $product->id ?>">
                <input type="hidden" name="totalToPay" id="totalToPayInput">
                <input type="hidden" name="selectedPaymentMethod" id="selectedPaymentMethod">
                <input type="hidden" name="paymentDetails" id="paymentDetails">
                <button type="submit">Checkout</button>
            </form>
        </div>
        <div class="product-box">
            <div class="product-content">
                <div class="product-image">
                    <img src="../database/images/<?= $product->getProductThumbnail($db) ?>">
                </div>
                <div class="product-details">
                    <h2>€ <?= $product->price ?></h2>
                    <h2><?= $product->title ?></h2>
                    <p><?= $product->description ?></p>
                </div>
                <div class="line"></div>
            </div>
            <div class="subtotal">
                Subtotal: <span class="checkout-price">€ <?= $product->price ?></span>
            </div>
            <div id="shippingCost" class="subtotal">
                <!-- This is filled in by checkout.js -->
            </div>
            <div class="total">
                TOTAL TO PAY: <span class="checkout-price">€ <?= $product->price ?></span>
            </div>
        </div>
    </div>
<?php } ?>