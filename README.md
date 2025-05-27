# BreeCafe Database Management System

Welcome to the BreeCafe Database project! ☕  
This is a complete database system designed for managing the operations of BreeCafe, including customers, orders, employees, inventory, and more.

---

## 📌 Project Overview

**BreeCafe** is a mock cafe management system built as part of a database course project. The main goal is to demonstrate relational database design using MySQL and simulate real-world operations of a cafe.

---

## 🗂️ Features

- Customer and order management  
- Menu items with category handling  
- Employee assignments and roles  
- Feedback collection  
- Inventory tracking with alternate and primary stock  
- Supplier and purchase history  
- Payment processing  

---

## 🛠️ Technologies Used

- **MySQL** for relational database
- **PHP (Optional)** for frontend interaction
- **XAMPP** for local server environment
- **phpMyAdmin** for database management

---

## 📋 ERD Overview

The system includes the following main entities:

- `Customer`
- `Employee`
- `Order`
- `MenuItem`
- `Category`
- `Inventory` and `Inventory_Alt`
- `Supplier`
- `Purchase`
- `Feedback`
- `Order_Items`, `OrderMenuItem` (for many-to-many relationships)
- `Branch`
- `CafeTables`
- `Review`
- `Payment`

*(ERD diagram can be viewed in the `/erd` folder.)*

---

## 🔧 Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/breecafe-database.git
