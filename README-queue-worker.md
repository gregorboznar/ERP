# Setting up Laravel Queue Workers

Your application uses Laravel's queue system to process exports and other background tasks. Here's how to set it up properly:

## Option 1: Using Supervisor (recommended for production)

1. Install Supervisor on macOS:

```bash
brew install supervisor
```

2. Link your configuration file:

```bash
ln -sf /Users/gregorboznar/ERP/config/supervisor/queue.conf /usr/local/etc/supervisor.d/
# or wherever your supervisor config directory is located
```

3. Start/restart supervisor:

```bash
brew services restart supervisor
```

4. Check the status:

```bash
supervisorctl status
```

## Option 2: Using a persistent queue worker (for development)

For development, you can simply run this command in a separate terminal window and keep it running:

```bash
cd /Users/gregorboznar/ERP
php artisan queue:work
```

## Option 3: Using cron to regularly process the queue (simple solution)

Add this to your crontab (`crontab -e`):

```
* * * * * cd /Users/gregorboznar/ERP && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

This will check for queued jobs every minute and process them.

## Troubleshooting

If you're still having issues with exports or other queued jobs, check these things:

1. Make sure the queue connection is configured in `.env`:

```
QUEUE_CONNECTION=database
```

2. Check the logs:

```
tail -f /Users/gregorboznar/ERP/storage/logs/worker.log
```

3. Manually process queued jobs:

```
php artisan queue:work --once
```
