<?php

namespace App\Console\Commands;

use App\Models\GymPlan;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        // La nouvelle date de début = lendemain de l'ancienne date de fin
        $newStartDate = Carbon::parse($plan->end_date)->addDay();

        // Si le plan est expiré depuis longtemps, on commence maintenant
        if ($newStartDate->isPast()) {
            $newStartDate = Carbon::now();
        }

        $duration = $plan->duration;

        // La nouvelle date de fin = nouvelle date de début + durée
        $newEndDate = $newStartDate->clone()->addMonths($duration);

        $plan->update([
            'start_date' => $newStartDate,
            'end_date' => $newEndDate,
            'status' => 'active',
            'due_date' => $newStartDate->clone()->addDays(7),
        ]);
    }
}
