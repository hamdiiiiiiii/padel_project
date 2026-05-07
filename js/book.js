function goToReservation(court, price) {
  localStorage.setItem("court", court);
  localStorage.setItem("price", price);

  window.location.href = "reservation.html";
}