# Token Management System

A web-based token management platform built with PHP that allows users to create, manage, and track tokens for companies.

## Features

- **User Authentication** - Secure login and logout functionality
- **Dashboard** - Central hub for managing tokens and companies
- **Company Management** - Create and manage multiple companies
- **Token Management** - Create, view, and print tokens
- **Token Tracking** - View all issued tokens with details
- **Responsive Design** - Modern UI with responsive layouts

## Project Structure
token-ms/
├── index.html # Landing page
├── login.php # Login form
├── login_action.php # Login processing
├── logout.php # Logout functionality
├── dashboard.php # Main dashboard
├── companies.php # Company management page
├── company_ajax.php # AJAX for company operations
├── create_token.php # Token creation form
├── create_token2.php # Token creation processing
├── token_list.php # View all tokens
├── token_list_ajax.php # AJAX for token operations
├── print_token.php # Print token functionality
├── save_token.php # Save token data
├── sidebar.php # Navigation sidebar
├── assets/
│ ├── css/
│ │ └── style.css # Stylesheets
│ ├── js/
│ │ └── main.js # JavaScript functionality
│ └── fonts/
├── auth/
│ └── auth.php # Authentication logic
└── config/
└── db.php # Database configuration


## Requirements

- PHP 7.0 or higher
- MySQL/MariaDB
- Apache server (or similar)
- XAMPP (recommended for local development)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/token-ms.git
   cd token-ms
   Set up the database

Create a new MySQL database
Import the database schema (if available)
Update database credentials in config/db.php
Configure the database connection

Edit config/db.php with your database details
<?php
$host = "localhost";
$user = "your_db_user";
$password = "your_db_password";
$database = "your_db_name";

Deploy to XAMPP

Copy the project folder to C:\xampp\htdocs\token-ms
Start Apache and MySQL from XAMPP Control Panel
Access the application

Open your browser and go to http://localhost/token-ms/
Usage
Login
Navigate to the login page
Enter your credentials
Access the dashboard after successful authentication
Create Token
Click "Create Token" from the dashboard
Select a company
Fill in token details
Submit to create the token
View Tokens
Go to "Token List" to view all created tokens
Search or filter tokens as needed
Manage Companies
Access company management section
Add new companies or edit existing ones
API Endpoints
company_ajax.php - Company CRUD operations
token_list_ajax.php - Token operations via AJAX
Configuration
All configuration is centralized in config/db.php:

Database host
Database credentials
Database name
Security Features
User authentication required for most operations
Session management for user security
Database connection with prepared statements (recommended)
Browser Support
Chrome (latest)
Firefox (latest)
Safari (latest)
Edge (latest)

License
This project is licensed under the MIT License.

Author
Jkumar28

Support
For issues or questions, please create an issue in the repository. or mail us at "hardcoder80@gmail.com"
