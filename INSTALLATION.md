# 🚀 Installation Guide

This guide will help you set up the Laravel Admin Panel & CMS on your local development environment.

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2+** with extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Composer** (latest version)
- **MySQL 5.7+** or **MariaDB 10.3+**
- **Node.js 16+** and **NPM**
- **Git**

## 🛠️ Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/laravel-admin-panel.git
cd laravel-admin-panel
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the environment file and configure your settings:

```bash
cp .env.example .env
```

Edit the `.env` file with your database credentials:

```env
APP_NAME="Admin Panel"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin_panel
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create Database

Create a new MySQL database:

```sql
CREATE DATABASE admin_panel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Run Database Migrations

```bash
php artisan migrate
```

### 8. Seed the Database

This will create default users, roles, permissions, and sample content:

```bash
php artisan db:seed
```

### 9. Create Storage Link

```bash
php artisan storage:link
```

### 10. Build Frontend Assets

```bash
npm run build
```

### 11. Start the Development Server

```bash
php artisan serve
```

Your application will be available at `http://localhost:8000`.

## 🔑 Default Login Credentials

After running the seeders, you can login with these accounts:

| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@example.com | password |
| Admin | admin2@example.com | password |
| Editor | editor@example.com | password |
| Author | author@example.com | password |
| Contributor | contributor@example.com | password |
| Subscriber | subscriber@example.com | password |

## 🌐 Access Points

- **Frontend:** http://localhost:8000
- **Admin Panel:** http://localhost:8000/admin
- **API Documentation:** http://localhost:8000/api

## 🔧 Additional Configuration

### File Permissions

Ensure proper file permissions:

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Queue Configuration (Optional)

If you want to use queues for background jobs:

```bash
php artisan queue:work
```

### Cache Configuration

For better performance, use Redis or Memcached:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🐳 Docker Installation (Alternative)

If you prefer using Docker:

```bash
# Copy Docker configuration
cp docker-compose.example.yml docker-compose.yml

# Build and start containers
docker-compose up -d

# Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install

# Run migrations and seeders
docker-compose exec app php artisan migrate --seed

# Build assets
docker-compose exec app npm run build
```

## 🔍 Troubleshooting

### Common Issues

1. **Permission Denied Error**
   ```bash
   sudo chown -R $USER:$USER storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```

2. **Database Connection Error**
   - Verify database credentials in `.env`
   - Ensure MySQL service is running
   - Check if database exists

3. **Composer Memory Error**
   ```bash
   php -d memory_limit=-1 /usr/local/bin/composer install
   ```

4. **Node.js Build Error**
   ```bash
   npm cache clean --force
   rm -rf node_modules package-lock.json
   npm install
   ```

### Logs

Check application logs for errors:

```bash
tail -f storage/logs/laravel.log
```

## 📚 Next Steps

1. **Customize Settings:** Visit `/admin/settings` to configure your site
2. **Create Content:** Start adding posts, pages, and categories
3. **Configure Email:** Set up SMTP for email notifications
4. **Set Up Backups:** Configure database backups
5. **Deploy:** Follow the deployment guide for production

## 🆘 Support

If you encounter any issues:

1. Check the [FAQ](FAQ.md)
2. Search existing [Issues](https://github.com/your-username/laravel-admin-panel/issues)
3. Create a new issue with detailed information
4. Contact support at support@example.com

---

**Happy coding! 🎉**