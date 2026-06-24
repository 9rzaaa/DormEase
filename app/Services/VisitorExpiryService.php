<?php

namespace App\Services;

use App\Models\AppSetting;
use App\Models\Staff;
use Carbon\Carbon;

class VisitorExpiryService
{
    public const SETTING_KEY = 'visitor_overnight_extend';

    public function defaultWindowHours(): int
    {
        return 24;
    }

    public function calculateExpiry(?Carbon $from = null): Carbon
    {
        $from = $from ?? now();
        $expiry = $from->copy()->addHours($this->defaultWindowHours());

        if (! AppSetting::isEnabled(self::SETTING_KEY)) {
            return $expiry;
        }

        if ($this->isStaffOnDutyAt($expiry)) {
            return $expiry;
        }

        $nextShiftStart = $this->nextShiftStartAfter($expiry);

        return $nextShiftStart ?? $expiry;
    }

    protected function isStaffOnDutyAt(Carbon $moment): bool
    {
        $shifts = Staff::whereNotNull('shift_start')
            ->whereNotNull('shift_end')
            ->where('is_active', true)
            ->get(['shift_start', 'shift_end']);

        if ($shifts->isEmpty()) {
            return true;
        }

        $timeOfDay = Carbon::createFromTimeString($moment->format('H:i:s'));

        foreach ($shifts as $shift) {
            $start = Carbon::createFromTimeString($shift->shift_start);
            $end   = Carbon::createFromTimeString($shift->shift_end);
            $isNightShift = $end->lessThan($start);

            $withinShift = $isNightShift
                ? ($timeOfDay->greaterThanOrEqualTo($start) || $timeOfDay->lessThan($end))
                : $timeOfDay->between($start, $end);

            if ($withinShift) {
                return true;
            }
        }

        return false;
    }

    protected function nextShiftStartAfter(Carbon $moment): ?Carbon
    {
        $shifts = Staff::whereNotNull('shift_start')
            ->where('is_active', true)
            ->pluck('shift_start')
            ->unique();

        if ($shifts->isEmpty()) {
            return null;
        }

        $candidates = [];

        foreach ($shifts as $shiftStart) {
            $candidate = $moment->copy()->setTimeFromTimeString($shiftStart);
            if ($candidate->lessThanOrEqualTo($moment)) {
                $candidate->addDay();
            }

            $candidates[] = $candidate;
        }

        sort($candidates);

        return $candidates[0] ?? null;
    }
}