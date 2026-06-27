<?php

namespace App\Console\Commands;

use App\Services\CustomerRequestStatusService;
use Illuminate\Console\Command;

class AutoCompleteCustomerRequests extends Command
{
    protected $signature = 'customer-requests:auto-complete';

    protected $description = 'Automatically complete accepted customer requests after 24 hours';

    public function handle(CustomerRequestStatusService $customerRequestStatusService): int
    {
        $completed = $customerRequestStatusService->autoCompleteAcceptedRequests();

        $this->info($completed . ' customer request(s) auto-completed.');

        return Command::SUCCESS;
    }
}
