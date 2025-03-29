#!/bin/bash

# Debug script for Excel Template Export issues
echo "==== Excel Template Export Debug Tool ===="
echo ""

# Check if PHPSpreadsheet library is installed
if [ -d "vendor/phpoffice/phpspreadsheet" ]; then
  echo "✅ PHPSpreadsheet library is installed"
else
  echo "❌ PHPSpreadsheet library is NOT installed"
  echo "   Run: composer require phpoffice/phpspreadsheet"
  echo ""
fi

# Check if template exists
TEMPLATE_PATH="storage/app/templates/scp_measurements_template.xlsx"
if [ -f "$TEMPLATE_PATH" ]; then
  echo "✅ Excel template exists at $TEMPLATE_PATH"
else
  echo "❌ Excel template does NOT exist"
  echo "   Run: php artisan app:create-scp-measurement-template"
  echo ""
fi

# Check queue configuration
QUEUE_CONN=$(grep "QUEUE_CONNECTION" .env | cut -d "=" -f2)
echo "🔍 Queue connection: $QUEUE_CONN"

# Check if queue workers are running
QUEUE_WORKERS=$(ps aux | grep "queue:work" | grep -v grep | wc -l)
if [ "$QUEUE_WORKERS" -gt "0" ]; then
  echo "✅ Queue workers are running ($QUEUE_WORKERS workers)"
else
  echo "❌ No queue workers are running"
  echo "   Run: php artisan queue:work &"
  echo ""
fi

# Check for failed jobs
echo "🔍 Checking for failed jobs..."
php artisan queue:failed | tail -n 5

# Check storage permissions
STORAGE_PATH="storage/app/private/filament_exports"
if [ -d "$STORAGE_PATH" ]; then
  echo "✅ Export directory exists"
  if [ -w "$STORAGE_PATH" ]; then
    echo "✅ Export directory is writable"
  else
    echo "❌ Export directory is NOT writable"
    echo "   Run: chmod -R 775 $STORAGE_PATH"
  fi
else
  echo "ℹ️ Export directory doesn't exist yet (will be created during export)"
fi

# Check recent errors in log
echo ""
echo "🔍 Recent errors in Laravel log:"
tail -n 20 storage/logs/laravel.log | grep -i "error\|exception\|fail" | grep -v "SQLSTATE" | tail -n 5

echo ""
echo "==== Debug checks completed ===="
echo "If issues persist, check README-excel-template-export.md for more troubleshooting steps." 