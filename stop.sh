#!/bin/bash

echo "🛑 Stopping LaraPad environment..."
docker-compose down

#echo "🧹 Cleaning up dangling resources..."
# docker system prune -f --volumes

echo "✅ LaraPad has been stopped and cleaned!"
