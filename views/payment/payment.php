<section class="payment-section" style="margin-top:120px;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Payment</h2>
            <p class="section-subtitle">Complete your booking securely</p>
        </div>

        <div class="card">
            <h3>Booking Summary</h3>
            <p><strong>Court:</strong> <span id="court"></span></p>
            <p><strong>Date:</strong> <span id="date"></span></p>
            <p><strong>Time:</strong> <span id="time"></span></p>
            <div class="price-box">
                <span>Total:</span>
                <span id="price" class="price"></span> EGP
            </div>
        </div>

        <div class="card">
            <h3>Payment Method</h3>

            <label class="radio">
                <input type="radio" name="pay" checked>
                Credit / Debit Card
            </label>

            <div class="form">
                <input type="text" placeholder="Card Holder Name">
                <input type="text" placeholder="Card Number">

                <div class="row">
                    <input type="text" placeholder="MM/YY">
                    <input type="text" placeholder="CVV">
                </div>
            </div>

            <button id="payBtn" class="btn btn-primary btn-block">
                Confirm Payment
            </button>
        </div>
    </div>
</section>

<script src="<?php echo BASE_URL; ?>/js/payment.js"></script>
