# To-Do List App

A native PHP To-Do List application powered by MySQL. This project provides a simple yet complete solution for task management, featuring CRUD operations, search by name, multiple sorting options, and JSON import/export functionality. The UI is built with [Bootstrap](https://getbootstrap.com/docs/5.3/getting-started/introduction/) for a responsive and modern experience.

## Table of Contents

- [Features](#features)
- [Project Structure](#project-structure)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)

## Features

- **CRUD Operations**: Create, Read, Update, and Delete tasks.
- **Search**: Filter tasks by name.
- **Sorting Options**:
  - Default sorting based on status & priority.
  - Sort tasks by date (ascending/descending).
- **JSON Import & Export**: Easily import and export task data in JSON format.
- **Responsive UI**: Built with [Bootstrap](https://getbootstrap.com/docs/5.3/getting-started/introduction/) to ensure a modern and responsive interface.

## Project Structure

```
todolist-php/
├── css/
│   └── bootstrap.min.css
├── js/
│   └── bootstrap.bundle.min.js
├── connection.php
├── create.php
├── delete.php
├── export.php
├── finish.php
├── import.php
├── index.php
├── script.sql         // Database and table creation script
└── update.php
```

## Requirements

- **PHP**: Minimum version **8.4.3**
- **MySQL**: Minimum version **8.0.30**

## Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/your-username/todolist-php.git
   cd todolist-php
   ```

2. **Setup the Database**

   - Import the `script.sql` file to create the database and tables. For example, using the MySQL command line:

     ```bash
     mysql -u your_username -p < script.sql
     ```

3. **Configure Database Connection**

   - Update the `connection.php` file with your MySQL credentials (host, username, password, and database name).

## Usage

For a quick and practical setup, run the built-in PHP server:

```bash
php -S localhost:8000
```

Open your browser and navigate to [http://localhost:8000](http://localhost:8000) to access the application.

## License

This project is licensed under the **MIT License**. See the [LICENSE](LICENSE) file for details.