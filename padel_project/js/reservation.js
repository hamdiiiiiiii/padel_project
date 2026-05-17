let selectedTimes = [];
let selectedDate = "";

// Extract URL parameters
const urlParams = new URLSearchParams(window.location.search);
const courtId = parseInt(urlParams.get("court_id")) || 0;
const court = urlParams.get("court") || "Selected Court";
const pricePerHour = parseInt(urlParams.get("price")) || 400;

// UI setup
document.getElementById("courtName").innerText = court;
document.getElementById("courtPrice").innerText = "Price: EGP " + pricePerHour;

// Block past dates and dates further than 1 week
const dateInput = document.getElementById("dateInput");
const today = new Date();
dateInput.min = today.toISOString().split("T")[0];

const maxDate = new Date();
maxDate.setDate(today.getDate() + 7);
dateInput.max = maxDate.toISOString().split("T")[0];


// Generate time slots
const container = document.getElementById("slotsContainer");
let times = [
  "1 PM - 2 PM","2 PM - 3 PM","3 PM - 4 PM","4 PM - 5 PM","5 PM - 6 PM","6 PM - 7 PM",
  "7 PM - 8 PM","8 PM - 9 PM","9 PM - 10 PM","10 PM - 11 PM","11 PM - 12 PM",
  "12 AM - 1 AM","1 AM - 2 AM","2 AM - 3 AM"
];

const hourMapping = {
  "1 PM - 2 PM": 13, "2 PM - 3 PM": 14, "3 PM - 4 PM": 15, "4 PM - 5 PM": 16,
  "5 PM - 6 PM": 17, "6 PM - 7 PM": 18, "7 PM - 8 PM": 19, "8 PM - 9 PM": 20,
  "9 PM - 10 PM": 21, "10 PM - 11 PM": 22, "11 PM - 12 PM": 23,
  "12 AM - 1 AM": 0, "1 AM - 2 AM": 1, "2 AM - 3 AM": 2
};

function generateSlots(reservedHours = []) {
  container.innerHTML = '';
  times.forEach(time => {
    let div = document.createElement("div");
    div.classList.add("slot");
    div.innerText = time;
    
    let hour = hourMapping[time];
    if (reservedHours.includes(hour)) {
      div.classList.add("reserved");
      div.style.background = "rgba(220, 53, 69, 0.2)";
      div.style.borderColor = "#dc3545";
      div.style.color = "#dc3545";
      div.style.cursor = "not-allowed";
      div.title = "This slot is already reserved.";
    } else {
      if (selectedTimes.includes(time)) {
        div.classList.add("selected");
      }
      div.onclick = function () {
        toggleSlot(div, time);
      };
    }
    container.appendChild(div);
  });
}

// Initial generate
generateSlots();

// SLOT TOGGLE (MULTI SELECT)
function toggleSlot(element, time) {
  if (selectedTimes.includes(time)) {
    selectedTimes = selectedTimes.filter(t => t !== time);
    element.classList.remove("selected");
  } else {
    selectedTimes.push(time);
    element.classList.add("selected");
  }
  updateSummary();
}

// DATE
document.getElementById("dateInput").addEventListener("change", function () {
  selectedDate = this.value;
  selectedTimes = []; // Clear selections on date change
  updateSummary();
  
  if (selectedDate) {
      fetch(BASE_URL_JS + '/booking/check-availability?court_id=' + courtId + '&date=' + selectedDate)
        .then(response => response.json())
        .then(reservedHours => {
          generateSlots(reservedHours.map(Number));
        });
  } else {
      generateSlots();
  }
});


// SUMMARY
function updateSummary() {
  const totalPrice = selectedTimes.length * pricePerHour;

  document.getElementById("summaryCourtName").textContent = court;
  document.getElementById("summaryDate").textContent = selectedDate || "-";
  document.getElementById("summarySlots").textContent = selectedTimes.length ? selectedTimes.join(", ") : "-";
  document.getElementById("summaryPrice").textContent = "EGP " + totalPrice;
}

// GO TO PAYMENT
function goToPayment() {
  // prevent booking without login - checking the PHP session variable passed in views/reservation.php
  if (typeof IS_LOGGED_IN !== 'undefined' && !IS_LOGGED_IN) {
    alert("You must login first to continue booking!");
    window.location.href = BASE_URL_JS + "/login";
    return;
  }

  // validation
  if (selectedTimes.length === 0 || !selectedDate) {
    alert("Please select date and at least one time slot!");
    return;
  }

  const bookingDateObj = new Date(selectedDate);
  const maxDateObj = new Date();
  maxDateObj.setDate(new Date().getDate() + 7);
  
  // Set hours to 0 to compare dates only
  bookingDateObj.setHours(0,0,0,0);
  maxDateObj.setHours(0,0,0,0);

  if (bookingDateObj > maxDateObj) {
    alert("Reservations are only allowed up to 1 week in advance!");
    return;
  }


  const totalPrice = selectedTimes.length * pricePerHour;
  
  // Extract start_time and end_time (assuming consecutive slots, or just passing the first and last bounds)
  const firstSlot = selectedTimes[0].split(' - ');
  const lastSlot = selectedTimes[selectedTimes.length - 1].split(' - ');
  const startTime = firstSlot[0];
  const endTime = lastSlot[1];

  const params = new URLSearchParams({
    court_id: courtId,
    court_name: court,
    date: selectedDate,
    start_time: startTime,
    end_time: endTime,
    price: totalPrice
  });

  window.location.href = BASE_URL_JS + "/payment?" + params.toString();
}