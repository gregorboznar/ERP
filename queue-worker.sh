#!/bin/bash

# Change to the project directory
cd /Users/gregorboznar/ERP

# Run the queue worker
php artisan queue:work

# This script should be run with:
# nohup ./queue-worker.sh > storage/logs/queue-worker.log 2>&1 & 