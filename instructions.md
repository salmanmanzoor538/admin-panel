# Project: Multipurpose Laravel Admin Dashboard & CMS
# Goal: Build a modern, attractive, and feature-rich Admin Panel template that can be sold on template marketplaces (ThemeForest, CodeCanyon, etc.)

---

## 🔹 Tech Stack & Rules
- Backend: Laravel 11
- Frontend: Blade + Tailwind CSS + Alpine.js
- Admin Panel: Filament + Livewire
- Interactivity: Livewire + Alpine.js (no Vue/React)
- Database: MySQL
- Code Style: PSR-12, Laravel best practices, use Repositories/Services where needed
- UI/UX: Minimal, responsive, light & dark mode, modern dashboard design with cards, charts, and widgets.

---

## 🔹 Folder Structure
- app/
  - Models/ (User, Role, Permission, Setting, Page, Post, Media, Notification, etc.)
  - Http/
    - Controllers/ (Admin, API, Auth)
    - Livewire/ (components for dashboard, forms, charts, etc.)
    - Requests/ (form validations)
  - Services/ (helper services like FileUploadService, NotificationService)
- database/
  - migrations/
  - seeders/
- resources/
  - views/
    - layouts/ (main.blade.php, admin.blade.php)
    - components/ (sidebar, navbar, footer, modal, etc.)
    - dashboard/ (index.blade.php, widgets.blade.php)
    - cms/ (pages, posts, categories, media)
    - auth/ (login, register, forgot-password)
- routes/
  - web.php
  - api.php
- config/
  - cms.php (custom CMS settings)
- public/
  - assets/ (images, css, js)

---

## 🔹 Required Features
### 1. Authentication
- Login, Register, Forgot Password
- Social Login (Google, Facebook)
- OTP/2FA option

### 2. User Management
- Users CRUD
- Roles & Permissions (spatie/laravel-permission)
- Activity Logs

### 3. Dashboard
- Analytics Widgets (users count, sales, revenue, orders)
- Charts (Filament Charts or Chart.js)
- Quick Actions (create user, add post, upload media)

### 4. CMS Module
- Pages CRUD
- Blog (Posts, Categories, Tags)
- Media Manager (upload, preview, delete, S3 support)

### 5. Settings
- Site Settings (name, logo, favicon)
- Profile Settings
- Notification Settings
- Theme Switcher (light/dark mode)

### 6. Notifications
- In-app notifications (Livewire real-time)
- Email notifications (Laravel mailables)

### 7. Extra Features
- Multi-language (Laravel localization + RTL support)
- File Upload (image cropper, file manager)
- Dark/Light Mode
- API Ready (Laravel API resources)
- CRUD Generator (Filament resources scaffolded)
- Pre-built Demo Dashboards (E-commerce, CRM, Analytics)

---

## 🔹 Design Rules
- Responsive with Tailwind CSS
- Sidebar navigation (collapsible + icons)
- Top navigation bar with search, profile, notifications
- Dashboard cards with hover effects
- Gradient colors & glassmorphism option
- Smooth transitions with Alpine.js

---

## 🔹 Coding Guidelines
1. Always use **Filament Resources** for CRUD (UserResource, RoleResource, PageResource).
2. Use **Livewire components** for widgets and interactive parts.
3. Keep **Blade layouts** minimal → extendable for custom pages.
4. All code should be **commented** and **developer-friendly**.
5. Write **Seeder data** for demo content (users, roles, posts, etc.).
6. Use **config files** for reusable settings (like cms.php).
7. Every module must be **plug-and-play** (easy to remove or extend).
8. Follow **SOLID principles** in services and controllers.

---

## 🔹 Deliverables
1. Full Laravel project with Admin Dashboard + CMS
2. Demo data with seeders
3. Clear documentation (`README.md`)
4. Installation steps
5. Screenshots of demo dashboard
6. Ready-to-package for marketplaces

---

# END OF RULES
