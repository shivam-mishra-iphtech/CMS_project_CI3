<p align="center">
  <a href="#" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400">
  </a>
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Build-Passing-brightgreen.svg" alt="Build Status"></a>
  <a href="#"><img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="License"></a>
</p>

## 📌 About To-Do App

This **To-Do App** is a simple and efficient task management application built using the Laravel framework. It helps users manage daily tasks through an intuitive interface.

### 🔹 Key Features:

- **Task Management:**
  - Add new tasks.
  - Edit existing tasks.
  - Delete tasks.
  - Mark tasks as **Pending** or **Completed**.
- **User-Friendly Interface:**
  - Clean and responsive design using Bootstrap 5.
  - Interactive UI with SweetAlert notifications.
- **Real-Time Operations:**
  - AJAX-based task search functionality.
  - Instant updates without page reload.
- **Validation & Error Handling:**
  - Proper validation for form submissions.
  - Display success and error messages.
- **Database Integration:**
  - Uses MySQL for storing tasks.
  - Laravel Eloquent ORM for database operations.
- **Security Features:**
  - CSRF protection for form submissions.
  - Secure authentication (if user login is implemented).

---

## 🎥 Project Demo

[![To-Do App Demo Video](https://img.shields.io/badge/Watch%20Video-Demo-brightgreen)](https://www.loom.com/share/6fd7c1c2c8f1465da1b919900cc19185?sid=f9644177-5dd3-46f8-a24a-32c5c4b29819)

---

## 🚀 Installation & Setup

Follow these steps to set up the project locally:

1. **Clone the repository:**

   ```bash
   git clone https://github.com/yourusername/todo-app
   cd todo-app
   ```

2. **Install dependencies:**

   ```bash
   composer install
   npm install
   ```

3. **Create a `.env` file and configure your database:**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up the database and run migrations:**

   ```bash
   php artisan migrate
   ```

5. **Run the development server:**

   ```bash
   php artisan serve
   ```

6. **Access the application:**

   Open your browser and go to: [http://localhost:8000](http://localhost:8000)

---

## 📜 License
This project is open-source and available under the [MIT License](LICENSE).

## 🤝 Contributing
Feel free to submit pull requests to enhance the project.

## 📬 Contact
For questions or support, reach out to **[your email]**.

---

✅ *Built with Laravel & ❤️ Open Source!*
