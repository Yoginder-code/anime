const express = require('express');
const bodyParser = require('body-parser');
const sqlite3 = require('sqlite3').verbose();
const app = express();
const PORT = process.env.PORT || 3000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

const db = new sqlite3.Database('./anime_cafe.db');

// Endpoint to save user data
app.post('/submit', (req, res) => {
    const { firstName, surname, email, mobile, dob } = req.body;
    db.run(`INSERT INTO Users (first_name, surname, email, mobile, dob) VALUES (?, ?, ?, ?, ?)`,
        [firstName, surname, email, mobile, dob], function(err) {
            if (err) {
                return res.status(500).send(err.message);
            }
            res.send('User data saved successfully!');
        });
});

// Endpoint to save feedback
app.post('/feedback', (req, res) => {
    const { userId, message } = req.body;
    db.run(`INSERT INTO Feedback (user_id, message) VALUES (?, ?)`,
        [userId, message], function(err) {
            if (err) {
                return res.status(500).send(err.message);
            }
            res.send('Feedback saved successfully!');
        });
});

// Start server
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
