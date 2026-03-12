#!/bin/bash
# Business Plan Generator — Setup Script
# Run this in your Laravel project root after copying all files

echo "========================================"
echo "  Business Plan Generator Setup"
echo "========================================"

# 1. Install PHP dependencies
echo ""
echo "[1/5] Installing Composer dependencies..."
composer install

# 2. Copy environment file
echo ""
echo "[2/5] Setting up environment..."
if [ ! -f .env ]; then
    cp .env.example .env
fi

# 3. Generate app key
echo ""
echo "[3/5] Generating application key..."
php artisan key:generate

# 4. Create storage link
echo ""
echo "[4/5] Creating storage symlink..."
php artisan storage:link

# 5. Create upload directories
echo ""
echo "[5/5] Creating upload directories..."
mkdir -p storage/app/public/uploads/logos
mkdir -p storage/app/public/uploads/photos
mkdir -p storage/fonts
chmod -R 775 storage bootstrap/cache

echo ""
echo "========================================"
echo "  ✅ Setup complete!"
echo ""
echo "  Start the server:"
echo "  php artisan serve"
echo ""
echo "  Then open: http://localhost:8000"
echo "========================================"
