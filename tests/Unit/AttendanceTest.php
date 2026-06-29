<?php

namespace Tests\Unit;

use App\Models\Attendance;
use App\Models\Gym;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_attendance_can_be_created(): void
    {
        $gym = Gym::factory()->create();
        $member = Member::factory()->create(['gym_id' => $gym->id]);

        $attendance = Attendance::create([
            'member_id' => $member->id,
            'gym_id' => $gym->id,
            'check_in' => Carbon::now(),
        ]);

        $this->assertDatabaseHas('attendances', [
            'member_id' => $member->id,
            'gym_id' => $gym->id,
        ]);
    }

    public function test_attendance_belongs_to_member(): void
    {
        $gym = Gym::factory()->create();
        $member = Member::factory()->create(['gym_id' => $gym->id]);

        $attendance = Attendance::factory()->create([
            'member_id' => $member->id,
            'gym_id' => $gym->id,
        ]);

        $this->assertInstanceOf(Member::class, $attendance->member);
    }

    public function test_attendance_belongs_to_gym(): void
    {
        $gym = Gym::factory()->create();
        $member = Member::factory()->create(['gym_id' => $gym->id]);

        $attendance = Attendance::factory()->create([
            'member_id' => $member->id,
            'gym_id' => $gym->id,
        ]);

        $this->assertInstanceOf(Gym::class, $attendance->gym);
    }
}
