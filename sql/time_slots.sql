<<<<<<< HEAD
CREATE TABLE IF NOT EXISTS time_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    court_id INT NOT NULL,
    slot_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    is_available TINYINT(1) NOT NULL DEFAULT 1,
    CONSTRAINT fk_time_slots_court
        FOREIGN KEY (court_id) REFERENCES courts(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY uq_court_slot (court_id, slot_date, start_time, end_time)
);
=======
CREATE TABLE IF NOT EXISTS time_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    court_id INT NOT NULL,
    slot_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    is_available TINYINT(1) NOT NULL DEFAULT 1,
    CONSTRAINT fk_time_slots_court
        FOREIGN KEY (court_id) REFERENCES courts(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY uq_court_slot (court_id, slot_date, start_time, end_time)
);
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
