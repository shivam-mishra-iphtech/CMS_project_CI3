
<p align="center">
  <img src="https://www.codeigniter.com/assets/icons/ci-logo.png" alt="CodeIgniter Logo" width="120">
  <h1 align="center">🚀 CI-DEMO-PROJECT</h1>
  <p align="center">
    <strong>A mini CMS built with CodeIgniter 3</strong><br>
    Featuring user authentication, admin dashboard, page/blog/media management, and more.
  </p>
  
  <p align="center">
    <img src="https://img.shields.io/badge/CodeIgniter-3.x-orange?logo=codeigniter" alt="CI Version">
    <img src="https://img.shields.io/badge/PHP-7.4+-777BB4?logo=php" alt="PHP Version">
    <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?logo=mysql" alt="MySQL Version">
    <img src="https://img.shields.io/badge/License-MIT-blue" alt="License">
  </p>
</p>

---

## ✨ Key Features

<div align="center">
  <table>
    <tr>
      <td align="center">
        <b>🔐 Auth System</b><br>
        Secure user authentication<br>with role-based access
      </td>
      <td align="center">
        <b>📝 Blog Engine</b><br>
        Full-featured blog with<br>categories and comments
      </td>
      <td align="center">
        <b>🖼️ Media Manager</b><br>
        File uploads with<br>validation and storage
      </td>
    </tr>
    <tr>
      <td align="center">
        <b>🎛️ Admin Panel</b><br>
        Powerful dashboard with<br>user/content management
      </td>
      <td align="center">
        <b>📄 Page Builder</b><br>
        Create/edit pages with<br>WYSIWYG editor
      </td>
      <td align="center">
        <b>⚙️ Site Config</b><br>
        Customize settings and<br>appearance
      </td>
    </tr>
  </table>
</div>

---

## � Tech Stack

<div align="center">
  <img src="https://skillicons.dev/icons?i=php,codeigniter,mysql,html,css,bootstrap" alt="Tech Stack">
</div>

| Component       | Technology              |
|-----------------|-------------------------|
| **Backend**     | PHP 7.4+, CodeIgniter 3 |
| **Database**    | MySQL 5.7+             |
| **Frontend**    | Bootstrap 5, HTML5     |
| **Libraries**   | CI Session, Upload     |

---

## 🛠️ Installation

```bash
# Clone repository
git clone https://github.com/yourusername/ci-demo-project.git

# Navigate to project
cd ci-demo-project

# Import database (adjust filename)
mysql -u username -p database_name < ci-demo-project.sql

# Configure files
nano application/config/database.php
nano application/config/config.php
```

### 🔧 Configuration
1. Set base URL in `config.php`
2. Update database credentials in `database.php`
3. Ensure `uploads/` directory is writable

---

## 📸 Screenshots

| Login Screen | Admin Dashboard | Page Editor |
|--------------|-----------------|-------------|
| <img src="screenshots/login.jpg" width="200"> | <img src="screenshots/dashboard.jpg" width="200"> | <img src="screenshots/editor.jpg" width="200"> |

---

## 🏗️ Project Structure

```bash
ci-demo-project/
├── application/
│   ├── config/       # Configuration files
│   ├── controllers/  # Application logic
│   ├── models/       # Database operations
│   ├── views/        # Presentation layer
│   └── ...           # Other CI directories
├── system/           # CI core files
├── uploads/          # User uploaded files
├── .htaccess         # URL rewriting
└── index.php         # Front controller
```

---

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📜 License

Distributed under the MIT License. See `LICENSE` for more information.

---

<p align="center">
  <em>Made with ❤️ using CodeIgniter 3</em><br>
  <a href="https://github.com/yourusername/ci-demo-project/stargazers">⭐ Star this project</a> | 
  <a href="https://github.com/yourusername/ci-demo-project/issues">🐛 Report Bug</a> | 
  <a href="https://github.com/yourusername/ci-demo-project/fork">⎘ Fork</a>
</p>
```

### Key Improvements:

1. **Added GitHub badges** for version and license info
2. **Visual feature grid** for quick overview
3. **Tech stack icons** using skillicons.dev
4. **Better installation guide** with code blocks
5. **Screenshot grid layout** (replace with actual images)
6. **ASCII directory tree** for project structure
7. **Enhanced footer** with GitHub actions
8. **Consistent emoji usage** for visual scanning
9. **Better tables** for tech stack comparison
10. **More prominent contribution section**

To use this:
1. Replace placeholder image paths with actual screenshots
2. Update GitHub URLs with your actual repository
3. Add your name to the license section
4. Consider adding a demo link if available
