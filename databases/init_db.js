const mysql = require('mysql2');

// Create connection to MySQL server
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',    // MySQL default username
  password: '',    // MySQL default password (blank for XAMPP)
});

// Connect to the MySQL server
connection.connect((err) => {
  if (err) {
    console.error('Error connecting to MySQL:', err.stack);
    return;
  }
  console.log('Connected to MySQL as id ' + connection.threadId);

  // Create the `anime_cafe` database if it doesn't exist
  connection.query(`CREATE DATABASE IF NOT EXISTS anime_cafe`, (err, result) => {
    if (err) {
      console.error('Error creating database:', err);
      return;
    }
    console.log('Database `anime_cafe` created or already exists.');

    // Switch to the `anime_cafe` database
    connection.changeUser({ database: 'anime_cafe' }, (err) => {
      if (err) {
        console.error('Error switching to anime_cafe:', err);
        return;
      }

      // Create the `reservations` table if it doesn't exist
      const createTableQuery = `
        CREATE TABLE IF NOT EXISTS reservations (
          id INT AUTO_INCREMENT PRIMARY KEY,
          first_name VARCHAR(255),
          surname VARCHAR(255),
          email VARCHAR(255),
          mobile VARCHAR(20),
          dob DATE,
          time TIME,
          no_of_people INT,
          message TEXT
        );
      `;

      connection.query(createTableQuery, (err, result) => {
        if (err) {
          console.error('Error creating table:', err);
          return;
        }
        console.log('Table `reservations` created or already exists.');
        connection.end(); // Close the connection after the operation
      });
    });
  });
});
