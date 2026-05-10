<?php

require_once __DIR__ . '/../Events/BookingEventEmitter.php';
require_once __DIR__ . '/../Events/Observers/AdminNotificationObserver.php';
require_once __DIR__ . '/../Events/Observers/UserConfirmationObserver.php';
require_once __DIR__ . '/../Events/Observers/EventLogObserver.php';

/**
 * BookingEmitterFactory
 *
 * Sole responsibility: construct and return a fully-wired
 * BookingEventEmitter with all registered observers attached.
 *
 * This is the only place in the codebase that knows which observers
 * exist and in what order they run.
 *
 * To add a new observer (e.g. SmsNotificationObserver):
 *   1. Create SmsNotificationObserver implements BookingObserver
 *   2. require_once it here
 *   3. Add $emitter->subscribe(new SmsNotificationObserver()) below
 *   Done — process.php requires zero changes.
 */
class BookingEmitterFactory
{
    /**
     * Build and return a BookingEventEmitter pre-loaded with all observers.
     *
     * @param  \PDO $db  Active database connection passed to DB-aware observers.
     * @return BookingEventEmitter
     */
    public static function create(\PDO $db): BookingEventEmitter
    {
        $emitter = new BookingEventEmitter();

        $emitter->subscribe(new AdminNotificationObserver($db));
        $emitter->subscribe(new UserConfirmationObserver($db));
        $emitter->subscribe(new EventLogObserver());

        return $emitter;
    }
}
