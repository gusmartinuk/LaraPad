#!/bin/bash

echo "🚀 Running Laravel Migrations..."
docker exec -it larapad_app bash -c "php artisan migrate --force"

echo "🛠️ Clearing Cache & Optimizing..."
docker exec -it larapad_app bash -c "php artisan optimize:clear"

echo "📦 Building Assets..."
docker exec -it larapad_app bash -c "npm run build"

echo "🔄 Restarting Docker Containers..."
docker-compose restart

echo "✅ Deployment Completed!"
