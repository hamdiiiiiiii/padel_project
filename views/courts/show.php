<<<<<<< Updated upstream
<div class="card">
    <h1><?php echo htmlspecialchars($court['name'] ?? 'Court'); ?></h1>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($court['location'] ?? 'N/A'); ?></p>
    <p><strong>Price:</strong> <?php echo htmlspecialchars((string) ($court['price'] ?? 'N/A')); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($court['description'] ?? 'No description'); ?></p>
    <a href="<?php echo BASE_URL; ?>/courts">Back to courts</a>
</div>
=======
<section class="courts-preview" style="margin-top:120px;">
    <div class="container">
        <div class="court-card">
            <div class="court-details">
                <h1 class="court-name"><?php echo htmlspecialchars($court['name'] ?? 'Court'); ?></h1>
                <p class="court-location"><strong>Location:</strong> <?php echo htmlspecialchars($court['location'] ?? 'N/A'); ?></p>
                <p><strong>Price:</strong> <?php echo htmlspecialchars((string) ($court['price'] ?? 'N/A')); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($court['description'] ?? 'No description'); ?></p>

                <hr>
                <h3>Select date and time</h3>
                <div class="form-group">
                    <label for="slotDate">Date</label>
                    <input type="date" id="slotDate" class="form-control">
                </div>
                <div class="form-group">
                    <label>Available Slots</label>
                    <div id="slotsContainer" style="display:flex; flex-wrap:wrap; gap:8px;"></div>
                </div>

                <form method="GET" action="<?php echo BASE_URL; ?>/payment" id="bookNowForm">
                    <input type="hidden" name="court_id" value="<?php echo (int) ($court['id'] ?? 0); ?>">
                    <input type="hidden" name="court_name" value="<?php echo htmlspecialchars($court['name'] ?? ''); ?>">
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars((string) ($court['price'] ?? '0')); ?>">
                    <input type="hidden" name="date" id="selectedDate">
                    <input type="hidden" name="start_time" id="selectedStart">
                    <input type="hidden" name="end_time" id="selectedEnd">
                    <button type="submit" class="btn btn-primary" id="continueBtn" disabled>Continue to Payment</button>
                </form>

                <a href="<?php echo BASE_URL; ?>/courts">Back to courts</a>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    const dateInput = document.getElementById('slotDate');
    const slotsContainer = document.getElementById('slotsContainer');
    const selectedDate = document.getElementById('selectedDate');
    const selectedStart = document.getElementById('selectedStart');
    const selectedEnd = document.getElementById('selectedEnd');
    const continueBtn = document.getElementById('continueBtn');
    const courtId = <?php echo (int) ($court['id'] ?? 0); ?>;

    const today = new Date();
    const maxDate = new Date();
    maxDate.setDate(today.getDate() + 30);

    const toDate = (d) => d.toISOString().split('T')[0];
    dateInput.min = toDate(today);
    dateInput.max = toDate(maxDate);

    function clearSelection() {
        selectedDate.value = '';
        selectedStart.value = '';
        selectedEnd.value = '';
        continueBtn.disabled = true;
    }

    function renderSlots(slots) {
        slotsContainer.innerHTML = '';
        clearSelection();

        if (!slots.length) {
            slotsContainer.innerHTML = '<p>No available slots for this date.</p>';
            return;
        }

        slots.forEach((slot) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-outline slot-btn';
            btn.textContent = slot.label;
            btn.style.marginBottom = '8px';
            btn.addEventListener('click', () => {
                document.querySelectorAll('.slot-btn').forEach((b) => b.classList.remove('active'));
                btn.classList.add('active');
                selectedDate.value = dateInput.value;
                selectedStart.value = slot.start_time;
                selectedEnd.value = slot.end_time;
                continueBtn.disabled = false;
            });
            slotsContainer.appendChild(btn);
        });
    }

    dateInput.addEventListener('change', async function () {
        clearSelection();
        if (!this.value) {
            slotsContainer.innerHTML = '';
            return;
        }

        const url = '<?php echo BASE_URL; ?>/api/check-availability.php?court_id=' + courtId + '&date=' + encodeURIComponent(this.value);
        const res = await fetch(url);
        const data = await res.json();
        renderSlots(data.success ? data.slots : []);
    });
})();
</script>
>>>>>>> Stashed changes
