// server.js
const express = require('express');
const bodyParser = require('body-parser');
const sqlite3 = require('sqlite3').verbose();
const cors = require('cors');

const app = express();
const PORT = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Initialize SQLite Database
const db = new sqlite3.Database('./members.db');

// Create members table if it doesn't exist (You can skip this if you already did it)
db.serialize(() => {
    db.run(`CREATE TABLE IF NOT EXISTS members (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        fname TEXT,
        sname TEXT,
        email TEXT,
        mobile TEXT,
        numcaps INTEGER,
        comment TEXT
    )`);
});

// Route to handle form submission
app.post('/submit', (req, res) => {
    const { inputFirstName, inputSurname, inputEmail4, inputMobile, NoOfPeople, exampleText } = req.body;

    // Insert data into the database
    db.run(`INSERT INTO members (fname, sname, email, mobile, numcaps, comment) VALUES (?, ?, ?, ?, ?, ?)`,
        [inputFirstName, inputSurname, inputEmail4, inputMobile, NoOfPeople, exampleText],
        function (err) {
            if (err) {
                return res.status(500).send("Error inserting data: " + err.message);
            }
            res.status(200).send("Reservation submitted successfully!");
        }
    );
});

// Start server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
