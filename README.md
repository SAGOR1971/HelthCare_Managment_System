# Healthcare Management System

A comprehensive web-based healthcare management system that integrates medical store operations, doctor appointments, and patient management.

## Features

### 1. Medical Store Management
- Product catalog with categories (Medicine, Syrup, Equipment)
- Inventory tracking
- Price history tracking
- Shopping cart functionality
- Order management with reward points system

### 2. Doctor Appointment System
- Doctor profile management
- Appointment scheduling
- Real-time availability checking
- Appointment status tracking
- Payment processing
- Automatic refund system for cancellations

### 3. User Management
- User registration and authentication
- Profile management
- Reward points system
- Order history
- Appointment history
- Real-time notifications

### 4. Admin Dashboard
- Product management (Add, Edit, Delete)
- Doctor management
- User reports and analytics
- Order tracking
- Appointment monitoring
- About us page management

## Technical Details

### Database Structure
- User Management (`tbluser`)
- Product Management (`tblproduct`, `product_price_history`)
- Order Management (`tblorders`, `tblcart`)
- Doctor Management (`doctors`)
- Appointment Management (`tblappointments`)
- Reward System (`reward_point_history`)
- Notification System (`notifications`)

### Security Features
- Password protection
- Session management
- Access control for admin/user areas
- Secure payment processing

### Key Integrations
- Bootstrap for responsive design
- Font Awesome for icons
- Payment gateway integration
- Email notification system

## Installation

1. Clone the repository to your XAMPP htdocs folder
2. Import the `medical_store.sql` database
3. Configure database connection in `connect/config.php`
4. Access the application through your web browser

## Requirements

- PHP 8.2.12 or higher
- MySQL/MariaDB 10.4.32 or higher
- Web server (Apache recommended)
- Modern web browser

## Admin Access
Default admin credentials:
- Username: admin
- Password: admin123

## License

This project is proprietary and confidential.
