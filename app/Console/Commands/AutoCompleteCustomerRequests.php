<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoCompleteCustomerRequests extends Command
{
    protected $signature = 'customer-requests:auto-complete';

    protected $description = 'Customer request auto-complete is currently disabled';

    public function handle(): int
    {
        $this->info('Customer request auto-complete is currently disabled.');

        return Command::SUCCESS;
    }
}
