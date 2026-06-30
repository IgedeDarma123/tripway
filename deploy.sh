#!/bin/bash
# Manual deploy script (alternative to GitHub Actions)
# Usage: ./deploy.sh

set -e

SERVER="u966953872@145.223.108.79"
PORT="65002"
REMOTE_DIR="/home/u966953872/domains/tripwaytour.com/public_html"

echo "=== Deploy Tripway (manual) ==="

# Build assets
npm ci
npm run build

# Prepare flattened structure
rm -rf /tmp/deploy
mkdir -p /tmp/deploy

rsync -a --exclude='.git' --exclude='public' . /tmp/deploy/
rsync -a public/ /tmp/deploy/

# Fix index.php paths
sed -i \
  -e "s|__DIR__.'/\.\./vendor/|__DIR__.'/vendor/|g" \
  -e "s|__DIR__.'/\.\./bootstrap/|__DIR__.'/bootstrap/|g" \
  -e "s|__DIR__.'/\.\./storage/|__DIR__.'/storage/|g" \
  /tmp/deploy/index.php

# Sync to server
rsync -avz --delete \
  --exclude='.env' \
  --exclude='storage' \
  --exclude='vendor' \
  --exclude='node_modules' \
  --exclude='.git' \
  -e "ssh -p $PORT -o StrictHostKeyChecking=no" \
  /tmp/deploy/ \
  "$SERVER:$REMOTE_DIR"

# Server commands
ssh -p "$PORT" "$SERVER" "cd $REMOTE_DIR && \
  composer install --no-dev --optimize-autoloader --no-interaction && \
  php artisan migrate --force && \
  php artisan optimize:clear || true && \
  php artisan view:cache || true && \
  php artisan config:cache || true && \
  chmod -R 775 storage bootstrap/cache 2>/dev/null || true"

echo "=== DEPLOY SUCCESS ==="
