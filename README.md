# 🎓 Student Management System V2

A web-based student management system developed using **PHP**, **MySQL/MariaDB**, and **XAMPP**, designed to help admins efficiently manage student data and user authentication.

---

## 📁 Project Structure

```
Student_ManagementV2/
├── admin/                # Admin-related pages (login, dashboard, password reset)
├── config/               # Database configuration
├── includes/             # Reusable components and student operations
├── public/               # Public assets (CSS, uploads)
├── index.php             # Main entry page
├── README.md             # Project documentation
├── students.sql          # SQL script to create the database and tables
```

---

## 🚀 Features

- ✅ Admin Login & Logout (with hashed password)
- ✅ Student CRUD operations (Add, Edit, Delete, Search)
- ✅ Admin Password Reset via email
- ✅ Dashboard interface for admins
- ✅ Image upload support for student profiles
- ✅ Organized modular structure with includes
- ✅ Styled interface using custom CSS

---

## 🛠️ Technologies Used

- **PHP** (Procedural + PDO for DB connection)
- **MySQL/MariaDB**
- **HTML5 & CSS3**
- **XAMPP (Apache + MariaDB)**

---

## ⚙️ Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/lilo-luquena/student_management.git
```

### 2. Import the Database

1. Open **phpMyAdmin** via XAMPP.
2. Create a new database (e.g., `student_management`).
3. Import the `students.sql` file located in the root of the project.

### 3. Configure the Database

Update your database credentials in:

```
/config/db_connect.php
```

Example:

```php
$dsn = 'mysql:host=localhost;dbname=student_management';
$username = 'root';
$password = ''; // or your password
```

### 4. Run the Project

1. Move the project folder to `C:\xampp\htdocs\`.
2. Start **Apache** and **MySQL** in XAMPP.
3. Visit [http://localhost/Student_ManagementV2](http://localhost/Student_ManagementV2) in your browser.

---

## 🔐 Admin Access

> Admins must be added **internamente via banco de dados** ou por outro administrador autorizado.  
> A funcionalidade de cadastro externo foi desativada por segurança.

---

## 💡 To-Do / Future Improvements

- [ ] Add pagination to student list
- [ ] Add file type validation for image uploads
- [ ] Improve UI/UX with a CSS framework like Bootstrap or Tailwind
- [ ] Implement multi-user roles (e.g., MIS Manager, Sales Manager)

---

## 👩‍💻 Author

**Luciana Queiroz Nascimento**  
📍 Montreal, QC  
🚀 Passionate about education, development, and empowering systems

---

## 📄 License

This project is for educational purposes.
