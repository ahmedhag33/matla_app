<?php

use App\Service\Secure\PasswordGenerator;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
/*---------------------------------
| Create Custom Helper Function
------------------------------------*/

if (!function_exists('getCurrentLanguage')) {

    /**
     * get current language use in appliaction
     *
     * @return string
     */
    function getCurrentLanguage()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        return $lang;
    }
}

if (!function_exists('getIPAddress')) {

    /**
     * get ip address
     *
     * @return string
     */
    function getIPAddress()
    {
        if (isset($_SERVER['SERVER_ADDR'])) {
            $clientIP = $_SERVER['SERVER_ADDR'];
        }
        return $clientIP;
    }
}

if (!function_exists('getCurrentTime')) {

    /**
     * get currenttime
     *
     * @return string
     */
    function getCurrentTime()
    {
        $Carbon = new Carbon();
        $time = $Carbon->toTimeString();
        return $time;
    }
}
if (!function_exists('getCurrentDate')) {
    /**
     * get currentdate
     *
     * @return string
     */
    function getCurrentDate()
    {
        $Carbon = new Carbon();
        $date = $Carbon->toDateString();
        return $date;
    }
}

if (!function_exists('getURLLocalization')) {

    /**
     * GetURLLocalization
     *
     * @return string
     */
    function getURLLocalization($lang)
    {
        return LaravelLocalization::getLocalizedURL($lang);
    }
}

if (!function_exists('getAttributesWithCurrentLanguage')) {
    /**
     * get attributes with currentLanguage
     *
     * @return array
     */
    function getAttributesWithCurrentLanguage(array $fillable)
    {
        $result = [];
        $dash = '_';
        //$lang = GetCurrentLanguage();
        $lang = app()->getLocale();

        $array = array_filter($fillable, function ($value) {
            $result = strpos($value, '_ar');
            $result .= strpos($value, '_en');
            return $result == false;
        });

        foreach ($fillable as $value) {

            if (strstr($value, $dash . $lang)) {
                $replace_value = substr($value, 0, -3);
                $getvaluewithlang = $replace_value . $dash . $lang . ' as ' . $replace_value;
                $result[] = $getvaluewithlang;
                $select = array_merge($array, $result);
            }
        }
        return $select;
    }
}
if (!function_exists('uploads')) {
    /**
     * upload file to Storage
     *
     * @param $file , $path , $name is null
     *
     * return file name
     */
    function uploads($file, $path, $name = null)
    {
        $fileName = uniqid() . '-' . str_replace(' ', '-', $name) . '.' . $file->extension();
        Storage::disk('public')->put($path . $fileName, File::get($file));
        return $fileName;
    }
}

if (!function_exists('updateUpload')) {
    /**
     * upload file with update to Storage
     *
     * @param $file , $path , $filename
     *
     * return file name
     */
    function updateUpload($file, $fileName, $path)
    {
        Storage::disk('public')->put($path . $fileName, File::get($file));
        return $fileName;
    }
}

if (!function_exists('deleteFile')) {
    /**
     * delete file to Storage
     *
     * @param $file , $path
     *
     * return file name
     */
    function deleteFile($path, $fileName)
    {
        Storage::delete('public/images/' . $path . $fileName);
    }
}

if (!function_exists('fileSize')) {

    /**
     * get filesize
     *
     * @param $file , $precision
     *
     * return size
     */
    function fileSize($file, $precision = 2)
    {
        $size = $file->getSize();

        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        return $size;
    }
}

if (!function_exists('uploadWithOutStorage')) {
    /**
     * upload file WithOut Storage
     *
     * @param $file , $path , $name is null
     *
     * return file name
     */
    function uploadWithOutStorage($exe, $file)
    {

        $file_name = 'file-' . time() . uniqid() . '.' . $file->getClientOriginalExtension();
        $route = public_path($exe);
        $file->move($route, $file_name);
        return $file_name;
    }
}
if (!function_exists('dateFormat')) {
    /**
     * Method DateFormat
     *
     * @param mixed $date
     *
     * @return string
     */
    function dateFormat($date)
    {
        $newdate = date("d/m/Y", strtotime($date));

        return $newdate;
    }
}
if (!function_exists('timeFormat')) {
    /**
     * Method TimeFormat
     *
     * @param mixed $time
     *
     * @return string
     */
    function timeFormat($time)
    {
        $time = date('h:i A', strtotime($time));

        $arrEn = ['AM', 'PM'];

        $arrAr = ['صباحا', 'مساءأ'];

        if (GetCurrentLanguage() == 'ar') {
            $time = str_replace($arrEn, $arrAr, $time);
        }
        return $time;
    }
}
if (!function_exists('durationTime')) {
    /**
     * Method DurationTime
     *
     * @param mixed $time1
     *
     * @param mixed $time2
     *
     * @return string
     */
    function durationTime($time1, $time2)
    {
        $time1 = new DateTime($time1);

        $time2 = new DateTime($time2);

        $interval = $time1->diff($time2);
        if (GetCurrentLanguage() == 'ar') {

            $duration = $interval->format('%h ساعات %i دقيقة');

            $duration = str_replace("1 ساعات", "ساعة", $duration);

            $duration = str_replace("2 ساعات", "ساعتين", $duration);

            $duration = str_replace("0 ساعات", "", $duration);

            $duration = str_replace(" 2 دقيقة", "دقيتين", $duration);

            $duration = str_replace(" 1 دقيقة", "دقيقة", $duration);

            $duration = str_replace(" 4 دقيقة", "4 دقائق", $duration);

            $duration = str_replace(" 5 دقيقة", "5 دقائق", $duration);

            $duration = str_replace(" 6 دقيقة", "6 دقائق", $duration);

            $duration = str_replace(" 7 دقيقة", "7 دقائق", $duration);

            $duration = str_replace(" 8 دقيقة", "8 دقائق", $duration);

            $duration = str_replace(" 9 دقيقة", "9 دقائق", $duration);

            $duration = str_replace(" 10 دقيقة", "10 دقائق", $duration);

            $duration = str_replace(" 0 دقيقة", "", $duration);
        } else {
            $duration = $interval->format('%h hour %i min');

            $duration = str_replace(" 0 min", "", $duration);

            $duration = str_replace("0 hour", "", $duration);
        }
        return $duration;
    }
}
if (!function_exists('runTransaction')) {
    /**
     * Method RunTransaction
     *
     * @param callable $callback [explicite description]
     *
     * @return callable
     */
    function runTransaction(callable $callback)
    {
        DB::beginTransaction();

        try {
            $result = $callback();

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
if (!function_exists('createHash')) {
    /**
     * Create Hash Password
     *
     * @param mixed $value
     *
     * @return string
     */
    function createHash($value)
    {
        return Hash::make($value);
    }
}
if (!function_exists('passwordGenerator')) {
    /**
     * Password Generator
     *
     * @return string
     */
    function passwordGenerator()
    {
        return (new PasswordGenerator())->generate();
    }
}
if (!function_exists('clientRequest')) {
    /**
     * PSR-7 request implementation.
     *
     * @param string                               $method  HTTP method
     *
     * @param string                  $uri     URI
     *
     * @param array<string, string|string[]>       $headers Request headers
     *
     * @param string|resource|null $body    Request body
     *
     * @param string                               $version Protocol version
     *
     * @return object
     */
    function clientRequest(string $method, $uri, array $headers = [], $body = null, string $version = '1.1')
    {
        return (new Request($method, $uri, $headers, $body));
    }
}
if (!function_exists('client')) {
    /**
     * Method Client
     *
     * @return object
     */
    function client(array $config = [])
    {
        return (new Client($config));
    }
}
if (!function_exists('lastUrl')) {
    /**
     * Method LastUrl
     *
     * @param mixed $param
     *
     * @return string
     */
    function lastUrl($param = 'is_verify=0')
    {
        $url = session()->pull('url.intended');
        // check if url is null
        if (!$url) {
            return route('index-page') . '?' . $param;
        }
        // add separator
        $separator = str_contains($url, '?') ? '&' : '?';
        // retrun route
        return $url . $separator . $param;
    }
}
if (!function_exists('createToken')) {
    /**
     * Gentrate Token
     *
     * @param $length $length [explicite description]
     *
     * @return string
     */
    function createToken($length)
    {
        return str()->random($length);
    }
}
