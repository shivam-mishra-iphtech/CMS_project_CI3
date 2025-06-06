
<p align="center">
  <img src="https://www.codeigniter.com/assets/icons/ci-logo.png" alt="CodeIgniter Logo" width="120">
  <h1 align="center">🚀 CMS Project with CodeIgniter 3</h1>
  <p align="center">
    <strong>A complete Content Management System</strong><br>
    User authentication, admin dashboard, page/blog management, and media handling
  </p>
  
  <p align="center">
    <a href="https://github.com/shivam-mishra-iphtech/CMS_project_CI3/tree/main">
      <img src="https://img.shields.io/badge/View-GitHub-success?logo=github" alt="GitHub">
    </a>
    <img src="https://img.shields.io/badge/CodeIgniter-3.x-orange?logo=codeigniter" alt="CI Version">
    <img src="https://img.shields.io/badge/PHP-7.4+-777BB4?logo=php" alt="PHP Version">
    <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?logo=mysql" alt="MySQL Version">
    <img src="https://img.shields.io/badge/License-MIT-blue" alt="License">
  </p>
</p>

---

## ✨ Live Preview

<h2>📸 Project Screenshots</h2>

<table>
  <tr>
    <td align="center">
      <img src="https://snipboard.io/wcePIM.jpg" alt="Admin Dashboard" width="400" height="500"><br/>
      <strong>Admin Dashboard</strong>
    </td>
    <td align="center">
      <img src="https://snipboard.io/ptsZVI.jpg" alt="Page List" width="400" height="500"><br/>
      <strong>Page List</strong>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://snipboard.io/Oq3lTs.jpg" alt="Edit Page Form" width="400" height="500"><br/>
      <strong>Edit Page Form</strong>
    </td>
    <td align="center">
      <img src="https://snipboard.io/38x2WG.jpg" alt="Media Files" width="400" height="500"><br/>
      <strong>Media Files</strong>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://snipboard.io/5ilpYU.jpg" alt="User Home Page" width="400" height="500"><br/>
      <strong>User Home Page</strong>
    </td>
    <td align="center">
      <img src="https://snipboard.io/UGK06H.jpg" alt="Blog List Page" width="400" height="500"><br/>
      <strong>Blog List Page</strong>
    </td>
  </tr>
</table>

---

## 🧰 Tech Stack

<div align="center">
  <img src="https://skillicons.dev/icons?i=php,codeigniter,mysql,html,css,bootstrap,jquery" alt="Tech Stack">
</div>

| Component       | Technology              |
|-----------------|-------------------------|
| **Backend**     | PHP 7.4+, CodeIgniter 3 |
| **Database**    | MySQL 5.7+             |
| **Frontend**    | Bootstrap 5, jQuery    |
| **Security**    | CSRF Protection, XSS Filtering |
| **Libraries**   | CI Session, Upload, Form Validation |

---

## 🔥 Key Features

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
  <div>
    <h3>🔐 User Authentication</h3>
    <ul>
      <li>Secure registration/login system</li>
      <li>Password hashing with bcrypt</li>
      <li>Role-based access control (Admin/User)</li>
      <li>Session management</li>
    </ul>
  </div>
  
  <div>
    <h3>📝 Content Management</h3>
    <ul>
      <li>Create/edit/delete pages</li>
      <li>WYSIWYG editor integration</li>
      <li>SEO-friendly URLs</li>
      <li>Draft/publish system</li>
    </ul>
  </div>
  
  <div>
    <h3>🖼️ Media Handling</h3>
    <ul>
      <li>Image/file uploads</li>
      <li>File type validation</li>
      <li>Thumbnail generation</li>
      <li>Organized media library</li>
    </ul>
  </div>
</div>

---

## 🛠️ Installation Guide

```bash
# Clone the repository
git clone https://github.com/shivam-mishra-iphtech/CMS_project_CI3.git

# Navigate to project directory
cd CMS_project_CI3

# Import database (adjust credentials)
mysql -u root -p database_name < database_dump.sql

# Set permissions
chmod -R 755 uploads
chmod 755 application/config
```

### Configuration:
1. Update `application/config/database.php` with your credentials
2. Set base URL in `application/config/config.php`
3. Configure email settings in `application/config/email.php`

---

## 📁 Project Structure

```
CMS_project_CI3/
├── application/
│   ├── config/       # Configuration files
│   ├── controllers/  # App logic (Admin.php, Auth.php)
│   ├── models/       # Database operations
│   ├── views/        # Templates and layouts
│   └── libraries/    # Custom libraries
├── assets/
│   ├── css/          # Custom styles
│   ├── js/           # JavaScript files
│   └── images/       # Static images
├── uploads/          # User uploaded media
├── system/           # CI core
└── index.php         # Front controller
```

---

## 🤝 How to Contribute

We welcome contributions! Here's how:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/your-feature`)
3. Commit your changes (`git commit -m 'Add awesome feature'`)
4. Push to the branch (`git push origin feature/your-feature`)
5. Open a Pull Request

For bug reports, please open an [issue](https://github.com/shivam-mishra-iphtech/CMS_project_CI3/issues).

---

## 📜 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

<p align="center">
  <em>Developed with ❤️ by Shivam Mishra</em><br>
  <a href="https://github.com/shivam-mishra-iphtech/CMS_project_CI3">
    <img src="https://img.shields.io/github/stars/shivam-mishra-iphtech/CMS_project_CI3?style=social" alt="GitHub Stars">
  </a>
  <a href="https://github.com/shivam-mishra-iphtech/CMS_project_CI3/fork">
    <img src="https://img.shields.io/github/forks/shivam-mishra-iphtech/CMS_project_CI3?style=social" alt="GitHub Forks">
  </a>
</p>
```
