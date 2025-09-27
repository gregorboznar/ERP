

set -e  

echo "🚀 Starting Laravel deployment..."


cd /home/jost/web/vkp.glab.si/public_html

echo "📥 Pulling latest changes from GitHub..."
git pull origin main
git reset --hard origin/main

echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

echo "📦 Installing Node.js dependencies..."
npm install

echo "🔨 Building assets..."
npm run build

echo "🧹 Clearing Laravel caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "🗄️ Running database migrations..."
php artisan migrate --force

echo "⚡ Optimizing Laravel..."
php artisan optimize

echo "🔐 Setting proper permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "✅ Deployment completed successfully!"


echo "🎉 Your Laravel application has been deployed!"
