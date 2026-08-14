<?php

namespace App\Console\Commands;

use App\Models\Quote;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('quotes:expire')]
#[Description('Expire quotes past their expiration date')]
class ExpireQuotes extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $count = Quote::whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->whereIn('status', ['draft', 'sent', 'viewed'])
            ->update(['status' => 'rejected']);

        $this->info("Expired {$count} quotes.");
    }
}
