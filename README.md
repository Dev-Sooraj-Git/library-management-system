# Library Management System

## Overview

This project is a Laravel-based Library Management System developed as part of a technical assignment.  
It demonstrates CRUD operations, relational database design, validation logic, and proper MVC architecture.

The application allows management of Authors and their Books with relational integrity and duplicate prevention.

---

## Features

### Author Management
- Create Author
- Edit Author
- Delete Author
- View Authors List

### Book Management
- Create Book with Author selection
- Edit Book
- Delete Book
- View Books List
- Prevent duplicate book titles for the same author

---

## Technical Stack

- Laravel 12
- PHP 8.2
- MySQL
- Blade Templating
- Eloquent ORM

---

## Database Structure

### authors table
- id
- name
- timestamps

### books table
- id
- title
- author_id (foreign key)
- timestamps
- Unique constraint on (author_id, title)

The unique constraint ensures the same author cannot have duplicate book titles.

---

## Implementation Details

- Resource controllers used for clean route handling
- Eloquent relationships implemented:
  - Author hasMany Books
  - Book belongsTo Author
- Form validation added for:
  - Required fields
  - Author existence
  - Duplicate prevention per author
- Foreign key constraints with cascade delete
- Clean MVC separation
- Proper RESTful routing

---

## Installation Steps

1. Clone the repository

   git clone <repository-url>

2. Navigate into the project directory

   cd library-management-system

3. Install dependencies

   composer install

4. Copy environment file

   cp .env.example .env

5. Generate application key

   php artisan key:generate

6. Configure database credentials inside the .env file

7. Run migrations

   php artisan migrate

8. Start the development server

   php artisan serve

---

## Notes

- The .env file is not included in version control.
- Database migrations must be executed before running the application.
- The project follows Laravel best practices for structure and validation.
