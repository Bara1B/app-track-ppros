#!/bin/bash

echo "🚀 Starting Laravel with HTTPS support..."

# Copy HTTPS .env configuration
cp .env.docker .env

# Start Docker services
echo "📦 Starting Docker services..."
docker compose up -d

# Wait for services to be ready
echo "⏳ Waiting for services to start..."
sleep 10

# Run Laravel setup
echo "🔧 Setting up Laravel..."
sleep 15  # Wait longer for Laravel server to start
docker compose exec laravel php artisan key:generate --ansi
docker compose exec laravel php artisan migrate --force
docker compose exec laravel php artisan config:cache
docker compose exec laravel php artisan route:cache

echo "✅ HTTPS setup complete!"
echo ""
echo "🌐 Application URLs:"
echo "   Laravel App:  https://localhost"
echo "   phpMyAdmin:   http://localhost:8081"
echo "   Vite Dev:     https://localhost:5173"
echo ""
echo "📝 To start Vite development server:"
echo "   npm run dev"
echo ""
echo "🛑 To stop services:"
echo "   docker compose down"
