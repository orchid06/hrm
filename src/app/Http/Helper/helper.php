<?php


use App\Enums\KYCStatus;
use App\Enums\LeaveStatus;
use App\Enums\PriorityStatus;
use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use App\Models\Admin;
use App\Models\Admin\Currency;
use App\Models\Admin\Menu;
use App\Models\Admin\Page;
use App\Models\Core\Language;
use Illuminate\Support\Facades\Artisan;
use App\Models\Core\Setting;
use App\Models\Core\Translation;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\LazyCollection;

use App\Traits\Fileable;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;

class HelperClass
{
    use Fileable;
}


if (!function_exists('optimize_clear')) {
    function optimize_clear()
    {

        Artisan::call('optimize:clear');
    }
}


if (!function_exists('limit_words')) {
    function limit_words(string $text, int|string $limit): string
    {
        return Str::limit($text, $limit, $end = '...');
    }
}


if (!function_exists('trx_number')) {

    function trx_number(int $length = 12): string
    {

        $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}



if (!function_exists('limitText')) {

    /**
     * @param $text
     * @param $length
     * @return string
     */
    function limitText(string $text, int | string $length): string
    {
        return Str::limit($text, $length);
    }
}





if (!function_exists('site_settings')) {
    function site_settings(string  $key = null, mixed $default = null): string|array|null
    {

        $settings = Cache::remember('site_settings', 24 * 60, function () {
            return Setting::with(['file'])->pluck("value", 'key')->toArray();
        });

        try {
            if ((isset($settings[$key]) ||  isset(config('site_settings')[$key]))) return
                Arr::get($settings, $key, isset(config('site_settings')[$key])
                    ? config('site_settings')[$key]
                    : trans('default.no_result_found'));
        } catch (\Throwable $th) {
        }

        return $default;
    }
}


if (!function_exists('format_rand_keys')) {
    function format_rand_keys(): array
    {

        $keys  = [];

        try {
            $json_data   = json_decode(site_settings('rand_api_key'), true);
            $randKeys    = Arr::get($json_data, "keys", []);
            $randStatus  = Arr::get($json_data, "status", []);
            $keys        = (array_combine($randKeys, $randStatus));
        } catch (\Throwable $th) {
        }

        return  $keys;
    }
}



if (!function_exists('site_currencies')) {
    function site_currencies(): mixed
    {

        $currencies = Cache::remember('site_currencies', 24 * 60, function () {
            return Currency::active()->get();
        });

        return $currencies;
    }
}


if (!function_exists('system_users')) {
    function system_users(): mixed
    {

        $users = Cache::remember('system_users', 24 * 60, function () {
            return LazyCollection::make(function () {
                return User::active()->cursor();
            })->toArray();
        });


        return $users;
    }
}



if (!function_exists('get_appearance')) {

    function get_appearance(bool $is_arr = false, bool $sortable = true)
    {
        $sectionJson = resource_path('views/partials/appearance.json');
        $appearances = json_decode(file_get_contents($sectionJson), $is_arr ? true : false);
        if ($is_arr && $sortable)  ksort($appearances);
        return $appearances;
    }
}

if (!function_exists('site_logo')) {
    function site_logo(string  $key): string|array|object|null
    {

        $settings = Cache::remember('site_logos', 24 * 60, function () {
            return Setting::with(['file'])->whereIn("key", Arr::get(config('settings'), 'logo_keys', []))->get();
        });

        return ($settings->where('key', $key)->first());
    }
}


if (!function_exists('paginateNumber')) {
    function paginateNumber(int $default = 10)
    {
        return site_settings('pagination_number', $default);
    }
}


if (!function_exists('make_slug')) {
    function make_slug(mixed $text): mixed
    {
        $string  = preg_replace('/\s+/u', '-', trim(strtolower($text)));
        $string = preg_replace('/-+/', '-', $string);
        $string = trim($string, '-');
        $string = strtolower($string);
        return  $string;
    }
}



if (!function_exists('unauthorized_message')) {
    function unauthorized_message(string $message = 'Unauthorized access'): string
    {
        return translate($message);
    }
}

if (!function_exists('get_system_locale')) {
    function get_system_locale()
    {
        return session()->has('locale') ?  session()->get('locale') : App::getLocale();
    }
}



if (!function_exists('system_language')) {
    function system_language()
    {
        return Language::active()->get();
    }
}

if (!function_exists('get_translation')) {
    function get_translation(mixed $data, string $lang = null): mixed
    {
        $lang = $lang ? $lang : session()->get("locale");
        if ($data->$lang) return  $data->$lang;
        return $data->en;
    }
}


if (!function_exists('sortByMonth')) {
    function sortByMonth(array $data, bool $numFormat = false, int | array $default  = null): array
    {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $sortedArray = [];
        foreach ($months as $month) {
            $amount =  Arr::get($data, $month, $default ?? 0);

            switch (is_array($amount)) {
                case true:
                    $amount = collect($amount)->map(fn(int | float $value, string $key): int | float =>
                    $numFormat ? currency_conversion(number: round($value)) : round($value))->all();
                    break;

                default:
                    $amount = $numFormat ? currency_conversion(number: round($amount)) : round($amount);
                    break;
            }

            $sortedArray[$month] =  $amount;
        }
        return $sortedArray;
    }
}




if (!function_exists('diff_for_humans')) {
    function diff_for_humans(string  $date): string
    {
        return Carbon::parse($date)->diffForHumans();
    }
}


if (!function_exists('exchange_rate')) {


    function exchange_rate(mixed $currency, ?int $precision = null): int | float
    {

        $base    = base_currency();
        $amount  = $base->exchange_rate;

        try {
            $baseCurrency =  session()->get("currency") ??   $base;
            $exchangeRate = $baseCurrency->exchange_rate / ($currency ? $currency->exchange_rate : $baseCurrency->exchange_rate);
            $amount       = 1 / $exchangeRate;
        } catch (\Throwable $th) {
        }

        return  round_amount($amount, $precision ?? (int)site_settings('num_of_decimal'));
    }
}


if (!function_exists('convert_to_base')) {

    function convert_to_base(int | float $amount, int $precision = null, ?Currency $currency =  null): int | float
    {


        $fromRate    = $currency
            ? $currency->exchange_rate
            : session()->get("currency")->exchange_rate;

        $amountInUSD = $amount / $fromRate;

        return  round_amount($amountInUSD, $precision ?? (int)site_settings('num_of_decimal'));
    }
}


if (!function_exists('notificationMessage')) {

    function notificationMessage(array $tmpCodes, string $body, object $userinfo): string
    {

        return str_replace(
            array_map(function ($key) {
                return '{{' . $key . '}}';
            }, array_keys($tmpCodes)),
            array_values($tmpCodes),
            str_replace(["{{name}}", "{{message}}", "{{company_name}}", "{{phone}}", "{{email}}"], [@$userinfo->username ?: $userinfo->name, @$body, site_settings('site_name'), site_settings('phone'), site_settings('email')], site_settings('default_mail_template'))
        );
    }
}




if (!function_exists('base_currency')) {

    function base_currency(): Currency
    {
        $currencies = Cache::remember('base_currencies', 24 * 60, function () {
            return Currency::base();
        });
        return $currencies;
    }
}

if (!function_exists('round_amount')) {
    function round_amount(int | float $amount, int $precision  = 0): int|float
    {
        return round($amount, $precision);
    }
}



if (!function_exists('currency_conversion')) {

    function currency_conversion(int | float  $number, ?Currency $currency = null): int
    {

        $currency   = $currency ?? session()->get("currency");
        $number     = floatval($number) * floatval($currency->exchange_rate);



        return round($number);
    }
}




if (!function_exists('num_format')) {

    function num_format(int | float  $number, ?Currency $currency = null, mixed $decimal  = null, ?bool $calC = false, $symbol = true): string | int
    {

        $decimal    =   $decimal ?? (int)site_settings('num_of_decimal');

        $ds         =   site_settings('decimal_separator');
        $ts         =   site_settings('thousands_separator');
        $alignments =   array_flip(Arr::get(config('settings'), 'currency_alignment', []));



        $currency   = $currency ?? session()->get("currency");

        if ($calC) {
            $number  = floatval($number) * floatval($currency->exchange_rate);
        }
        $famount    = (number_format($number, $decimal, $ds, $ts));

        if ((site_settings('price_format') == StatusEnum::true->status()) && $number > site_settings('truncate_after')) {

            if ($number >= 1000000) {
                $famount  =  number_format($number, $decimal, $ds, $ts) . 'm';
            } elseif ($number >= 1000) {
                $famount  =  number_format($number / 1000, $decimal, $ds, $ts) . 'k';
            }
        }

        if (isset($alignments[site_settings('currency_alignment')]) && $currency && $symbol) {
            $famount = str_replace(['[symbol]', '[amount]'], [$currency->symbol, $famount], $alignments[site_settings('currency_alignment')]);
        }

        return $famount;
    }
}

if (!function_exists('truncate_price')) {
    function truncate_price(mixed  $number,  $decimal = null): string | int
    {


        $decimal    =   $decimal ?? (int)site_settings('num_of_decimal');
        $ds         =   site_settings('decimal_separator');
        $ts         =   site_settings('thousands_separator');
        $tnumber     =   number_format($number, $decimal, $ds, $ts);
        if ((site_settings('price_format') == StatusEnum::true->status()) && $number > site_settings('truncate_after')) {
            if ($number >= 1000000) {
                $tnumber  =  number_format($number, $decimal, $ds, $ts) . 'm';
            } elseif ($number >= 1000) {
                $tnumber  =  number_format($number / 1000, $decimal, $ds, $ts) . 'k';
            }
        }

        return $tnumber;
    }
}


if (!function_exists('k2t')) {
    function k2t(string $text): string
    {
        return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
    }
}

if (!function_exists('t2k')) {
    function t2k(string $text, ?string $replace = "_"): string
    {
        return strtolower(strip_tags(str_replace(' ', $replace, $text)));
    }
}






if (!function_exists('generateTicketNumber')) {
    function generateTicketNumber(): string
    {
        $randomNumber = uniqid(); // Generate a unique identifier based on the current time
        $ticketNumber = strtoupper(substr($randomNumber, 0, 8));
        return $ticketNumber;
    }
}






if (!function_exists('get_date_time')) {
    function get_date_time(string $date, ?string $format = null): string
    {
        $format = $format ?? site_settings("date_format", 'd M, Y') . " " . site_settings("time_format", 'h:i A');
        return Carbon::parse($date)->translatedFormat($format);
    }
}

if (!function_exists('generateOTP')) {

    function generateOTP(int $min = 100000, int $max = 999999): int
    {
        return rand($min, $max);
    }
}



if (!function_exists('translate')) {
    function translate(string | null $keyWord, string $lang_code = null): string
    {
        try {
            $lang_code = $lang_code ? $lang_code : App::getLocale();
            $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($keyWord)));
            $translate_data = Cache::remember('translations-' . $lang_code, now()->addHour(), function () use ($lang_code) {
                return Translation::where('code', $lang_code)->pluck('value', 'key')->toArray();
            });

            if (!array_key_exists($lang_key, $translate_data)) {
                $translate_val = str_replace(array("\r", "\n", "\r\n"), "", $keyWord);
                Translation::create([
                    'code' => $lang_code,
                    'key' => $lang_key,
                    'value' => $translate_val
                ]);
                $keyWord = $translate_val;
                Cache::forget('translations-' . $lang_code);
            } else {
                $keyWord = $translate_data[$lang_key];
            }
        } catch (\Throwable $th) {
        }

        return ucwords(strip_tags($keyWord));
    }
}


if (!function_exists('auth_user')) {

    function auth_user(string $guard = 'admin'): mixed
    {
        return auth()->guard($guard)->user();
    }
}


if (!function_exists('notify')) {

    function notify(string $key): bool
    {

        return site_settings($key)  == StatusEnum::true->status();
    }
}


if (!function_exists('response_status')) {
    function response_status(string $message = 'Sucessfully Completed', string $key = 'success'): array
    {
        return [
            $key =>  translate($message)
        ];
    }
}


if (!function_exists('is_demo')) {
    function is_demo(): bool
    {
        return strtolower(env('APP_MODE')) == 'demo' ? true : false;
    }
}






if (!function_exists('get_real_ip')) {
    function get_real_ip(): string
    {

        $ip = $_SERVER["REMOTE_ADDR"];

        if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        }
        if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        if ($ip == '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }
}


if (!function_exists('get_ip_info')) {
    function get_ip_info(): array
    {
        $ip = get_real_ip();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/xml.gp?ip=" . $ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            $xml = false;
        } else {
            $xml = simplexml_load_string($response);
        }

        $country  = $xml ? (string)$xml->geoplugin_countryName : "";
        $city     = $xml ? (string)$xml->geoplugin_city : "";
        $code     = $xml ? (string)$xml->geoplugin_countryCode : "";
        $long     = $xml ? (string)$xml->geoplugin_longitude : "";
        $lat      = $xml ? (string)$xml->geoplugin_latitude : "";

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "Unknown OS Platform";
        $os_array = array(
            '/windows nt 10/i'     => 'Windows 10',
            '/windows nt 6.3/i'    => 'Windows 8.1',
            '/windows nt 6.2/i'    => 'Windows 8',
            '/windows nt 6.1/i'    => 'Windows 7',
            '/windows nt 6.0/i'    => 'Windows Vista',
            '/windows nt 5.2/i'    => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'    => 'Windows XP',
            '/windows xp/i'        => 'Windows XP',
            '/windows nt 5.0/i'    => 'Windows 2000',
            '/windows me/i'        => 'Windows ME',
            '/win98/i'             => 'Windows 98',
            '/win95/i'             => 'Windows 95',
            '/win16/i'             => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'       => 'Mac OS 9',
            '/linux/i'             => 'Linux',
            '/ubuntu/i'            => 'Ubuntu',
            '/iphone/i'            => 'iPhone',
            '/ipod/i'              => 'iPod',
            '/ipad/i'              => 'iPad',
            '/android/i'           => 'Android',
            '/blackberry/i'        => 'BlackBerry',
            '/webos/i'             => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        $browser = "Unknown Browser";
        $browser_array = array(
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        $data = [
            'country'     => $country,
            'city'        => $city,
            'code'        => $code,
            'long'        => $long,
            'lat'         => $lat,
            'os_platform' => $os_platform,
            'browser'     => $browser,
            'ip'          => $ip,
            'time'        => date('d-m-Y h:i:s A')
        ];

        return $data;
    }
}



if (!function_exists('get_countries')) {


    function get_countries(): mixed
    {

        $countries = Cache::remember('countries', 24 * 60, function () {
            return  Country::active()->get();
        });

        return $countries;
    }
}


if (!function_exists('check_permission')) {

    function check_permission(string $accessPermission): bool
    {
        $status = true;

        if (auth_user() && auth_user()->super_admin == StatusEnum::false->status()) {

            $permissions            = (array)auth_user()->role->permissions;
            $permission_values      = [];
            foreach ($permissions as $permission) {
                $permission_values   = array_merge($permission_values, $permission);
            }
            if (!(in_array($accessPermission, $permission_values))) {
                $status              = false;
            }
        }

        return $status;
    }
}


if (!function_exists('sidebar_awake')) {

    function sidebar_awake(string | array $routes, string $type = null)
    {

        $class = '';
        if ((is_array($routes)
                && in_array(Route::currentRouteName(), $routes))
            || request()->routeIs($routes)
        ) $class = $type ? "show" : "active";

        return $class;
    }
}





//update env method
if (!function_exists('update_env')) {
    function update_env(string $key, string $newValue): void
    {
        $path = base_path('.env');
        $envContent = file_get_contents($path);

        if (preg_match('/^' . preg_quote($key, '/') . '=/m', $envContent)) {
            $envContent = preg_replace('/^' . preg_quote($key, '/') . '.*/m', $key . '=' . $newValue, $envContent);
        } else {
            $envContent .= PHP_EOL . $key . '=' . $newValue . PHP_EOL;
        }
        file_put_contents($path, $envContent);
    }
}



if (!function_exists('hexa_to_rgba')) {
    function hexa_to_rgba(string $code): string
    {
        list($r, $g, $b) = sscanf($code, "#%02x%02x%02x");
        return  "$r,$g,$b";
    }
}

if (!function_exists('get_superadmin')) {

    /**
     * Get superadmin
     *
     * @return Admin
     */
    function get_superadmin(): Admin
    {
        return Admin::with(['file'])->where('super_admin', StatusEnum::true->status())->first();
    }
}


if (!function_exists('imageURL')) {

    function imageURL(mixed $file, string $path, bool $size = false, ?string $foreceSize = null): string
    {
        $helper = new HelperClass();
        return $helper->getimageURL($file, $path, $size, $foreceSize);
    }
}


if (!function_exists('generateSecureApiKey')) {
    /**
     * Generate a highly secure API key.
     *
     * @param int $length
     * @return string
     */
    function generateSecureApiKey(int $length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_';

        $apiKey = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $apiKey .= $characters[random_int(0, $max)];

            if ($i > 0 && ($i + 1) % 4 === 0 && $i !== $length - 1) {
                $apiKey .= '-';
            }
        }

        $secureApiKey = hash('sha256', $apiKey);

        return $secureApiKey;
    }
}



if (!function_exists('translateable_locale')) {

    function translateable_locale(object  $languages): array
    {

        $localeArray = $languages->pluck('code')->toArray();
        usort($localeArray, function ($a, $b) {

            $systemLocale              = session()->get("locale");
            $systemLocaleIndex         = array_search($systemLocale, [$a, $b]);

            return $systemLocaleIndex === false ? 0 : ($systemLocaleIndex === 0 ? -1 : 1);
        });


        array_unshift($localeArray, "default");
        return $localeArray;
    }
}






if (!function_exists('ticket_status')) {
    function ticket_status(mixed  $status): string
    {
        $badges  = [
            TicketStatus::PENDING->value     => "warning",
            TicketStatus::OPEN->value        => "danger",
            TicketStatus::PROCESSING->value  => "info",
            TicketStatus::SOLVED->value      => "success",
            TicketStatus::HOLD->value        => "warning",
            TicketStatus::CLOSED->value      => "danger"
        ];

        $class    = Arr::get($badges, $status, 'info');
        $status   = ucfirst(t2k(Arr::get(array_flip(TicketStatus::toArray()), $status, 'Pending')));
        return "<span class=\"i-badge $class\">$status</span>";
    }
}


if (!function_exists('priority_status')) {
    function priority_status(mixed  $status): string
    {

        $badges  = [
            PriorityStatus::URGENT->value     => "danger",
            PriorityStatus::HIGH->value       => "warning",
            PriorityStatus::LOW->value        => "info",
            PriorityStatus::MEDIUM->value     => "success",

        ];
        $class    = Arr::get($badges, $status, 'info');
        $status   = ucfirst(t2k(Arr::get(array_flip(PriorityStatus::toArray()), $status, 'Pending')));
        return "<span class=\"i-badge $class\">$status</span>";
    }
}


if (!function_exists('kyc_status')) {
    function kyc_status(mixed  $status): string
    {

        $badges  = [

            KYCStatus::REQUESTED->value   => "warning",
            KYCStatus::APPROVED->value     => "success",
            KYCStatus::REJECTED->value     => "danger",

        ];

        $class    = Arr::get($badges, $status, 'info');
        $status   = ucfirst(t2k(Arr::get(array_flip(KYCStatus::toArray()), $status, 'Requested')));
        return "<span class=\"i-badge $class\">$status</span>";
    }
}

if (!function_exists('leave_status')) {
    function leave_status(mixed  $status): string
    {

        $badges  = [

            LeaveStatus::PENDING->value      => "warning",
            LeaveStatus::APPROVED->value     => "success",
            LeaveStatus::DECLINED->value     => "danger",

        ];

        $class    = Arr::get($badges, $status, 'info');
        $status   = ucfirst(t2k(Arr::get(array_flip(LeaveStatus::toArray()), $status, 'Pending')));
        return "<span class=\"i-badge $class\">$status</span>";
    }
}



if (!function_exists('get')) {
    function get($name, $default = null)
    {
        return request()->input($name, $default);
    }
}



if (!function_exists('get_default_img')) {
    function get_default_img(): string
    {
        return asset('assets/images/default/default.jpg');
    }
}

if (!function_exists('is_demo')) {
    function is_demo(): bool
    {
        return strtolower(env('APP_MODE')) == 'demo' ? true : false;
    }
}



if (!function_exists('recursiveDisplay')) {
    function recursiveDisplay(mixed $data, int $depth = 0): void
    {

        foreach ($data as $key => $value) {
            if (is_array($value) || is_object($value)) {
                echo str_repeat('    ', $depth) . "$key:\n";
                recursiveDisplay((array)$value, $depth + 1);
            } else {
                if (is_numeric($value) && $value == (int)$value) {
                    $value = (int)$value;
                }
                echo str_repeat('    ', $depth) . "$key: $value\n";
            }
        }
    }
}



if (!function_exists('array_to_object')) {


    /**
     * Convert array to object
     *
     * @param array $payload
     * @return object
     */
    function array_to_object(array $payload): object
    {
        return (object) $payload;
    }
}





if (!function_exists('get_appearance_img_size')) {

    /**
     * Convert array to object
     *
     * @param array $payload
     * @return object
     */
    function get_appearance_img_size(string $sectionKey, string $type, string $imgKey): string
    {
        return (@get_appearance()->{$sectionKey}->{$type}->images->{$imgKey}->size);
    }
}


if (!function_exists('isValidImageUrl')) {
    function isValidImageUrl($url)
    {
        if (!$url) return false;
        $headers = @get_headers($url);
        if (!$headers)  return false;

        $status = substr($headers[0], 9, 3);

        return ($status == "200");
    }
}



if (!function_exists('isValidVideoUrl')) {
    function isValidVideoUrl(string $path): bool
    {
        try {

            $streamOpts = [
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ]
            ];

            $headers = get_headers($path, 1, stream_context_create($streamOpts));
            if (!$headers) return false;

            $videoTypes = [
                "video/mp4",
                'video/quicktime' => 'mov'
            ];

            $fileType = NULL;

            if (isset($headers['Content-Type'])) $fileType = $headers['Content-Type'];

            if (isset($headers['content-type'])) $fileType = $headers['content-type'];

            if (in_array($fileType, $videoTypes))    return true;
        } catch (\Exception $e) {
        }

        return false;
    }
}


if (!function_exists('check_image')) {
    function check_image($path)
    {

        if (!file_exists($path))  return true;
        $imgSize = getimagesize($path);

        $imageType = null;
        if (!empty($imgSize)) $imageType = $imgSize[2];

        if (in_array($imageType, array(1, 2, 3, 6)))   return true;

        return false;
    }
}




if (!function_exists('hasFilter')) {

    /**
     * Summary of hasFilter
     * @param array $keys
     * @return bool
     */
    function hasFilter(array $filterKeys): bool
    {

        return !empty(array_intersect_key(array_flip($filterKeys), request()->query()));
    }
}



if (!function_exists('getCachedMenus')) {


    /**
     * Summary of getCachedMenus
     * @return Illuminate\Database\Eloquent\Collection
     */
    function getCachedMenus(): Collection
    {
        return  Cache::remember(
            'menus',
            24 * 60,
            fn(): Collection =>
            Menu::active()
                ->orderBy('serial_id')
                ->get()
        );
    }
}
if (!function_exists('getCachedPages')) {


    /**
     * Summary of getCachedPages
     * @return Illuminate\Database\Eloquent\Collection
     */
    function getCachedPages(): Collection
    {
        return  Cache::remember(
            'pages',
            24 * 60,
            fn(): Collection =>
            Page::active()
                ->orderBy('serial_id')
                ->get()
        );
    }
}






if (!function_exists('generateOperatingTimes')) {
    function generateOperatingTimes($intervalMinutes = 15)
    {
        $times = [];
        $startTime = Carbon::createFromTime(0, 0, 0);
        $endTime = $startTime->copy()->addDay();

        while ($startTime->lessThan($endTime)) {
            $times[] = $startTime->format('g:i A');
            $startTime->addMinutes($intervalMinutes);
        }

        return $times;
    }
}

if (!function_exists('formatTime')) {
    function formatTime($minutes)
    {
        if ($minutes < 60) {
            return $minutes . ' minutes';
        } else {
            $hours = floor($minutes / 60);
            $remainingMinutes = $minutes % 60;
            return $hours . ' hours ' . ($remainingMinutes > 0 ? $remainingMinutes . ' minutes' : '');
        }
    }
}

if(!function_exists('getDates')){
     function getDates($month, $year)
    {
        return collect(CarbonPeriod::create("$year-$month-01", '1 day', Carbon::create($year, $month)->endOfMonth()))
            ->map(fn($date) => (object)[
                'parse_date' => $date->format('d'),
                'original_format' => $date
            ])->all();
    }
}
