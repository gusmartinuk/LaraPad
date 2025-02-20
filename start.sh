#!/bin/bash

echo "🚀 Starting LaraPad environment..."
docker-compose up -d --build

# Optional: Check container status
echo "🔍 Checking container status..."
docker ps

echo "✅ LaraPad is up and running!"
