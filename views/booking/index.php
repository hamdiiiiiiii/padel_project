<section class="courts-preview" style="margin-top:120px;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Choose Your Court</h2>
            <p class="section-subtitle">
                Select a court to continue your booking
            </p>
        </div>

        <div class="courts-grid">
            <div class="court-card" onclick="goToReservation('Central Court',400)">
                <div class="court-image">
                    <span class="court-icon">🏟️</span>
                    <span class="court-status available">Available</span>
                </div>
                <div class="court-details">
                    <h3 class="court-name">Central Court</h3>
                    <p class="court-location">📍 Mivida</p>
                    <div class="court-info">
                        <span class="court-price">EGP400/hour</span>
                        <span class="court-type">Indoor</span>
                    </div>
                </div>
            </div>

            <div class="court-card" onclick="goToReservation('Lakeside Court',450)">
                <div class="court-image">
                    <span class="court-icon">🏟️</span>
                    <span class="court-status available">Available</span>
                </div>
                <div class="court-details">
                    <h3 class="court-name">Lakeside Court</h3>
                    <p class="court-location">📍 Hyde Park Sports Club</p>
                    <div class="court-info">
                        <span class="court-price">EGP450/hour</span>
                        <span class="court-type">Outdoor</span>
                    </div>
                </div>
            </div>

            <div class="court-card" onclick="goToReservation('Elite Arena',350)">
                <div class="court-image">
                    <span class="court-icon">🏟️</span>
                    <span class="court-status busy">Popular</span>
                </div>
                <div class="court-details">
                    <h3 class="court-name">Elite Arena</h3>
                    <p class="court-location">📍 Cairo Stadium</p>
                    <div class="court-info">
                        <span class="court-price">EGP350/hour</span>
                        <span class="court-type">Indoor</span>
                    </div>
                </div>
            </div>

            <div class="court-card" onclick="goToReservation('Pro Court',500)">
                <div class="court-image">
                    <span class="court-icon">🏟️</span>
                    <span class="court-status available">Available</span>
                </div>
                <div class="court-details">
                    <h3 class="court-name">Pro Court</h3>
                    <p class="court-location">📍 New Cairo Club</p>
                    <div class="court-info">
                        <span class="court-price">EGP500/hour</span>
                        <span class="court-type">Premium</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo BASE_URL; ?>/js/book.js"></script>
