<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreatePrivateStorageLink extends Command
{
  protected $signature = 'storage:private-link';
  protected $description = 'Create the symbolic links for private storage';

  public function handle()
  {
    if (!file_exists(public_path('storage/private'))) {
      $this->call('storage:link');
      symlink(storage_path('app/private'), public_path('storage/private'));
      $this->info('Private storage link created successfully.');
    } else {
      $this->info('Private storage link already exists.');
    }
  }
}
