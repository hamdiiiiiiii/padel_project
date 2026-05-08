<<<<<<< HEAD
<section style="margin-top: 120px">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Complete Reservation</h2>
        </div>

        <div class="reservation-card">
            <h3 id="courtName"></h3>
            <p id="courtPrice"></p>
        </div>

        <div class="calendar">
            <h3>Select Date</h3>
            <input type="date" id="dateInput" />
        </div>

        <div class="slots-grid" id="slotsContainer"></div>

        <div class="summary">
            <h3>Booking Summary</h3>

            <div class="summary-box">
                <div class="summary-row">
                    <i class="fas fa-table-tennis"></i>
                    <span class="label">Court:</span>
                    <span class="value" id="summaryCourtName"></span>
                </div>

                <div class="summary-row">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="label">Date:</span>
                    <span class="value" id="summaryDate"></span>
                </div>

                <div class="summary-row">
                    <i class="fas fa-clock"></i>
                    <span class="label">Time Slots:</span>
                    <span class="value" id="summarySlots"></span>
                </div>

                <div class="summary-row total">
                    <i class="fas fa-tag"></i>
                    <span class="label">Total Price:</span>
                    <span class="value" id="summaryPrice"></span>
                </div>
            </div>

            <button class="btn btn-primary" onclick="goToPayment()">
                Confirm Booking
            </button>
        </div>
    </div>
</section>

<script>
    const BASE_URL_JS = '<?php echo BASE_URL; ?>';
    const IS_LOGGED_IN = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
</script>
<script src="<?php echo BASE_URL; ?>/js/reservation.js"></script>
=======
<section style="margin-top: 120px">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Complete Reservation</h2>
        </div>

        <div class="reservation-card">
            <h3 id="courtName"></h3>
            <p id="courtPrice"></p>
        </div>

        <div class="calendar">
            <h3>Select Date</h3>
            <input type="date" id="dateInput" />
        </div>

        <div class="slots-grid" id="slotsContainer"></div>

        <div class="summary">
            <h3>Booking Summary</h3>

            <div class="summary-box">
                <div class="summary-row">
                    <i class="fas fa-table-tennis"></i>
                    <span class="label">Court:</span>
                    <span class="value" id="summaryCourtName"></span>
                </div>

                <div class="summary-row">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="label">Date:</span>
                    <span class="value" id="summaryDate"></span>
                </div>

                <div class="summary-row">
                    <i class="fas fa-clock"></i>
                    <span class="label">Time Slots:</span>
                    <span class="value" id="summarySlots"></span>
                </div>

                <div class="summary-row total">
                    <i class="fas fa-tag"></i>
                    <span class="label">Total Price:</span>
                    <span class="value" id="summaryPrice"></span>
                </div>
            </div>

            <button class="btn btn-primary" onclick="goToPayment()">
                Confirm Booking
            </button>
        </div>
    </div>
</section>

<script>
    const BASE_URL_JS = '<?php echo BASE_URL; ?>';
    const IS_LOGGED_IN = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
</script>
<script src="<?php echo BASE_URL; ?>/js/reservation.js"></script>
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
