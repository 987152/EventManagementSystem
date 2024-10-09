-- Drop existing tables if they exist
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS events;

-- Table for users
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for events
CREATE TABLE events (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Example Insert for Users (Add hashed passwords)
INSERT INTO users (username, email, password) VALUES
('admin', 'admin@example.com', 'password123'), -- password: 'password123'
('johndoe', 'johndoe@example.com', 'johnpassword'); -- password: 'johnpassword'

-- Example Insert for Events
INSERT INTO events (name, date, time, description) VALUES
('Conference 2024', '2024-10-15', '14:00:00', 'Annual conference for event planners.'),
('Wedding', '2024-12-05', '18:00:00', 'Wedding reception for John and Jane.'),
('Music Festival', '2025-01-12', '19:00:00', 'Music festival with various artists.');


-- For managing additional event data (if needed, e.g. event attendees)
DROP TABLE IF EXISTS attendees;

-- Table for attendees to manage event participants
CREATE TABLE attendees (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    event_id INT(11),
    user_id INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Example Insert for Attendees
INSERT INTO attendees (event_id, user_id) VALUES
(1, 1),
(2, 2);

-- Sample data for Events and Users with relationships through Attendees table

CREATE TABLE guests (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    rsvp_status ENUM('invited', 'accepted', 'declined') NOT NULL,
    event_id INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);


