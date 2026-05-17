<?php
/**
 * views/about/index.php — About Us page template.
 * Served by HomeController::about() via GET /about.
 */
?>
<section class="about-hero" style="margin-top: 80px; padding: 80px 0 60px; background: radial-gradient(ellipse at 50% 0%, rgba(36,177,253,0.15) 0%, transparent 70%), #0a0a0f; text-align: center;">
    <div class="container">
        <h1 style="font-size: clamp(2.2rem, 5vw, 3.4rem); font-weight: 700; color: #fff; margin-bottom: 16px;">
            About <span style="background: linear-gradient(135deg, #24b1fd, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">PadelPro</span>
        </h1>
        <p style="font-size: 1.15rem; color: rgba(255,255,255,0.60); max-width: 560px; margin: 0 auto;">
            Revolutionizing the way padel players book courts across Egypt
        </p>
    </div>
</section>

<!-- Our Story -->
<section style="padding: 70px 0; background: #0d0d18;">
    <div class="container">
        <div style="max-width: 720px; margin: 0 auto; text-align: center;">
            <h2 class="section-title" style="margin-bottom: 28px;">Our <span style="color: #24b1fd;">Story</span></h2>
            <p style="color: rgba(255,255,255,0.65); line-height: 1.85; font-size: 1rem; margin-bottom: 18px;">
                Founded in 2024, PadelPro was born from a simple idea: make booking padel courts as easy as possible. We noticed that passionate padel players were wasting valuable time making phone calls, dealing with busy signals, and struggling to find available courts.
            </p>
            <p style="color: rgba(255,255,255,0.65); line-height: 1.85; font-size: 1rem;">
                Today, we've grown into Egypt's leading padel court booking platform, connecting thousands of players with premium courts across Cairo and beyond. Our mission is to grow the sport of padel by making it more accessible, convenient, and enjoyable for everyone.
            </p>
        </div>
    </div>
</section>

<!-- Mission / Vision / Values -->
<section style="padding: 70px 0; background: #0a0a0f;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 28px;">

            <?php
            $pillars = [
                ['icon' => 'fa-bullseye',  'color' => '#24b1fd', 'title' => 'Our Mission',
                 'text' => 'To simplify and enhance the padel experience by providing a seamless, reliable, and user-friendly booking platform that connects players with the best courts.'],
                ['icon' => 'fa-eye',        'color' => '#764ba2', 'title' => 'Our Vision',
                 'text' => 'To become the go-to platform for padel enthusiasts across the Middle East, fostering a vibrant community and growing the sport to new heights.'],
                ['icon' => 'fa-heart',      'color' => '#22c55e', 'title' => 'Our Values',
                 'text' => 'Excellence, innovation, community, and transparency guide everything we do. We put players first and strive for continuous improvement.'],
            ];
            foreach ($pillars as $p): ?>
            <div style="
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.09);
                border-radius: 20px;
                padding: 40px 32px;
                text-align: center;
                transition: transform 0.3s, border-color 0.3s;
            " onmouseover="this.style.transform='translateY(-6px)';this.style.borderColor='<?php echo $p['color']; ?>44'"
               onmouseout="this.style.transform='none';this.style.borderColor='rgba(255,255,255,0.09)'">
                <div style="
                    width: 70px; height: 70px;
                    background: <?php echo $p['color']; ?>22;
                    border: 1px solid <?php echo $p['color']; ?>44;
                    border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                    margin: 0 auto 24px;
                    font-size: 28px;
                    color: <?php echo $p['color']; ?>;
                ">
                    <i class="fas <?php echo $p['icon']; ?>"></i>
                </div>
                <h3 style="color: #fff; font-size: 1.2rem; font-weight: 600; margin-bottom: 14px;"><?php echo $p['title']; ?></h3>
                <p style="color: rgba(255,255,255,0.55); font-size: 0.93rem; line-height: 1.75;"><?php echo $p['text']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section style="padding: 70px 0; background: #0d0d18;">
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 50px;">
            <h2 class="section-title">Why Choose <span style="color: #24b1fd;">PadelPro?</span></h2>
            <p style="color: rgba(255,255,255,0.50); margin-top: 10px;">Experience the difference with Egypt's most trusted padel booking platform</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px;">
            <?php
            $features = [
                ['icon' => 'fa-clock',          'color' => '#24b1fd', 'title' => '24/7 Booking',      'text' => 'Book courts anytime, anywhere — no more waiting for business hours.'],
                ['icon' => 'fa-shield-alt',      'color' => '#22c55e', 'title' => 'Secure Payments',   'text' => 'Industry-standard encryption protects every transaction.'],
                ['icon' => 'fa-headset',         'color' => '#f59e0b', 'title' => '24/7 Support',      'text' => 'Our team is always ready to assist with any question or issue.'],
                ['icon' => 'fa-map-marker-alt',  'color' => '#f43f5e', 'title' => 'Best Locations',    'text' => 'Premium courts in prime locations across Cairo and beyond.'],
            ];
            foreach ($features as $f): ?>
            <div style="
                background: rgba(255,255,255,0.03);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 16px;
                padding: 32px 24px;
                text-align: center;
                transition: transform 0.25s, background 0.25s;
            " onmouseover="this.style.transform='translateY(-4px)';this.style.background='rgba(255,255,255,0.06)'"
               onmouseout="this.style.transform='none';this.style.background='rgba(255,255,255,0.03)'">
                <div style="font-size: 30px; color: <?php echo $f['color']; ?>; margin-bottom: 16px;">
                    <i class="fas <?php echo $f['icon']; ?>"></i>
                </div>
                <h4 style="color: #fff; font-size: 1rem; font-weight: 600; margin-bottom: 10px;"><?php echo $f['title']; ?></h4>
                <p style="color: rgba(255,255,255,0.50); font-size: 0.88rem; line-height: 1.65;"><?php echo $f['text']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section style="padding: 70px 0; background: #0a0a0f;">
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 50px;">
            <h2 class="section-title">What Our <span style="color: #24b1fd;">Players Say</span></h2>
            <p style="color: rgba(255,255,255,0.50); margin-top: 10px;">Don't just take our word for it</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
            <?php
            $testimonials = [
                ['quote' => '"PadelPro has completely changed how I book courts. So easy to use and never had any issues. Highly recommended!"',
                 'name' => 'Karim Hassan', 'role' => 'Regular Player'],
                ['quote' => '"The best platform for booking padel courts in Cairo. Their customer support is amazing and always helpful."',
                 'name' => 'Mona Tarek', 'role' => 'Competitive Player'],
                ['quote' => '"Love how easy it is to find available courts and book instantly. The real-time availability feature is a game-changer!"',
                 'name' => 'Youssef Amin', 'role' => 'Weekly Player'],
            ];
            foreach ($testimonials as $t): ?>
            <div style="
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.09);
                border-radius: 20px;
                padding: 32px;
            ">
                <div style="color: #f59e0b; margin-bottom: 16px; font-size: 14px; letter-spacing: 2px;">
                    ★★★★★
                </div>
                <p style="color: rgba(255,255,255,0.70); font-size: 0.93rem; line-height: 1.75; font-style: italic; margin-bottom: 22px;">
                    <?php echo $t['quote']; ?>
                </p>
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="
                        width: 42px; height: 42px;
                        background: linear-gradient(135deg, #24b1fd, #764ba2);
                        border-radius: 50%;
                        display: flex; align-items: center; justify-content: center;
                        font-weight: 700; color: #fff; font-size: 16px;
                    "><?php echo strtoupper(substr($t['name'], 0, 1)); ?></div>
                    <div>
                        <div style="color: #fff; font-weight: 600; font-size: 0.93rem;"><?php echo $t['name']; ?></div>
                        <div style="color: rgba(255,255,255,0.40); font-size: 0.82rem;"><?php echo $t['role']; ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section style="padding: 70px 0; background: linear-gradient(135deg, rgba(36,177,253,0.12), rgba(118,75,162,0.10)), #0d0d18; text-align: center;">
    <div class="container">
        <h2 style="color: #fff; font-size: 2rem; font-weight: 700; margin-bottom: 14px;">Ready to Play?</h2>
        <p style="color: rgba(255,255,255,0.55); margin-bottom: 32px; font-size: 1rem;">Book your court in seconds and get on the court faster.</p>
        <a href="<?php echo BASE_URL; ?>/booking" class="btn btn-primary" style="padding: 14px 40px; font-size: 1rem; border-radius: 50px;">
            Book a Court Now <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
        </a>
    </div>
</section>
