<?php

namespace Tests\Feature\Program;

use App\Models\ProgramBroadcastDays;
use Illuminate\Support\Carbon;
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
            ['الجمعة، ١٤ نوفمبر ٢٠٢٦'],
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
    #[DataProvider('arrayOfDatesIsExist')]
    /**
     * Test that the date is converted to the correct day and exists in the program's broadcast days.
     *
     * @dataProvider arrayOfDatesIsExist
     */
    public function test_date_to_day_exit_in_broadcast_program(string $input, bool $expected): void
    {
        $result = convertArabicDateToDatabase($input);
        // Convert the Arabic date to MySQL format and extract the day of the week/weekday name
        $day = strtolower(Carbon::parse($result)->format('l'));
        // Check if the program has a broadcast day matching the extracted day of the week
        $exists = ProgramBroadcastDays::where('program_id', self::PROGRAM_ID)
            ->where('day', $day)
            ->exists();
        // Assert that the program has a broadcast day matching the extracted day of the week
        $this->assertSame($expected, $exists);
    }
    /**
     * Data provider for test_date_to_day_exit_in_broadcast_program.
     *
     * @return array
     */
    public static function arrayOfDatesIsExist(): array
    {
        return [
            ['السبت، ٧ نوفمبر ٢٠٢٦', true],
            ['الأحد، ٨ نوفمبر ٢٠٢٦', true],
            ['الاثنين، ٩ نوفمبر ٢٠٢٦', true],
            ['الثلاثاء، ١٠ نوفمبر ٢٠٢٦', true],
            ['الجمعة، ١٣ نوفمبر ٢٠٢٦', false],
        ];
    }
    #[DataProvider('arabicDateTimes')]
    /**
     * @dataProvider arabicDateTimes
     */
    public function test_arabic_date_time_is_converted_to_mysql_format(string $date, string $time, string $expected): void
    {
        $input = $date . ' ' . $time;
        // Combine the Arabic date and time into a single string
        $result = convertArabicDateTimeToDatabase($input);
        // Assert that the converted date and time matches the expected MySQL format
        $this->assertSame($expected, $result);
    }
    /**
     * Data provider for test_arabic_date_time_is_converted_to_mysql_format.
     *
     * @return array
     */
    public static function arabicDateTimes(): array
    {
        return [
            ['السبت، ٧ نوفمبر ٢٠٢٦', '٩:٠٠ ص', '2026-11-07 09:00:00'],
            ['الأحد، ٨ نوفمبر ٢٠٢٦', '٢:١٥ م', '2026-11-08 14:15:00'],
            ['الإثنين، ٩ نوفمبر ٢٠٢٦', '١١:٤٥ ص', '2026-11-09 11:45:00'],
            ['الثلاثاء، ١٠ نوفمبر ٢٠٢٦', '٣:٠٠ م', '2026-11-10 15:00:00'],
            ['الأربعاء، ١١ نوفمبر ٢٠٢٦', '١٠:٣٠ ص', '2026-11-11 10:30:00'],
        ];
    }
    #[DataProvider('myFormatArabicDateTimes')]
    /**
     * @dataProvider myFormatArabicDateTimes
     */
    public function test_my_format_convert_to_arabic_date_time(string $input, string $expectDate, string $expectTime): void
    {
        $result = formatArabicDateTime($input);
        // Assert that the formatted Arabic date and time match the expected values
        $this->assertSame($expectDate, $result['air_date']);
        // Assert that the formatted Arabic time matches the expected value
        $this->assertSame($expectTime, $result['air_time']);
    }
    /**
     * Data provider for test_my_format_convert_to_arabic_date_time.
     *
     * @return array
     */
    public static function myFormatArabicDateTimes(): array
    {
        return [
            ['2026-11-07 09:00:00', 'السبت، ٧ نوفمبر ٢٠٢٦', '٠٩:٠٠ ص'],
            ['2026-11-08 14:15:00', 'الأحد، ٨ نوفمبر ٢٠٢٦', '٠٢:١٥ م'],
            ['2026-11-09 11:45:00', 'الاثنين، ٩ نوفمبر ٢٠٢٦', '١١:٤٥ ص'],
            ['2026-11-10 15:00:00', 'الثلاثاء، ١٠ نوفمبر ٢٠٢٦', '٠٣:٠٠ م'],
            ['2026-11-11 10:30:00', 'الأربعاء، ١١ نوفمبر ٢٠٢٦', '١٠:٣٠ ص'],
        ];
    }
}
