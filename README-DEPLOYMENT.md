# 🚀 Baazaar Production Deployment

## Quick Start

### 1. Prepare Your Server
```bash
# SSH to your DigitalOcean droplet
ssh root@your-droplet-ip

# Create deployment user
adduser deployer
usermod -aG sudo deployer
su - deployer
```

### 2. Run Deployment
```bash
# Clone and deploy
git clone https://github.com/Rannamaari/baazaar.git /var/www/baazaar
cd /var/www/baazaar

# Install dependencies
sudo apt update && sudo apt install -y nginx php8.4-fpm php8.4-cli php8.4-pgsql \
  php8.4-xml php8.4-mbstring php8.4-curl php8.4-zip php8.4-gd php8.4-redis \
  redis-server supervisor certbot python3-certbot-nginx git curl

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Setup Laravel
composer install --no-dev --optimize-autoloader
cp .env.production .env

# Generate app key
php artisan key:generate

# Set permissions
sudo chown -R www-data:www-data /var/www/baazaar
sudo chmod -R 755 /var/www/baazaar
sudo chmod -R 775 /var/www/baazaar/storage /var/www/baazaar/bootstrap/cache
```

### 3. Configure Database
Edit `.env` file with your database credentials:
```bash
nano .env
```

Update these lines:
```env
DB_HOST=your-cluster-host.db.ondigitalocean.com
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Run Migrations
```bash
php artisan migrate --force
php artisan db:seed --class=MaldivesDataSeeder --force
php artisan db:seed --class=CategorySeeder --force
```

### 5. Configure Nginx
```bash
sudo nano /etc/nginx/sites-available/baazaar.mv
```

Add this configuration:
```nginx
server {
    listen 80;
    server_name baazaar.mv www.baazaar.mv;
    root /var/www/baazaar/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/baazaar.mv /etc/nginx/sites-enabled/
sudo rm /etc/nginx/sites-enabled/default
sudo nginx -t && sudo systemctl reload nginx
```

### 6. Setup SSL
```bash
sudo certbot --nginx -d baazaar.mv -d www.baazaar.mv
```

### 7. Optimize & Finish
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Create admin user
php artisan make:filament-user
```

## 🎉 Done!
- Website: https://baazaar.mv
- Admin: https://baazaar.mv/admin

## Updates
```bash
cd /var/www/baazaar
git pull origin main
composer install --no-dev
php artisan migrate --force
php artisan optimize:clear && php artisan optimize
sudo systemctl reload php8.4-fpm nginx
```