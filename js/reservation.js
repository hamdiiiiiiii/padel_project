let selectedTimes = [];
let selectedDate = "";

// Load court info
const court = localStorage.getItem("court");
const pricePerHour = parseInt(localStorage.getItem("price")) || 400;

// UI setup
document.getElementById("courtName").innerText = court;
document.getElementById("courtPrice").innerText = "Price: EGP " + pricePerHour;

// Block past dates
document.getElementById("dateInput").min = new Date().toISOString().split("T")[0];

// Generate time slots
const container = document.getElementById("slotsContainer");
let times = [
  "1 PM - 2 PM","2 PM - 3 PM","3 PM - 4 PM","4 PM - 5 PM","5 PM - 6 PM","6 PM - 7 PM",
  "7 PM - 8 PM","8 PM - 9 PM","9 PM - 10 PM","10 PM - 11 PM","11 PM - 12 PM",
  "12 AM - 1 AM","1 AM - 2 AM","2 AM - 3 AM"
];

times.forEach(time => {
  let div = document.createElement("div");
  div.classList.add("slot");
  div.innerText = time;
  div.onclick = function () {
    toggleSlot(div, time);
  };
  container.appendChild(div);
});

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
  updateSummary();
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
  const currentUser = localStorage.getItem("padelpro_current_user");

  // prevent booking without login
  if (!currentUser) {
    alert("You must login first to continue booking!");
    window.location.href = "login_signup.html";
    return;
  }

  // validation
  if (selectedTimes.length === 0 || !selectedDate) {
    alert("Please select date and at least one time slot!");
    return;
  }

  const bookingData = {
    court: court,
    date: selectedDate,
    time: selectedTimes.join(", "),
    price: selectedTimes.length * pricePerHour
  };

  localStorage.setItem("padelpro_booking", JSON.stringify(bookingData));
  window.location.href = "payment.html";
}