<section class="hero">
  <div class="container">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">
          Book Your Padel Court
          <span class="highlight">In Seconds</span>
        </h1>
        <p class="hero-description">
          Skip the phone calls and long queues. Reserve your favorite padel
          court online, choose your preferred time slot, and pay securely.
        </p>
        <div class="hero-cta">
          <a href="#courts" class="btn btn-primary btn-large">Book a Court Now</a>
          <a href="#courts" class="btn btn-outline btn-large">View Available Courts</a>
        </div>
      </div>
      <div class="hero-image">
        <div class="booking-card">
          <div class="booking-card-header">
            <h3>Quick Booking</h3>
            <span class="badge">2 mins</span>
          </div>
          <div class="booking-card-body">
            <div class="booking-step"><div class="step-number">1</div><div class="step-text">Choose your court</div></div>
            <div class="booking-step"><div class="step-number">2</div><div class="step-text">Select time slot</div></div>
            <div class="booking-step"><div class="step-number">3</div><div class="step-text">Complete payment</div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="how-it-works">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">How It Works</h2>
    </div>
    <div class="steps-grid">
      <div class="step-card"><div class="step-icon">🎾</div><h3>Browse Courts</h3><p>View all available courts.</p></div>
      <div class="step-card"><div class="step-icon">📅</div><h3>Select Time</h3><p>Choose your slot.</p></div>
      <div class="step-card"><div class="step-icon">💳</div><h3>Pay</h3><p>Secure payment.</p></div>
    </div>
  </div>
</section>

<section class="courts-preview" id="courts">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Our Padel Courts</h2>
      <p class="section-subtitle">Choose from our premium courts at convenient locations</p>
    </div>

 <div class="courts-grid">
    <?php if (!empty($courts)): ?>
        <?php foreach ($courts as $court): ?>
            <div class="court-card">
                <div class="court-image">
                    <span class="court-icon">🏟️</span>
                    <span class="court-status <?php echo strtolower($court['status']); ?>">
                        <?php echo htmlspecialchars($court['status']); ?>
                    </span>
                </div>
                
                <div class="court-details">
                    <h3 class="court-name"><?php echo htmlspecialchars($court['name']); ?></h3>
                    
                    <p class="court-location"><?php echo htmlspecialchars($court['location']); ?></p>
                    
                    <div class="court-info">
                        <span class="court-price">EGP <?php echo htmlspecialchars($court['price']); ?>/hr</span>
                        
                        <span class="court-type"><?php echo htmlspecialchars($court['type']); ?></span>
                    </div>
                    
                    <div style="margin-top: 15px;">
                        <a href="<?php echo BASE_URL; ?>/courts/show/<?php echo (int)$court['id']; ?>" 
                           class="btn btn-primary" 
                           style="padding: 8px 15px; width: 100%; display: inline-block; text-align: center;">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No courts available at the moment.</p>
    <?php endif; ?>
</div>
  </div>
</section>

<section class="cta">
  <div class="container">
    <div class="cta-content">
      <h2 class="cta-title">Ready to Play?</h2>
      <div class="cta-buttons">
        <a href="#" class="btn btn-primary btn-large">Create Free Account</a>
      </div>
    </div>
  </div>
</section>