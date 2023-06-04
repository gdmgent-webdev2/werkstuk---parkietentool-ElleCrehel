<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;
class ResetMembershipPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
{
    $users = User::whereNotNull('membership_paid_expires_at')->get();

    foreach ($users as $user) {
        $expiresAt = Carbon::parse($user->membership_paid_expires_at);

        if ($expiresAt->isPast()) {
            $user->membership_paid = null;
            $user->membership_paid_expires_at = null;
            $user->save();
        }
    }

    $this->info('Membership payment status reset successfully.');
}
}
