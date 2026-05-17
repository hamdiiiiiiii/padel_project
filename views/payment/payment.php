<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

$courtId = (int) ($_GET['court_id'] ?? 0);
$courtName = trim($_GET['court_name'] ?? '');
$date = trim($_GET['date'] ?? '');
$startTime = trim($_GET['start_time'] ?? '');
$endTime = trim($_GET['end_time'] ?? '');
$price = trim($_GET['price'] ?? '0');
?>

<section class="payment-section" style="margin-top:120px;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Payment</h2>
            <p class="section-subtitle">Complete your booking securely</p>
        </div>

        <div class="card">
            <h3>Booking Summary</h3>
            <p><strong>Court:</strong> <span id="court"><?php echo htmlspecialchars($courtName); ?></span></p>
            <p><strong>Date:</strong> <span id="date"><?php echo htmlspecialchars($date); ?></span></p>
            <p><strong>Time:</strong> <span id="time"><?php echo htmlspecialchars($startTime . ' - ' . $endTime); ?></span></p>
            <div class="price-box">
                <span>Total:</span>
                <span id="price" class="price"><?php echo htmlspecialchars($price); ?></span> EGP
            </div>
        </div>

        <div class="card">
            <h3>Payment Method</h3>
            <form id="paymentForm" method="POST" action="<?php echo BASE_URL; ?>/booking/process">
                <div class="payment-methods">
                    <button id="onCourtBtn" type="button" class="btn btn-secondary">Pay On Court</button>
                    <button id="visaBtn" type="button" class="btn btn-secondary">Pay by Visa</button>
                    <input type="hidden" id="paymentType" name="payment_type" value="on_court">
                </div>

                <div id="visaFields" class="payment-details hidden" style="display: none;">
                    <div class="payment-logos">
                        <span class="visa-chip">Visa</span>
                        <span class="visa-icon">💳</span>
                    </div>
                    <p>Enter your Visa card details securely to complete payment.</p>

                    <div class="field-group">
                        <label for="cardHolderName">Cardholder Name</label>
                        <input id="cardHolderName" type="text" name="card_holder_name" placeholder="Full Name" autocomplete="cc-name">
                    </div>

                    <div class="field-group">
                        <label for="cardNumber">Card Number</label>
                        <input id="cardNumber" type="text" name="card_number" placeholder="0000 0000 0000 0000" inputmode="numeric" maxlength="19" autocomplete="cc-number">
                    </div>

                    <div class="field-row">
                        <div class="field-group">
                            <label for="expiryDate">Expiry Date</label>
                            <input id="expiryDate" type="text" name="expiry_date" placeholder="MM/YY" maxlength="5" autocomplete="cc-exp">
                        </div>
                        <div class="field-group">
                            <label for="cvv">CVV</label>
                            <input id="cvv" type="password" name="cvv" placeholder="123" maxlength="4" inputmode="numeric" autocomplete="cc-csc">
                        </div>
                    </div>
                </div>

                <p>Select your preferred payment method to confirm your booking.</p>

                <input type="hidden" name="court_id" value="<?php echo (int) $courtId; ?>">
                <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
                <input type="hidden" name="start_time" value="<?php echo htmlspecialchars($startTime); ?>">
                <input type="hidden" name="end_time" value="<?php echo htmlspecialchars($endTime); ?>">
                <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($price); ?>">

                <button id="payBtn" class="btn btn-primary btn-block" type="submit">
                    Confirm Booking
                </button>

                <script>
                    window.addEventListener('DOMContentLoaded', function () {
                        const onCourtBtn = document.getElementById('onCourtBtn');
                        const visaBtn = document.getElementById('visaBtn');
                        const visaFields = document.getElementById('visaFields');
                        const paymentTypeInput = document.getElementById('paymentType');
                        const paymentForm = document.getElementById('paymentForm');

                        if (!onCourtBtn || !visaBtn || !visaFields || !paymentTypeInput || !paymentForm) {
                            console.error('Payment toggle initialization failed.');
                            return;
                        }

                        function showVisaFields() {
                            visaFields.classList.remove('hidden');
                            visaFields.style.display = 'block';
                            paymentTypeInput.value = 'online';
                            visaBtn.classList.add('active');
                            onCourtBtn.classList.remove('active');
                        }

                        function hideVisaFields() {
                            visaFields.classList.add('hidden');
                            visaFields.style.display = 'none';
                            paymentTypeInput.value = 'on_court';
                            onCourtBtn.classList.add('active');
                            visaBtn.classList.remove('active');
                        }

                        onCourtBtn.addEventListener('click', function (event) {
                            event.preventDefault();
                            hideVisaFields();
                        });

                        visaBtn.addEventListener('click', function (event) {
                            event.preventDefault();
                            showVisaFields();
                        });

                        hideVisaFields();

                        // Format Card Number (Space every 4 digits)
                        const cardNumberInput = document.getElementById('cardNumber');
                        cardNumberInput.addEventListener('input', function (e) {
                            let value = e.target.value.replace(/\s+/g, '').replace(/\D/g, '');
                            let formattedValue = '';
                            for (let i = 0; i < value.length && i < 16; i++) {
                                if (i > 0 && i % 4 === 0) {
                                    formattedValue += ' ';
                                }
                                formattedValue += value[i];
                            }
                            e.target.value = formattedValue;
                        });

                        // Format Expiry Date (MM/YY)
                        const expiryInput = document.getElementById('expiryDate');
                        expiryInput.addEventListener('input', function (e) {
                            let value = e.target.value.replace(/\D/g, '');
                            let formattedValue = '';
                            if (value.length > 0) {
                                formattedValue += value.substring(0, 2);
                            }
                            if (value.length > 2) {
                                formattedValue += '/' + value.substring(2, 4);
                            }
                            e.target.value = formattedValue;
                        });

                        paymentForm.addEventListener('submit', function (event) {
                            if (paymentTypeInput.value !== 'online') { // Fixed: was checking for 'visa'
                                return;
                            }

                            const cardHolder = document.querySelector('input[name="card_holder_name"]').value.trim();
                            const cardNumber = document.querySelector('input[name="card_number"]').value.replace(/\s+/g, '');
                            const expiry = document.querySelector('input[name="expiry_date"]').value.trim();
                            const cvv = document.querySelector('input[name="cvv"]').value.trim();
                            
                            const expiryMatch = expiry.match(/^(0[1-9]|1[0-2])\/(\d{2})$/); // Strict MM/YY
                            let expiryValid = false;

                            if (expiryMatch) {
                                const month = parseInt(expiryMatch[1], 10);
                                let year = parseInt(expiryMatch[2], 10) + 2000;
                                const expDate = new Date(year, month - 1, 1);
                                const now = new Date();
                                const currentMonth = new Date(now.getFullYear(), now.getMonth(), 1);
                                expiryValid = expDate >= currentMonth;
                            }

                            if (!cardHolder || !/^\d{16}$/.test(cardNumber) || !expiryValid || !/^\d{3,4}$/.test(cvv)) {
                                alert('Please complete the Visa details with a valid card number (16 digits), expiry date (MM/YY), CVV, and cardholder name.');
                                event.preventDefault();
                            }
                        });

                    });
                </script>
            </form>
        </div>
    </div>
</section>
