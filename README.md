# CI Demo Project

![CodeIgniter Logo](https://codeigniter.com/assets/images/ci-logo-big.png)

## Overview
**CI Demo Project** is a lightweight Content Management System (CMS) built with CodeIgniter 4. It provides essential CMS features, including user authentication, an admin panel, page management, a blog module, media management, and site settings.

---

## Features

### 🔐 User Authentication (Login, Logout, Register)
A secure authentication system to control access to the backend.
- **User Registration**: Users can sign up by providing a username, email, and password. ✅
- **User Login**: Users log in using their credentials. ✅
- **Password Hashing**: Secure password storage using `password_hash()`. ✅
- **Session Handling**: Sessions maintain logged-in users. ✅
- **User Roles**:
  - **Admin** – Full access to the CMS. ✅
  - **Editor** – Can manage content but not settings.
  - **User** – Can view content.
- **User Logout**: Secure logout functionality. ✅

### 🛠 Admin Panel (Dashboard & User Management)
A backend panel for administrators to manage the system.
- **Dashboard**:
  - View total users, total posts, and total pages. ✅
  - Recent activity logs.
- **User Management**:
  - Add, edit, update, and delete users. ✅
  - Assign different roles to users.
- **Authentication Controls**:
  - Restrict non-admin users from accessing the admin panel.

### 📄 Page Management (CRUD)
Manage static pages such as About Us, Contact, and Terms & Conditions.
- Create new pages (Title, Slug, Content, Status).
- Edit and update existing pages.
- Delete pages.
- Manage published/draft status.
- **SEO-Friendly URLs** (slug-based navigation).

### 📝 Blog Module (Posts, Categories & Comments)
A blog system where admins can publish articles.
- **Post Management (CRUD)**: Create, Read, Update, Delete blog posts.
- **Categories**: Assign posts to categories.
- **Comments**: Allow users to comment on blog posts.
- **SEO-Friendly URLs** (e.g., `/blog/my-first-post`).
- **Published/Draft Status**.

### 📂 Media Management (Upload Images & Files)
Upload and manage media files.
- Upload images, PDFs, and other files.
- File validation (only allow specific formats).
- Display uploaded images in blog posts/pages.
- Store files in `/uploads/` directory.
- Utilize **CodeIgniter 4’s File Uploading Library**.

### ⚙️ Site Settings (Basic Configuration)
Admins can configure basic site settings.
- Site Title.
- Site Description.
- Contact Email.
- Social Media Links.
- Logo Upload.

---

## 🚀 Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/yourusername/ci-demo-project.git
   ```

2. **Navigate to the project directory:**
   ```sh
   cd ci-demo-project
   ```

3. **Install dependencies:**
   ```sh
   composer install
   ```

4. **Set up the `.env` file and configure your database.**

5. **Run database migrations:**
   ```sh
   php spark migrate
   ```

6. **Start the development server:**
   ```sh
   php spark serve
   ```

7. **Access the application in your browser:**  
   👉 [http://localhost:8080](http://localhost:8080)

---

## 📜 License
This project is open-source and available under the [MIT License](LICENSE).

## 🤝 Contributing
Feel free to submit pull requests to enhance the project.

## 📬 Contact
For questions or support, reach out to **[your email]**.

---

✅ *Built with CodeIgniter 4 & ❤️ Open Source!*
