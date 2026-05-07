window.addEventListener("load", () => {

  // 🔐 LOGIN CHECK
  const user = localStorage.getItem("padelpro_current_user");

  if (!user) {
    alert("You must login first!");
    window.location.href = "login_signup.html";
    return;
  }

  // 📦 GET BOOKING DATA
  const booking = JSON.parse(localStorage.getItem("padelpro_booking"));

  if (!booking) {
    alert("No booking found!");
    window.location.href = "booking.html";
    return;
  }

  // 🧾 DISPLAY DATA
  document.getElementById("court").textContent = booking.court;
  document.getElementById("date").textContent = booking.date;
  document.getElementById("time").textContent = booking.time;
  document.getElementById("price").textContent = booking.price;

  // 💳 PAYMENT BUTTON
  document.getElementById("payBtn").addEventListener("click", () => {

    alert("Payment Successful 🎉 Booking Confirmed!");

    // clear booking
    localStorage.removeItem("padelpro_booking");

    // redirect
    window.location.href = "index.html";
  });

});