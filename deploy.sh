echo "//////////////////////////////////////////////"
echo "//                AntelopePHP               //"
echo "//        Advanced Deployment Script        //"
echo "//////////////////////////////////////////////"
echo ""
echo ""


# Start deployment
echo "🚀 Starting script deployment..."

# Turn on maintenance mode
echo "👷 Turning on maintenance mode..."
php artisan down

# Pull the latest changes from the git repository
# git reset --hard
# git clean -df
echo "🎖️ Pulling lastest changes from git repository..."
# git pull origin master
# echo -e "🟡 \e[30m\e[103m\e[1m[WARNING]\e[21m Git Repository fetching is turned off!\e[0m"

# Install/update composer dependecies
# composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
echo "💎 Installing and/or updating composer dependencies..."
composer install

# Run database migrations
echo "💾 Running database migrations..."
php artisan migrate --force

# Clear caches
echo "🗑️ Clearing application cache..."
php artisan cache:clear

# Clear expired password reset tokens
# echo -e "🔒 \e[32mClearing expired authentication memory tokens...\e[0m"
# php artisan auth:clear

# Clear and cache routes
# echo "🗑️ Clearing routes and resetting route cache..."
# php artisan route:clear
# php artisan route:cache

# Clear and cache config
echo "🗑️ Clearing configuration and resetting config cache..."
php artisan config:clear
php artisan config:cache

# Turn off maintenance mode
echo "👷 Turning off maintenance mode..."
php artisan up

echo "🏁 Deployment completed!"