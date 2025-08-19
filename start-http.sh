#!/bin/bash

echo "🚀 Starting Laravel with HTTP support..."

# Restore HTTP .env configuration
cp .env.backup .env

# Stop Docker services and start only MySQL and phpMyAdmin
echo "📦 Stopping Docker services..."
docker compose down

echo "🔧 Starting minimal services (MySQL + phpMyAdmin only)..."
docker compose up -d mysql phpmyadmin

echo "✅ HTTP setup complete!"
echo ""
echo "🌐 Application URLs:"
echo "   Laravel App:  http://127.0.0.1:8000 (run: php artisan serve)"
echo "   phpMyAdmin:   http://localhost:8081"
echo "   Vite Dev:     http://127.0.0.1:5173 (run: npm run dev)"
echo ""
echo "📝 To start development:"
echo "   php artisan serve"
echo "   npm run dev (in another terminal)"
echo ""
echo "🛑 To stop services:"
echo "   docker compose down"
