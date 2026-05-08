<<<<<<< HEAD
<?php

require_once __DIR__ . '/../core/Controller.php';

class BookingController extends Controller
{
    public function booking(): void
    {
        $this->render('booking/booking', [
            'activePage' => 'booking',
            'pageStyles' => ['css/book.css'],
        ]);
    }

    public function payment(): void
    {
        $this->render('payment/payment', [
            'activePage' => 'booking',
            'pageStyles' => ['css/payment.css'],
        ]);
    }

    public function reservation(): void
    {
        $this->render('reservation', [
            'activePage' => 'booking',
            'pageStyles' => ['css/reservation.css'],
        ]);
    }
=======
<?php

require_once __DIR__ . '/../core/Controller.php';

class BookingController extends Controller
{
    public function booking(): void
    {
        $this->render('booking/booking', [
            'activePage' => 'booking',
            'pageStyles' => ['css/book.css'],
        ]);
    }

    public function payment(): void
    {
        $this->render('payment/payment', [
            'activePage' => 'booking',
            'pageStyles' => ['css/payment.css'],
        ]);
    }

    public function reservation(): void
    {
        $this->render('reservation', [
            'activePage' => 'booking',
            'pageStyles' => ['css/reservation.css'],
        ]);
    }
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
}