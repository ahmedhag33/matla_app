<?php

namespace Tests\Feature\Program;

use App\Models\ProgramBroadcastDays;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProgramDayTest extends TestCase
{
    private const PROGRAM_ID = 14;

    #[DataProvider('arrayOfDates')]
    /**
     * @dataProvider arrayOfDates
     */
    public function test_program_day_exists(string $value): void
    {
        $day = trim(explode('،', $value)[0]);
        // Check if the episode's scheduled day is in the program's broadcast days
        $exists = ProgramBroadcastDays::where('program_id', self::PROGRAM_ID)
            ->get()
            ->contains('day_at_from_enum', $day);
        // Assert that the program has a broadcast day matching the current day
        $this->assertTrue($exists);
    }
    public static function arrayOfDates(): array
    {
        return [
            ['السبت، ٧ نوفمبر ٢٠٢٦'],
            ['الأحد، ٨ نوفمبر ٢٠٢٦'],
            ['الاثنين، ٩ نوفمبر ٢٠٢٦'],
            ['الثلاثاء، ١٠ نوفمبر ٢٠٢٦'],
        ];
    }
}
