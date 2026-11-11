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
    /**
     * Data provider for test_program_day_exists.
     *
     * @return array
     */
    public static function arrayOfDates(): array
    {
        return [
            ['السبت، ٧ نوفمبر ٢٠٢٦'],
            ['الأحد، ٨ نوفمبر ٢٠٢٦'],
            ['الاثنين، ٩ نوفمبر ٢٠٢٦'],
            ['الثلاثاء، ١٠ نوفمبر ٢٠٢٦'],
        ];
    }
    #[DataProvider('arabicDates')]
    /**
     * @dataProvider arabicDates
     */
    public function test_arabic_date_is_converted_to_mysql_format(string $input, string $expected): void
    {
        $result = convertArabicDateToDatabase($input);
        // Assert that the conversion result matches the expected MySQL date format
        $this->assertSame($expected, $result);
    }
    /**
     * Data provider for test_arabic_date_is_converted_to_mysql_format.
     *
     * @return array
     */
    public static function arabicDates(): array
    {
        return [
            ['الثلاثاء، ١٠ نوفمبر ٢٠٢٦', '2026-11-10'],
            ['الأربعاء، ١١ نوفمبر ٢٠٢٦', '2026-11-11'],
            ['الخميس، ١٢ نوفمبر ٢٠٢٦', '2026-11-12'],
            ['الجمعة، ١٣ نوفمبر ٢٠٢٦', '2026-11-13'],
        ];
    }
}
