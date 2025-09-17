#!/bin/bash

# =============================================================================
# Baazaar Docker Production Deployment Script
# Simple Docker-based deployment for DigitalOcean
# =============================================================================

set -euo pipefail

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

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

check_docker() {
    log_info "Checking Docker installation..."
    
    if ! command -v docker &> /dev/null; then
        log_info "Installing Docker..."
        curl -fsSL https://get.docker.com -o get-docker.sh
        sudo sh get-docker.sh
        sudo usermod -aG docker $USER
        rm get-docker.sh
    fi
    
    if ! command -v docker-compose &> /dev/null; then
        log_info "Installing Docker Compose..."
        sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
        sudo chmod +x /usr/local/bin/docker-compose
    fi
    
    log_success "Docker ready"
}

setup_environment() {
    log_info "Setting up environment variables..."
    
    # Create .env file if it doesn't exist
    if [ ! -f .env ]; then
        cp .env.production .env
    fi
    
    # Get database credentials
    if [ -z "${DB_HOST:-}" ]; then
        read -p "Database Host: " DB_HOST
    fi
    if [ -z "${DB_PORT:-}" ]; then
        read -p "Database Port [25060]: " DB_PORT
        DB_PORT=${DB_PORT:-25060}
    fi
    if [ -z "${DB_DATABASE:-}" ]; then
        read -p "Database Name: " DB_DATABASE
    fi
    if [ -z "${DB_USERNAME:-}" ]; then
        read -p "Database Username: " DB_USERNAME
    fi
    if [ -z "${DB_PASSWORD:-}" ]; then
        read -s -p "Database Password: " DB_PASSWORD
        echo
    fi
    
    # Generate app key if needed
    if ! grep -q "APP_KEY=" .env || [ "$(grep "^APP_KEY=" .env | cut -d= -f2)" = "" ]; then
        APP_KEY=$(docker run --rm php:8.4-cli php -r "echo 'base64:' . base64_encode(random_bytes(32));")
        sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
    fi
    
    # Export environment variables for docker-compose
    export APP_KEY=$(grep "^APP_KEY=" .env | cut -d= -f2)
    export DB_HOST
    export DB_PORT
    export DB_DATABASE
    export DB_USERNAME
    export DB_PASSWORD
    
    log_success "Environment configured"
}

deploy_application() {
    log_info "Deploying application with Docker..."
    
    # Stop existing containers
    docker-compose down || true
    
    # Pull latest images and build
    docker-compose pull
    docker-compose build --no-cache
    
    # Start services
    docker-compose up -d
    
    # Wait for application to be ready
    log_info "Waiting for application to start..."
    sleep 10
    
    # Run migrations
    log_info "Running database migrations..."
    docker-compose exec -T app php artisan migrate --force
    
    # Seed database
    log_info "Seeding database..."
    docker-compose exec -T app php artisan db:seed --class=MaldivesDataSeeder --force || true
    docker-compose exec -T app php artisan db:seed --class=CategorySeeder --force || true
    docker-compose exec -T app php artisan db:seed --class=BrandSeeder --force || true
    docker-compose exec -T app php artisan db:seed --class=FeaturedCategoriesSeeder --force || true
    
    # Optimize Laravel
    log_info "Optimizing Laravel..."
    docker-compose exec -T app php artisan config:cache
    docker-compose exec -T app php artisan route:cache
    docker-compose exec -T app php artisan view:cache
    docker-compose exec -T app php artisan storage:link
    
    log_success "Application deployed"
}

setup_ssl() {
    log_info "Setting up SSL with Caddy..."
    
    # Use production override with Caddy for SSL
    docker-compose -f docker-compose.yml -f docker-compose.prod.yml down || true
    docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
    
    log_success "SSL configured automatically"
}

create_admin() {
    log_info "Creating admin user..."
    
    echo "Please provide admin user details:"
    read -p "Admin Name: " ADMIN_NAME
    read -p "Admin Email: " ADMIN_EMAIL
    read -s -p "Admin Password: " ADMIN_PASSWORD
    echo
    
    docker-compose exec -T app php artisan make:filament-user --name="$ADMIN_NAME" --email="$ADMIN_EMAIL" --password="$ADMIN_PASSWORD"
    
    log_success "Admin user created"
}

final_checks() {
    log_info "Running final checks..."
    
    # Check if containers are running
    if docker-compose ps | grep -q "Up"; then
        log_success "Containers are running"
    else
        log_error "Some containers are not running"
    fi
    
    # Check if website responds
    sleep 5
    if curl -sf http://localhost/health > /dev/null 2>&1; then
        log_success "Website is responding"
    else
        log_warning "Website might not be responding yet"
    fi
}

print_summary() {
    echo
    echo "==========================================="
    echo "🎉 Baazaar Docker Deployment Complete!"
    echo "==========================================="
    echo
    echo "🌐 Website: https://baazaar.mv"
    echo "🔧 Admin Panel: https://baazaar.mv/admin"
    echo "🐳 Docker Status: docker-compose ps"
    echo
    echo "Useful Commands:"
    echo "- View logs: docker-compose logs -f"
    echo "- Restart: docker-compose restart"
    echo "- Update: git pull && docker-compose up -d --build"
    echo "- Laravel commands: docker-compose exec app php artisan <command>"
    echo
    echo "🚀 Your containerized e-commerce platform is ready!"
}

main() {
    echo "==========================================="
    echo "🐳 Baazaar Docker Deployment"
    echo "Domain: baazaar.mv"
    echo "==========================================="
    echo
    
    confirm "This will deploy Baazaar using Docker. Continue?"
    
    check_docker
    setup_environment
    deploy_application
    setup_ssl
    
    confirm "Would you like to create an admin user now?"
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        create_admin
    fi
    
    final_checks
    print_summary
}

# Run main function
main "$@"