Got it! The issue is because GitHub doesn’t render SVG images hosted on Wikimedia in the way you expect sometimes, especially if the link is directly to the raw file. To fix this, and make the CI icon appear properly, you can either:


# 🚀 CI-DEMO-PROJECT

![CodeIgniter Logo](https://www.codeigniter.com/assets/images/codeigniter4logo.png)

> A mini CMS built with **CodeIgniter 3**, offering user authentication, admin dashboard, page and blog management, media handling, and more.

---

## 🧰 Tech Stack
- **Backend**: PHP (CodeIgniter 3)
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, Bootstrap
- **Libraries**: CI Upload Library, Session Library

---

## 🔐 1. User Authentication System
A secure login & registration module with proper session handling.

### ✅ Features:
- [x] User Registration  
- [x] Secure Login & Logout  
- [x] Password Hashing with `password_hash()`  
- [x] Session-based authentication  
- [x] Role-based access (Admin, Editor, User)

### 👥 User Roles:
- **Admin** – Full access  
- **Editor** – Manage content *(Coming Soon)*  
- **User** – View content  

---

## 🎛️ 2. Admin Panel

A backend interface for administrators.

### ✅ Features:
- [x] Dashboard: Total users, posts, pages  
- [x] User Management (Add, Edit, Delete)  
- [x] Role Assignment  
- [x] Authentication Control (Admin-only access)

---

## 📄 3. Page Management

CRUD operations for static pages like About Us, Contact, etc.

### ✅ Features:
- [x] Create/Edit/Delete Pages  
- [x] SEO-friendly slugs  
- [x] Draft & Publish status  
- [x] WYSIWYG Editor support  

---

## 📝 4. Blog Module

Post articles with categories and user comments.

### ✅ Features:
- [x] Create/Edit/Delete Blog Posts  
- [x] Category Management  
- [x] Comment System  
- [x] SEO URLs: `/blog/my-first-post`  
- [x] Publish/Draft Modes  

---

## 🖼️ 5. Media Management

Upload and manage media files for use in content.

### ✅ Features:
- [x] File Upload (images, PDFs)  
- [x] File Type Validation  
- [x] Display media in content  
- [x] Uses CodeIgniter’s Upload Library  
- [x] Files stored in `/uploads/`  

---

## ⚙️ 6. Site Settings

Basic site configuration handled via the admin panel.

### ✅ Features:
- [x] Site Title & Description  
- [x] Contact Email *(Coming Soon)*  
- [x] Social Media Links  
- [x] Logo Upload  

---

## 📁 Project Structure (CI 3)

```
application/
├── controllers/
├── models/
├── views/
├── libraries/
├── helpers/
system/
uploads/
index.php
.htaccess
```

---

## 🖼️ Screenshots

*(You can add screenshots here to make the README more visual)*



## 🙌 Contributions

Pull requests are welcome. For major changes, please open an issue first to discuss what you'd like to change.

---

## 📜 License

MIT © 2025 – [Your Name]

---

### Made with ❤️ using CodeIgniter 3
```
