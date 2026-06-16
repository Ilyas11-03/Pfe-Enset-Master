<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GymPlan;
use Carbon\Carbon;

class RenewGymPlans extends Command
{
    protected $signature = 'gym:renew-plans';
    protected $description = 'Renew gym plans with auto renew enabled';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $plans = GymPlan::where('auto_renew', 1)
            ->where('end_date', '<', $now)
            ->get();

        foreach ($plans as $plan) {
            $this->renewPlan($plan);
        }

        $this->info('Gym plans renewed successfully.');
    }

    protected function renewPlan(GymPlan $plan)
    {
        $newStartDate = $plan->end_date->addDay();
        $duration = $plan->duration; // Use the same duration

        $newEndDate = $newStartDate->clone()->addMonths($duration);
        $plan->update([
            'start_date' => $newStartDate,
            'end_date' => $newEndDate,
            'status' => 'active', // Update status if needed
            'due_date' => $newStartDate->clone()->addDays(7), // Adjust due date
        ]);
    }
}
