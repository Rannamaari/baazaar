#!/bin/bash

# =============================================================================
# Baazaar Production Deployment Script for DigitalOcean
# Run this script on your DigitalOcean droplet
#
# For automated deployment, set these environment variables:
# export DB_HOST="your-database-host"
# export DB_PORT="25060"
# export DB_DATABASE="baazaar"
# export DB_USERNAME="your-username"
# export DB_PASSWORD="your-password"
#
# Then run: ./deploy-to-server.sh
# =============================================================================

set -euo pipefail

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

DOMAIN="baazaar.mv"
APP_DIR="/var/www/baazaar"
REPO_URL="https://github.com/Rannamaari/baazaar.git"
PHP_VERSION="8.4"

log_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

log_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
    exit 1
}

confirm() {
    read -p "$1 (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        log_error "Operation cancelled"
    fi
}

check_system() {
    log_info "Checking system requirements..."
    
    if [[ $EUID -eq 0 ]]; then
        log_warning "Running as root. Creating non-root user recommended."
    fi
    
    if ! command -v apt &> /dev/null; then
        log_error "Ubuntu/Debian required"
    fi
    
    log_success "System check passed"
}

install_packages() {
    log_info "Installing required packages..."
    
    sudo apt update
    sudo apt install -y \
        nginx \
        php${PHP_VERSION}-fpm \
        php${PHP_VERSION}-cli \
        php${PHP_VERSION}-pgsql \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-zip \
        php${PHP_VERSION}-gd \
        php${PHP_VERSION}-redis \
        php${PHP_VERSION}-intl \
        php${PHP_VERSION}-bcmath \
        redis-server \
        supervisor \
        certbot \
        python3-certbot-nginx \
        git \
        curl \
        unzip
    
    # Install Composer
    if ! command -v composer &> /dev/null; then
        log_info "Installing Composer..."
        curl -sS https://getcomposer.org/installer | php
        sudo mv composer.phar /usr/local/bin/composer
        sudo chmod +x /usr/local/bin/composer
    fi
    
    log_success "Packages installed"
}

clone_repository() {
    log_info "Setting up repository..."
    
    if [ -d "$APP_DIR" ]; then
        log_info "Directory exists, updating..."
        cd "$APP_DIR"
        
        # Check if it's a git repository
        if [ -d ".git" ]; then
            git fetch origin
            git reset --hard origin/main
            git clean -fd
        else
            log_info "Not a git repository, removing and cloning fresh..."
            cd /var/www
            sudo rm -rf baazaar
            git clone "$REPO_URL" "$APP_DIR"
            cd "$APP_DIR"
        fi
    else
        sudo mkdir -p /var/www
        sudo chown $USER:$USER /var/www
        git clone "$REPO_URL" "$APP_DIR"
        cd "$APP_DIR"
    fi
    
    log_success "Repository ready"
}

setup_laravel() {
    log_info "Setting up Laravel application..."
    
    cd "$APP_DIR"
    
    # Install dependencies
    composer install --no-dev --optimize-autoloader --no-interaction
    
    # Setup environment
    if [ ! -f .env ]; then
        cp .env.production .env
        php artisan key:generate --no-interaction
    fi
    
    # Configure database credentials
    log_info "Configuring database credentials..."
    if [ -z "$DB_HOST" ]; then
        read -p "Database Host: " DB_HOST
    fi
    if [ -z "$DB_PORT" ]; then
        read -p "Database Port [25060]: " DB_PORT
        DB_PORT=${DB_PORT:-25060}
    fi
    if [ -z "$DB_DATABASE" ]; then
        read -p "Database Name: " DB_DATABASE
    fi
    if [ -z "$DB_USERNAME" ]; then
        read -p "Database Username: " DB_USERNAME
    fi
    if [ -z "$DB_PASSWORD" ]; then
        read -s -p "Database Password: " DB_PASSWORD
        echo
    fi
    
    # Ensure we're using PostgreSQL
    sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=pgsql|" .env
    sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST}|" .env
    sed -i "s|^DB_PORT=.*|DB_PORT=${DB_PORT}|" .env
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" .env
    sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|" .env
    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" .env
    sed -i "s|^DB_SSLMODE=.*|DB_SSLMODE=require|" .env
    
    # Clear config cache to ensure new settings are loaded
    php artisan config:clear
    
    # Show database configuration for debugging
    log_info "Database configuration:"
    echo "Connection: $(php artisan tinker --execute="echo config('database.default');")"
    echo "Host: $(grep "^DB_HOST=" .env | cut -d= -f2)"
    echo "Database: $(grep "^DB_DATABASE=" .env | cut -d= -f2)"
    
    # Test database connection
    log_info "Testing database connection..."
    if php artisan migrate:status; then
        log_success "Database connection successful"
    else
        log_error "Database connection failed"
    fi
    
    # Set permissions
    sudo chown -R $USER:www-data "$APP_DIR"
    sudo chmod -R 755 "$APP_DIR"
    sudo chmod -R 775 "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
    
    # Create storage link
    if [ ! -L "$APP_DIR/public/storage" ]; then
        php artisan storage:link
    fi
    
    log_success "Laravel setup complete"
}

setup_nginx() {
    log_info "Configuring Nginx..."
    
    sudo tee /etc/nginx/sites-available/$DOMAIN > /dev/null <<EOF
server {
    listen 80;
    listen [::]:80;
    server_name $DOMAIN www.$DOMAIN;
    root $APP_DIR/public;
    index index.php index.html;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        fastcgi_pass unix:/var/run/php/php${PHP_VERSION}-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    location ~ /\.(env|git) {
        deny all;
        return 404;
    }
}
EOF
    
    # Enable site
    sudo ln -sf /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
    sudo rm -f /etc/nginx/sites-enabled/default
    
    # Test and reload
    sudo nginx -t
    sudo systemctl reload nginx
    
    log_success "Nginx configured"
}

setup_ssl() {
    log_info "Setting up SSL certificate..."
    
    # Get SSL certificate
    sudo certbot --nginx -d $DOMAIN -d www.$DOMAIN --non-interactive --agree-tos --email admin@$DOMAIN
    
    # Setup auto-renewal
    sudo systemctl enable certbot.timer
    sudo systemctl start certbot.timer
    
    log_success "SSL certificate installed"
}

setup_database() {
    log_info "Running database migrations..."
    
    cd "$APP_DIR"
    
    # Run migrations
    php artisan migrate --force --no-interaction
    
    # Seed initial data
    php artisan db:seed --class=MaldivesDataSeeder --force --no-interaction || true
    php artisan db:seed --class=CategorySeeder --force --no-interaction || true
    php artisan db:seed --class=BrandSeeder --force --no-interaction || true
    php artisan db:seed --class=FeaturedCategoriesSeeder --force --no-interaction || true
    
    log_success "Database setup complete"
}

setup_supervisor() {
    log_info "Setting up queue workers..."
    
    sudo tee /etc/supervisor/conf.d/laravel-worker.conf > /dev/null <<EOF
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php $APP_DIR/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=$APP_DIR/storage/logs/worker.log
stopwaitsecs=3600
EOF
    
    sudo supervisorctl reread
    sudo supervisorctl update
    sudo supervisorctl start laravel-worker:*
    
    log_success "Queue workers configured"
}

optimize_application() {
    log_info "Optimizing application..."
    
    cd "$APP_DIR"
    
    # Clear and cache
    php artisan optimize:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
    
    # Optimize composer
    composer dump-autoload --optimize
    
    log_success "Application optimized"
}

setup_cron() {
    log_info "Setting up Laravel scheduler..."
    
    # Add to crontab if not exists
    (sudo crontab -l 2>/dev/null | grep -v "artisan schedule:run"; echo "* * * * * cd $APP_DIR && php artisan schedule:run >> /dev/null 2>&1") | sudo crontab -
    
    log_success "Scheduler configured"
}

create_admin() {
    log_info "Creating admin user..."
    
    cd "$APP_DIR"
    
    echo "Please provide admin user details:"
    read -p "Admin Name: " ADMIN_NAME
    read -p "Admin Email: " ADMIN_EMAIL
    read -s -p "Admin Password: " ADMIN_PASSWORD
    echo
    
    php artisan tinker --execute="
    \$user = App\Models\User::firstOrCreate([
        'email' => '$ADMIN_EMAIL'
    ], [
        'name' => '$ADMIN_NAME',
        'password' => Hash::make('$ADMIN_PASSWORD'),
        'email_verified_at' => now(),
    ]);
    echo 'Admin user created/updated: ' . \$user->email;
    "
    
    log_success "Admin user ready"
}

final_checks() {
    log_info "Running final checks..."
    
    # Check services
    for service in nginx php${PHP_VERSION}-fpm redis-server supervisor; do
        if sudo systemctl is-active --quiet $service; then
            log_success "$service is running"
        else
            log_error "$service is not running"
        fi
    done
    
    # Check website
    if curl -sf http://localhost > /dev/null; then
        log_success "Website is responding"
    else
        log_warning "Website might not be responding yet"
    fi
}

print_summary() {
    echo
    echo "=========================================="
    echo "🎉 Baazaar Deployment Complete!"
    echo "=========================================="
    echo
    echo "🌐 Website: https://$DOMAIN"
    echo "🔧 Admin Panel: https://$DOMAIN/admin"
    echo "📁 App Directory: $APP_DIR"
    echo
    echo "Next Steps:"
    echo "1. Point your domain DNS to this server's IP"
    echo "2. Test the website and admin panel"
    echo "3. Upload product images and configure categories"
    echo
    echo "Maintenance Commands:"
    echo "- Update: cd $APP_DIR && git pull && php artisan migrate && php artisan optimize"
    echo "- Logs: tail -f $APP_DIR/storage/logs/laravel.log"
    echo "- Restart workers: sudo supervisorctl restart laravel-worker:*"
    echo
    echo "🚀 Your e-commerce platform is ready!"
}

main() {
    echo "=========================================="
    echo "🚀 Baazaar Production Deployment"
    echo "Domain: $DOMAIN"
    echo "=========================================="
    echo
    
    confirm "This will deploy Baazaar to production. Continue?"
    
    check_system
    install_packages
    clone_repository
    setup_laravel
    setup_nginx
    setup_ssl
    setup_database
    setup_supervisor
    optimize_application
    setup_cron
    
    confirm "Would you like to create an admin user now?"
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        create_admin
    fi
    
    final_checks
    print_summary
}

# Run main function
main "$@"