<<<<<<< Updated upstream
function goToReservation(court, price) {
  localStorage.setItem("court", court);
  localStorage.setItem("price", price);

<<<<<<< HEAD
  window.location.href = "reservation.html";
=======
function goToReservation(court, price) {
  localStorage.setItem("court", court);
  localStorage.setItem("price", price);

  window.location.href = "reservation";
>>>>>>> Stashed changes
=======
  window.location.href = "reservation";
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
}