#!/bin/bash

# ===================================================
# START VITE FOR LOGIN PAGE DEVELOPMENT
# ===================================================

echo "🚀 Starting Vite for Login Page Development..."
echo ""

# Check if node_modules exists
if [ ! -d "node_modules" ]; then
    echo "📦 Installing dependencies..."
    npm install
    echo ""
fi

# Clear Vite cache
echo "🧹 Clearing Vite cache..."
rm -rf node_modules/.vite
echo ""

# Start Vite development server
echo "🔥 Starting Vite development server..."
echo "📍 URL: http://localhost:5174"
echo "🔒 HTTPS: https://localhost:5174 (if configured)"
echo ""
echo "Press Ctrl+C to stop the server"
echo ""

npm run dev
