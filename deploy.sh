set -e  

cd /home/jost/web/vkp.glab.si/public_html

git pull origin main
git reset --hard origin/main

composer install --no-dev --optimize-autoloader

npm install
npm run build

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan migrate --force
php artisan optimize

chown -R jost:jost storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
