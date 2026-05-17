<?php
/**
 * views/admin/generate_slots.php
 * Admin tool — bulk-generate time_slots rows for a date range.
 * Logic is handled by AdminController::generateSlots().
 */
?>
<section style="margin-top: 120px;">
    <div class="container">
        <div class="card" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
            <h1 style="margin-bottom: 1.5rem;">Generate Time Slots</h1>

            <?php if (!empty($error)): ?>
                <div style="
                    background: rgba(220,53,69,0.15);
                    border: 1px solid #dc3545;
                    border-radius: 8px;
                    padding: 12px 16px;
                    margin-bottom: 1.5rem;
                    color: #dc3545;
                ">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div style="
                    background: rgba(34,197,94,0.15);
                    border: 1px solid #22c55e;
                    border-radius: 8px;
                    padding: 12px 16px;
                    margin-bottom: 1.5rem;
                    color: #22c55e;
                ">
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo BASE_URL; ?>/admin/generate-slots">
                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label for="court_id" style="display:block; margin-bottom: .4rem; font-weight: 600;">
                        Court <span style="font-weight:400; opacity:.7;">(leave at "All" to generate for every court)</span>
                    </label>
                    <select name="court_id" id="court_id" class="form-control" style="width:100%; padding:.6rem .9rem; border-radius:8px; border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.07); color:inherit;">
                        <option value="0">All Courts</option>
                        <?php foreach ($courts as $court): ?>
                            <option value="<?php echo (int) $court['id']; ?>">
                                <?php echo htmlspecialchars($court['venue_name'] . ' - ' . $court['court_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label for="date_from" style="display:block; margin-bottom: .4rem; font-weight: 600;">From Date</label>
                    <input type="date" id="date_from" name="date_from" required
                           class="form-control"
                           style="width:100%; padding:.6rem .9rem; border-radius:8px; border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.07); color:inherit;">
                </div>

                <div class="form-group" style="margin-bottom: 1.8rem;">
                    <label for="date_to" style="display:block; margin-bottom: .4rem; font-weight: 600;">To Date</label>
                    <input type="date" id="date_to" name="date_to" required
                           class="form-control"
                           style="width:100%; padding:.6rem .9rem; border-radius:8px; border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.07); color:inherit;">
                </div>

                <p style="opacity:.65; font-size:.9rem; margin-bottom:1.2rem;">
                    Generates hourly slots from <strong>08:00 to 22:00</strong> for each selected day.
                    Existing slots are skipped (no duplicates).
                </p>

                <button type="submit" class="btn btn-primary" style="width:100%;">
                    Generate Slots
                </button>
            </form>

            <p style="margin-top: 1.5rem; text-align:center;">
                <a href="<?php echo BASE_URL; ?>/admin" style="opacity:.7;">← Back to Dashboard</a>
            </p>
        </div>
    </div>
</section>
