<?php

use App\Model\ActivityLog;
use App\Model\AdminSetting;
use App\Model\Buy;
use App\Model\Coin;
use App\Model\CountryPaymentMethod;
use App\Model\DepositeTransaction;
use App\Model\Escrow;
use App\Model\MembershipBonusDistributionHistory;
use App\Model\MembershipClub;
use App\Model\MembershipPlan;
use App\Model\Order;
use App\Model\Sell;
use App\Model\VerificationDetails;
use App\Model\Wallet;
use App\Model\WithdrawHistory;
use App\Services\CoinPaymentsAPI;
use App\User;
use Carbon\Carbon;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Jenssegers\Agent\Agent;
use Ramsey\Uuid\Uuid;
use App\Model\IcoPhase;


/**
 * @param $role_task
 * @param $my_role
 * @return int
 */
function checkRolePermission($role_task, $my_role)
{

    $role = Role::find($my_role);

    if (!empty($role->task)) {

        if (!empty($role->task)) {
            $tasks = array_filter(explode('|', $role->task));
        }

        if (isset($tasks)) {
            if ((in_array($role_task, $tasks) && array_key_exists($role_task, actions())) || (Auth::user()->user_type == USER_ROLE_SUPER_ADMIN)) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    return 0;
}

function previousMonthName($m){
    $months = [];
    for ($i=$m; $i >= 0; $i--) {
        array_push($months, date('F', strtotime('-'.$i.' Month')));
    }

    return array_reverse($months);
}
function previousYearMonthName(){

    $months = [];
    for ($i=0; $i <12; $i++) {

        array_push($months, Carbon::now()->startOfYear()->addMonth($i)->format('F'));
    }

    return $months;
}

function previousDayName(){
    $days = array();
    for ($i = 1; $i < 8; $i++) {
        array_push($days,Carbon::now()->startOfWeek()->subDays($i)->format('l'));
    }

    return array_reverse($days);
}
function previousMonthDateName(){
    $days = array();
    for ($i = 0; $i < 30; $i++) {
        array_push($days,Carbon::now()->startOfMonth()->addDay($i)->format('d-M'));
    }

    return $days;
}


/**
 * @param null $array
 * @return array|bool
 */
function allsetting($array = null)
{
    if (!isset($array[0])) {
        $allsettings = AdminSetting::get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } elseif (is_array($array)) {
        $allsettings = AdminSetting::whereIn('slug', $array)->get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } else {
        $allsettings = AdminSetting::where(['slug' => $array])->first();
        if ($allsettings) {
            $output = $allsettings->value;
            return $output;
        }
        return false;
    }
}

/**
 * @param null $input
 * @return array|mixed
 */

function addActivityLog($action,$source,$ip_address,$location){
    $return = false;
    if (ActivityLog::create(['action'=>$action,'user_id'=>$source,'ip_address'=>$ip_address,'location'=>$location]))
        $return = true;
    return $return;


}

function country($input=null){
    $output = [
        'af' => 'Afghanistan',
        'al' => 'Albania',
        'dz' => 'Algeria',
        'as' => 'American Samoa',
        'ad' => 'Andorra',
        'ao' => 'Angola',
        'ai' => 'Anguilla',
        'aq' => 'Antarctica',
        'ag' => 'Antigua and Barbuda',
        'ar' => 'Argentina',
        'am' => 'Armenia',
        'aw' => 'Aruba',
        'au' => 'Australia',
        'at' => 'Austria',
        'az' => 'Azerbaijan',
        'bs' => 'Bahamas',
        'bh' => 'Bahrain',
        'bd' => 'Bangladesh',
        'bb' => 'Barbados',
        'by' => 'Belarus',
        'be' => 'Belgium',
        'bz' => 'Belize',
        'bj' => 'Benin',
        'bm' => 'Bermuda',
        'bt' => 'Bhutan',
        'bo' => 'Bolivia',
        'ba' => 'Bosnia and Herzegovina',
        'bw' => 'Botswana',
        'br' => 'Brazil',
        'io' => 'British Indian Ocean Territory',
        'bn' => 'Brunei',
        'bg' => 'Bulgaria',
        'bf' => 'Burkina ',
        'bi' => 'Burundi',
        'kh' => 'Cambodia',
        'cm' => 'Cameroon',
        'ca' => 'Canada',
        'cv' => 'Cape Verde',
        'ky' => 'Cayman Islands',
        'cf' => 'Central African Republic',
        'td' => 'Chad',
        'cl' => 'Chile',
        'cn' => 'China',
        'cx' => 'Christmas Island',
        'cc' => 'Cocos Islands',
        'co' => 'Colombia',
        'km' => 'Comoros',
        'ck' => 'Cook Islands',
        'cr' => 'Costa Rica',
        'hr' => 'Croatia',
        'cu' => 'Cuba',
        'cy' => 'Cyprus',
        'cz' => 'Czech Republic',
        'cg' => 'Congo',
        'dk' => 'Denmark',
        'dj' => 'Djibouti',
        'dm' => 'Dominica',
        'tp' => 'East Timor',
        'ec' => 'Ecuador',
        'eg' => 'Egypt',
        'sv' => 'El Salvador',
        'gq' => 'Equatorial Guinea',
        'er' => 'Eritrea',
        'ee' => 'Estonia',
        'et' => 'Ethiopia',
        'fk' => 'Falkland Islands',
        'fo' => 'Faroe ',
        'fj' => 'Fiji',
        'fi' => 'Finland',
        'fr' => 'France',
        'pf' => 'French Polynesia',
        'ga' => 'Gabon',
        'gm' => 'Gambia',
        'ge' => 'Georgia',
        'de' => 'Germany',
        'gh' => 'Ghana',
        'gi' => 'Gibraltar',
        'gr' => 'Greece',
        'gl' => 'Greenland',
        'gd' => 'Grenada',
        'gu' => 'Guam',
        'gt' => 'Guatemala',
        'gk' => 'Guernsey',
        'gn' => 'Guinea',
        'gw' => 'Guinea-',
        'gy' => 'Guyana',
        'ht' => 'Haiti',
        'hn' => 'Honduras',
        'hk' => 'Hong Kong',
        'hu' => 'Hungary',
        'is' => 'Iceland',
        'in' => 'India',
        'id' => 'Indonesia',
        'ir' => 'Iran',
        'iq' => 'Iraq',
        'ie' => 'Ireland',
        'im' => 'Isle of ',
        'il' => 'Israel',
        'it' => 'Italy',
        'ci' => 'Ivory ',
        'jm' => 'Jamaica',
        'jp' => 'Japan',
        'je' => 'Jersey',
        'jo' => 'Jordan',
        'kz' => 'Kazakhstan',
        'ke' => 'Kenya',
        'ki' => 'Kiribati',
        'kp' => 'North Korea',
        'kr' => 'South Korea',
        'xk' => 'Kosovo',
        'kw' => 'Kuwait',
        'kg' => 'Kyrgyzstan',
        'la' => 'Laos',
        'lv' => 'Latvia',
        'lb' => 'Lebanon',
        'ls' => 'Lesotho',
        'lr' => 'Liberia',
        'ly' => 'Libya',
        'li' => 'Liechtenstein',
        'lt' => 'Lithuania',
        'lu' => 'Luxembourg',
        'mo' => 'Macau',
        'mk' => 'Macedonia',
        'mg' => 'Madagascar',
        'mw' => 'Malawi',
        'my' => 'Malaysia',
        'mv' => 'Maldives',
        'ml' => 'Mali',
        'mt' => 'Malta',
        'mh' => 'Marshall Islands',
        'mr' => 'Mauritania',
        'mu' => 'Mauritius',
        'ty' => 'Mayotte',
        'mx' => 'Mexico',
        'fm' => 'Micronesia',
        'md' => 'Moldova, Republic of',
        'mc' => 'Monaco',
        'mn' => 'Mongolia',
        'me' => 'Montenegro',
        'ms' => 'Montserrat',
        'ma' => 'Morocco',
        'mz' => 'Mozambique',
        'mm' => 'Myanmar',
        'na' => 'Namibia',
        'nr' => 'Nauru',
        'np' => 'Nepal',
        'nl' => 'Netherlands',
        'an' => 'Netherlands Antilles',
        'nc' => 'New Caledonia',
        'nz' => 'New Zealand',
        'ni' => 'Nicaragua',
        'ne' => 'Niger',
        'ng' => 'Nigeria',
        'nu' => 'Niue',
        'mp' => 'Northern Mariana Islands',
        'no' => 'Norway',
        'om' => 'Oman',
        'pk' => 'Pakistan',
        'pw' => 'Palau',
        'ps' => 'Palestine',
        'pa' => 'Panama',
        'pg' => 'Papua New Guinea',
        'py' => 'Paraguay',
        'pe' => 'Peru',
        'ph' => 'Philippines',
        'pn' => 'Pitcairn',
        'pl' => 'Poland',
        'pt' => 'Portugal',
        'qa' => 'Qatar',
        're' => 'Reunion',
        'ro' => 'Romania',
        'ru' => 'Russian',
        'rw' => 'Rwanda',
        'kn' => 'Saint Kitts and Nevis',
        'lc' => 'Saint Lucia',
        'vc' => 'Saint Vincent and the Grenadines',
        'ws' => 'Samoa',
        'sm' => 'San Marino',
        'st' => 'Sao Tome and ',
        'sa' => 'Saudi Arabia',
        'sn' => 'Senegal',
        'rs' => 'Serbia',
        'sc' => 'Seychelles',
        'sl' => 'Sierra ',
        'sg' => 'Singapore',
        'sk' => 'Slovakia',
        'si' => 'Slovenia',
        'sb' => 'Solomon Islands',
        'so' => 'Somalia',
        'za' => 'South Africa',
        'es' => 'Spain',
        'lk' => 'Sri Lanka',
        'sd' => 'Sudan',
        'sr' => 'Suriname',
        'sj' => 'Svalbard and Jan Mayen ',
        'sz' => 'Swaziland',
        'se' => 'Sweden',
        'ch' => 'Switzerland',
        'sy' => 'Syria',
        'tw' => 'Taiwan',
        'tj' => 'Tajikistan',
        'tz' => 'Tanzania',
        'th' => 'Thailand',
        'tg' => 'Togo',
        'tk' => 'Tokelau',
        'to' => 'Tonga',
        'tt' => 'Trinidad and Tobago',
        'tn' => 'Tunisia',
        'tr' => 'Turkey',
        'tm' => 'Turkmenistan',
        'tc' => 'Turks and Caicos Islands',
        'tv' => 'Tuvalu',
        'ug' => 'Uganda',
        'ua' => 'Ukraine',
        'ae' => 'United Arab Emirates',
        'gb' => 'United ',
        'uy' => 'Uruguay',
        'uz' => 'Uzbekistan',
        'vu' => 'Vanuatu',
        'va' => 'Vatican City State',
        've' => 'Venezuela',
        'vn' => 'Vietnam',
        'vi' => 'Virgin Islands (U.S.)',
        'wf' => 'Wallis and Futuna Islands',
        'eh' => 'Western ',
        'ye' => 'Yemen',
        'zm' => 'Zambia',
        'zw' => 'Zimbabwe'
    ];

    if (is_null($input)) {
        return $output;
    } else {

        return $output[$input];
    }
}


function currency_symbol_text($a = null)
{
    $output = [
//        'ALL' => 'Albania Lek',
        'ARS' => 'Argentina Peso',
        'AUD' => 'Australia Dollar',
//        'BDT' => 'Bangladeshi taka',
        'BOB' => 'Bolivia Boliviano',
//        'BAM' => 'Bosnia and Herzegovina Convertible Marka',
//        'BWP' => 'Botswana Pula',
        'BGN' => 'Bulgaria Lev',
        'BRL' => 'Brazil Real',
//        'BND' => 'Brunei Darussalam Dollar',
//        'KHR' => 'Cambodia Riel',
        'CAD' => 'Canada Dollar',
        'CLP' => 'Chile Peso',
        'CNY' => 'China Yuan Renminbi',
        'COP' => 'Colombia Peso',
        'CRC' => 'Costa Rica Colon',
        'HRK' => 'Croatia Kuna',
        'CZK' => 'Czech Republic Koruna',
        'DKK' => 'Denmark Krone',
//        'DOP' => 'Dominican Republic Peso',
//        'EGP' => 'Egypt Pound',
        'EUR' => 'Euro Member Countries',
//        'GHC' => 'Ghana Cedis',
        'GIP' => 'Gibraltar Pound',
//        'GTQ' => 'Guatemala Quetzal',
//        'GGP' => 'Guernsey Pound',
//        'HNL' => 'Honduras Lempira',
        'HKD' => 'Hong Kong Dollar',
        'HUF' => 'Hungary Forint',
        'ISK' => 'Iceland Krona',
        'INR' => 'India Rupee',
        'IDR' => 'Indonesia Rupiah',
        'IRR' => 'Iran Rial',
        'ILS' => 'Israel Shekel',
//        'JMD' => 'Jamaica Dollar',
        'JPY' => 'Japan Yen',
//        'KZT' => 'Kazakhstan Tenge',
        'KRW' => 'Korea (South) Won',
//        'KGS' => 'Kyrgyzstan Som',
//        'LBP' => 'Lebanon Pound',
        'MYR' => 'Malaysia Ringgit',
        'MUR' => 'Mauritius Rupee',
        'MXN' => 'Mexico Peso',
//        'NAD' => 'Namibia Dollar',
//        'NPR' => 'Nepal Rupee',
        'NZD' => 'New Zealand Dollar',
        'NGN' => 'Nigeria Naira',
        'NOK' => 'Norway Krone',
//        'OMR' => 'Oman Rial',
        'PKR' => 'Pakistan Rupee',
//        'PAB' => 'Panama Balboa',
//        'PYG' => 'Paraguay Guarani',
        'PEN' => 'Peru Nuevo Sol',
        'PHP' => 'Philippines Peso',
        'PLN' => 'Poland Zloty',
//        'QAR' => 'Qatar Riyal',
        'RON' => 'Romania New Leu',
        'RUB' => 'Russia Ruble',
//        'SAR' => 'Saudi Arabia Riyal',
//        'RSD' => 'Serbia Dinar',
        'SGD' => 'Singapore Dollar',
//        'SBD' => 'Solomon Islands Dollar',
        'ZAR' => 'South Africa Rand',
//        'LKR' => 'Sri Lanka Rupee',
        'SEK' => 'Sweden Krona',
        'CHF' => 'Switzerland Franc',
        'TWD' => 'Taiwan New Dollar',
        'THB' => 'Thailand Baht',
//        'TTD' => 'Trinidad and Tobago Dollar',
        'TRY' => 'Turkey Lira',
        'UAH' => 'Ukraine Hryvna',
        'GBP' => 'United Kingdom Pound',
//        'UGX' => 'Uganda Shilling',
        'USD' => 'United States Dollar',
//        'UYU' => 'Uruguay Peso',
//        'UZS' => 'Uzbekistan Som',
//        'VEF' => 'Venezuela Bolivar',
        'VND' => 'Viet Nam Dong'
    ];
    if ($a == null) {
        return $output;
    } elseif (isset($output[$a])) {

        return $output[$a];
    } else {

        return $a;
    }
}

function currency_symbol($a = null)
{
    $output = [
        'AFN' => '؋',
        'ANG' => 'ƒ',
        'ARS' => '$',
        'AUD' => 'A$',
        'BRL' => 'R$',
        'BSD' => 'B$',
        'CAD' => '$',
        'CHF' => 'CHF',
        'CLP' => '$',
        'CNY' => '¥',
        'COP' => '$',
        'CZK' => 'Kč',
        'DKK' => 'kr',
        'EUR' => '€',
        'FJD' => 'FJ$',
        'GBP' => '£',
        'GHS' => 'GH₵',
        'GTQ' => 'Q',
        'HKD' => '$',
        'HNL' => 'L',
        'HRK' => 'kn',
        'HUF' => 'Ft',
        'IDR' => 'Rp',
        'ILS' => '₪',
        'INR' => '₹',
        'ISK' => 'kr',
        'JMD' => 'J$',
        'JPY' => '¥',
        'KRW' => '₩',
        'LKR' => '₨',
        'MAD' => '.د.م',
        'MMK' => 'K',
        'MXN' => '$',
        'MYR' => 'RM',
        'NOK' => 'kr',
        'NZD' => '$',
        'PAB' => 'B/.',
        'PEN' => 'S/.',
        'PHP' => '₱',
        'PKR' => '₨',
        'PLN' => 'zł',
        'RON' => 'lei',
        'RSD' => 'RSD',
        'RUB' => 'руб',
        'SEK' => 'kr',
        'SGD' => 'S$',
        'THB' => '฿',
        'TND' => 'DT',
        'TRY' => 'TL',
        'TTD' => 'TT$',
        'TWD' => 'NT$',
        'USD' => '$',
        'VEF' => 'Bs',
        'VND' => '₫',
        'XAF' => 'FCFA',
        'XCD' => '$',
        'XPF' => 'F',
        'ZAR' => 'R',
    ];
    if ($a == null) {
        return $output;
    } elseif (isset($output[$a])) {

        return $output[$a];
    } else {

        return $a;
    }
}

/**
 * @param $registrationIds
 * @param $type
 * @param $data_id
 * @param $count
 * @param $message
 * @return array
 */
//google firebase
function pushNotification($registrationIds,$type, $data_id, $count,$message)
{

    // $news = \App\News::find($data_id);
    $fields = array
    (
        'to' => $registrationIds,
        "delay_while_idle" => true,
        "time_to_live" => 3,
        /*    'notification' => [
                'body' => strip_tags(str_limit($news->description,30)),
                'title' => str_limit($news->title,25),
            ],*/
        'data'=> [
            'message' => $message,
            'title' => 'monttra',
            'id' =>$data_id,
            'is_background' => true,
            'content_available'=>true,

        ]
    );


    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    return $fields;

}

/**
 * @param $string
 * @return string|string[]|null
 */
//function clean($string) {
//    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
//    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
//    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
//}

/**
 * @param $registrationIds
 * @param $type
 * @param $data_id
 * @param $count
 * @param $message
 * @return array
 */
//google firebase
function pushNotificationIos($registrationIds,$type, $data_id, $count,$message)
{

//    $news = \App\News::find($data_id);

    $fields = array
    (
        'to' => $registrationIds,
        "delay_while_idle" => true,

        "time_to_live" => 3,
        'notification' => [
            'body' => '',
            'title' => $message,
            'vibrate' => 1,
            'sound' => 'default',
        ],
        'data'=> [
            'message' => '',
            'title' => $message,
            'id' => $data_id,
            'is_background' => true,
            'content_available'=>true,


        ]
    );

    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    return $fields;

}





/**
 * @param $a
 * @return string
 */
//Random string
function randomString($a)
{
    $x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}

/**
 * @param int $a
 * @return string
 */
// random number
function randomNumber($a = 10)
{
    $x = '123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}

//use array key for validator
/**
 * @param $array
 * @param string $seperator
 * @param array $exception
 * @return string
 */
function arrKeyOnly($array, $seperator = ',', $exception = [])
{
    $string = '';
    $sep = '';
    foreach ($array as $key => $val) {
        if (in_array($key, $exception) == false) {
            $string .= $sep . $key;
            $sep = $seperator;
        }
    }
    return $string;
}

/**
 * @param $img
 * @param $path
 * @param null $user_file_name
 * @param null $width
 * @param null $height
 * @return bool|string
 */
function uploadInStorage($img, $path, $user_file_name = null, $width = null, $height = null)
{

    if (!file_exists($path)) {

        mkdir($path, 777, true);
    }

    if (isset($user_file_name) && $user_file_name != "" && file_exists($path . $user_file_name)) {
        unlink($path . $user_file_name);
    }
    // saving image in target path
    $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
    $imgPath = public_path($path . $imgName);
    // making image
    $makeImg = \Intervention\Image\Image::make($img)->orientate();
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        // $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $imgName;
    }
    return false;
}

function uploadimage($img, $path, $user_file_name = null, $width = null, $height = null)
{

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if (isset($user_file_name) && $user_file_name != "" && file_exists($path . $user_file_name)) {
        unlink($path . $user_file_name);
    }
    // saving image in target path
    $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
    $imgPath = public_path($path . $imgName);
    // making image
    $makeImg = Image::make($img)->orientate();
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        // $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $imgName;
    }
    return false;
}


/**
 * @param $path
 * @param $file_name
 */
function removeImage($path, $file_name)
{
    if (isset($file_name) && $file_name != "" && file_exists($path . $file_name)) {
        unlink($path . $file_name);
    }
}

//Advertisement image path
/**
 * @return string
 */
function path_image()
{
    return IMG_VIEW_PATH;
}

/**
 * @return string
 */
function upload_path()
{
    return 'uploads/';
}



/**
 * @param $file
 * @param $destinationPath
 * @param null $oldFile
 * @return bool|string
 */
function uploadFile($new_file, $path, $old_file_name = null, $width = null, $height = null)
{
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, true);
    }
    if (isset($old_file_name) && $old_file_name != "" && file_exists($path . substr($old_file_name, strrpos($old_file_name, '/') + 1))) {

        unlink($path . '/' . substr($old_file_name, strrpos($old_file_name, '/') + 1));
    }

    $input['imagename'] = uniqid() . time() . '.' . $new_file->getClientOriginalExtension();
    $imgPath = public_path($path . $input['imagename']);

    $makeImg = Image::make($new_file);
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $input['imagename'];
    }
    return false;

}
//function uploadFile($file, $destinationPath, $oldFile = null)
//{
////    if ($oldFile != null) {
////        deleteFile($destinationPath, $oldFile);
////    }
//
//
//    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
//    $uploaded = \Illuminate\Support\Facades\Storage::disk('local')->put($destinationPath . $fileName, file_get_contents($file->getRealPath()));
//    if ($uploaded == true) {
//        $name = $fileName;
//        return $name;
//    }
//    return false;
//}
function containsWord($str, $word)
{
    return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
}

/**
 * @param $destinationPath
 * @param $file
 */
function deleteFile($destinationPath, $file)
{
    if (isset($file) && $file != "" && file_exists($destinationPath . $file)) {
        unlink($destinationPath . $file);
    }
}
// get the image name from url
function get_image_name ($imageUrl)
{
    $url = $imageUrl;
    $keys = parse_url($url); // parse the url
    $path = explode("/", $keys['path']); // splitting the path
    $last = end($path); // get the value of the last element

    return $last;
}
//function for getting client ip address
/**
 * @return mixed|string
 */
function get_clientIp()
{
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
}

/**
 * @return array|bool
 */
function language()
{
    $lang = [];
    $path = base_path('resources/lang');
    foreach (glob($path . '/*.json') as $file) {
        $langName = basename($file, '.json');
        $lang[$langName] = $langName;
    }
    return empty($lang) ? false : $lang;
}

/**
 * @param null $input
 * @return array|mixed
 */
function langName($input = null)
{
    $output = [
        'ar' => 'Arabic',
        'de' => 'German',
        'en' => 'English',
        'es' => 'Spanish',
        'et' => 'Estonian',
        'fa' => 'Farsi',
        'fr' => 'French',
        'it' => 'Italian',
        'pl' => 'Polish',
        'pt' => 'Portuguese (European)',
        'pt-br' => 'Portuguese (Brazil)',
        'ro' => 'Romanian',
        'ru' => 'Russian',
        'th' => 'Thai',
        'tr' => 'Turkish',
        'zh-CN' => 'Chinese (Simplified)',
        'zh-TW' => 'Chinese (Traditional)',
        'zh-HK' => 'Chinese (Hong Kong)',
        'zh-SG' => 'Chinese (Singapore)',
        'ko' => 'Korean',
        'ja' => 'Japanese',
        'nl' => 'Dutch',
        'gr' => 'Greece',
        'id' => 'Indonesian',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed|string
 */
function langNameMobile($input = null)
{
    $output = [
        'en' => 'English',
        'fr' => 'French',
        'it' => 'Italian',
        'pt-PT' => ' Português(Portugal)',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        if(isset($output[$input]))
            return $output[$input];
        return '';
    }
}

if (!function_exists('settings')) {

    function settings($keys = null)
    {
        if ($keys && is_array($keys)) {
            return AdminSetting::whereIn('slug', $keys)->pluck('value', 'slug')->toArray();
        } elseif ($keys && is_string($keys)) {
            $setting = AdminSetting::where('slug', $keys)->first();
            return empty($setting) ? false : $setting->value;
        }
        return AdminSetting::pluck('value', 'slug')->toArray();
    }
}

function landingPageImage($index,$static_path){
    if (settings($index)){
        return asset(path_image()).'/'.settings($index);
    }
    return asset('assets/landing/master').'/'.$static_path;
}

function userSettings($keys = null){
    if ($keys && is_array($keys)) {
        return UserSetting::whereIn('slug', $keys)->pluck('value', 'slug')->toArray();
    } elseif ($keys && is_string($keys)) {
        $setting = UserSetting::where('slug', $keys)->first();
        return empty($setting) ? false : $setting->value;
    }
    return UserSetting::pluck('value', 'slug')->toArray();
}
//Call this in every function
/**
 * @param $lang
 */
function set_lang($lang)
{
    $default = settings('lang');
    $lang = strtolower($lang);
    $languages = language();
    if (in_array($lang, $languages)) {
        app()->setLocale($lang);
    } else {
        if (isset($default)) {
            $lang = $default;
            app()->setLocale($lang);
        }
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function langflug($input = null)
{

    $output = [
        'en' => '<i class="flag-icon flag-icon-us"></i> ',
        'pt-PT' => '<i class="flag-icon flag-icon-pt"></i>',
        'fr' => '<i class="flag-icon flag-icon-fr"></i>',
        'it' => '<i class="flag-icon flag-icon-it"></i>',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


//find odd even
/**
 * @param $number
 * @return string
 */
function oddEven($number)
{
//    dd($number);
    if ($number % 2 == 0) {
        return 'even';
    } else {
        return 'odd';
    }
}

function convert_currency($amount, $to = 'USD', $from = 'BTC')
{
    if(!empty(settings('COIN_PAYMENT_PUBLIC_KEY'))) {
        $coinPayment = new CoinPaymentsAPI();
        $rate = $coinPayment->GetRates()['result'];
        if(!empty($rate)) {
            $btcRate = $rate[$to];
            if ($from == 'BTC') {
                $returnAmount = bcmul($amount,(bcdiv(1, $btcRate['rate_btc'],8)),8);
            } else {
                $otherRate = $rate[$from];
                $toRate = bcdiv($btcRate['rate_btc'],$otherRate['rate_btc'],8);
                $returnAmount = bcmul($amount, (bcdiv(1,$toRate,8)),8);
            }
        } else {
            $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
            $json = file_get_contents($url); //,FALSE,$ctx);
            $jsondata = json_decode($json, TRUE);
            $returnAmount = bcmul($amount, $jsondata[$to],8);
        }
    } else {
        $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
        $json = file_get_contents($url); //,FALSE,$ctx);
        $jsondata = json_decode($json, TRUE);
        $returnAmount = bcmul($amount, $jsondata[$to],8);
    }


    return $returnAmount;
}
function convert_currency_btc($amount, $to = 'BTC', $from = 'USD')
{
    if(!empty(settings('COIN_PAYMENT_PUBLIC_KEY'))) {
        $coinPayment = new CoinPaymentsAPI();
        $rate = $coinPayment->GetRates()['result'];
        $btcRate = $rate[$to];
        if ($from == 'BTC') {
            $returnAmount = bcmul($amount,(bcdiv(1, $btcRate['rate_btc'],8)),8);
        } else {
            $otherRate = $rate[$from];
            $toRate = bcdiv($btcRate['rate_btc'],$otherRate['rate_btc'],8);
            $returnAmount = bcmul($amount, (bcdiv(1,$toRate,8)),8);
        }
    } else {
        $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
        $json = file_get_contents($url); //,FALSE,$ctx);
        $jsondata = json_decode($json, TRUE);
        $returnAmount = bcmul($amount,number_format($jsondata[$to],8),8);
    }

    return $returnAmount;
}

function get_current_market_price_rate($market_rate, $rate_percentage, $price_type)
{
    $rate = $market_rate;
    if ($price_type == RATE_BELOW) {
        $rate = bcsub($market_rate,bcdiv(bcmul($market_rate , $rate_percentage,8),100,8),8);
    } else {
        $rate = bcadd($market_rate,bcdiv(bcmul($market_rate , $rate_percentage,8),100,8),8);
    }

    return $rate;
}

// fees calculation
function calculate_fees($amount, $method)
{
    $settings = allsetting();

    try {
        if ($method == SEND_FEES_FIXED) {
            return $settings['send_fees_fixed'];
        } elseif ($method == SEND_FEES_PERCENTAGE) {
            return ($settings['send_fees_percentage'] * $amount) / 100;
        }  else {
            return 0;
        }
    } catch (\Exception $e) {
        return 0;
    }
}

/**
 * @param null $message
 * @return string
 */
function getToastrMessage($message = null)
{
    if (!empty($message)) {

        // example
        // return redirect()->back()->with('message','warning:Invalid username or password');

        $message = explode(':', $message);
        if (isset($message[1])) {
            $data = 'toastr.' . $message[0] . '("' . $message[1] . '")';
        } else {
            $data = "toastr.error(' write ( errorType:message ) ')";
        }

        return '<script>' . $data . '</script>';

    }

}

function getUserBalance($user_id){
    $wallets = Wallet::where(['user_id' => $user_id, 'coin_type' => 'Default']);

    $data['available_coin'] = $wallets->sum('balance');
    $data['available_used'] = $data['available_coin'] * settings('coin_price');
//    $data['pending_withdrawal_coin'] = WithdrawHistory::whereIn('wallet_id',$wallets->pluck('id'))->where('status',STATUS_PENDING)->sum('amount');
//    $data['pending_withdrawal_usd'] =  $data['pending_withdrawal_coin']*settings('coin_price');
    $coins = Coin::orderBy('id', 'ASC')->get();
    if (isset($coins[0])) {
        foreach($coins as $coin) {
            $walletAmounts = Wallet::where(['user_id' => $user_id, 'coin_type' => $coin->type])->sum('balance');
            $data[$coin->type] = $walletAmounts;
        }
    }
    $data['pending_withdrawal_coin'] = 0;
    $data['pending_withdrawal_usd'] = 0;
    return $data;
}

function getUserCoinBalance($user_id,$coin_type)
{
    return Wallet::where(['user_id' => $user_id, 'coin_type' => $coin_type])->sum('balance');
}

// total withdrawal
function total_withdrawal($user_id)
{
    $total = 0;
    $withdrawal = WithdrawHistory::join('wallets', 'wallets.id', '=','withdraw_histories.wallet_id')
        ->where('wallets.user_id', $user_id)
        ->where('withdraw_histories.status',STATUS_SUCCESS)
        ->get();
    if (isset($withdrawal[0])) {
        $total = $withdrawal->sum('amount');
    }

    return $total;
}
// total deposit
function total_deposit($user_id)
{
    $total = 0;
    $deposit = DepositeTransaction::join('wallets', 'wallets.id', '=','deposite_transactions.receiver_wallet_id')
        ->where('wallets.user_id', $user_id)
        ->where('deposite_transactions.status',STATUS_SUCCESS)
        ->get();
    if (isset($deposit[0])) {
        $total = $deposit->sum('amount');
    }

    return $total;
}

function getActionHtml($list_type,$user_id,$item){

    $html = '<div class="activity-icon"><ul>';
    if ($list_type == 'active_users'){
        $html .='
               <li><a title="'.__('View').'" href="'.route('adminUserProfile').'?id='.($user_id).'&type=view" class="user-two"><span><img src="'.asset("assets/admin/images/user-management-icons/activity/view.svg").'" class="img-fluid" alt=""></span></a></li>
               <li><a title="'.__('Edit').'" href="'.route('admin.UserEdit').'?id='.($user_id).'&type=edit" class="user-two"><span><img src="'.asset("assets/admin/images/user-management-icons/activity/user.svg").'" class="img-fluid" alt=""></span></a></li>
               <li>'.suspend_html('admin.user.suspend',($user_id)).'</li>';
                if(!empty($item->google2fa_secret)) {
                    $html .='<li>'.gauth_html('admin.user.remove.gauth',($user_id)).'</li>';
                }
                $html .='<li>'.delete_html('admin.user.delete',($user_id)).'</li>';

    } elseif ($list_type == 'suspend_user') {
        $html .='<li><a title="'.__('View').'" href="'.route('admin.UserEdit').'?id='.($user_id).'&type=view" class="view"><span><img src="'.asset("assets/admin/images/user-management-icons/activity/view.svg").'" class="img-fluid" alt=""></span></a></li>
          <li><a data-toggle="tooltip" title="Activate" href="'.route('admin.user.active',($user_id)).'" class="check"><span><img src="'.asset("assets/admin/images/user-management-icons/activity/check-square.svg").'" class="img-fluid" alt=""></span></a></li>
         ';

    } elseif($list_type == 'deleted_user') {
        $html .='<li><a title="'.__('View').'" href="'.route('admin.UserEdit').'?id='.($user_id).'&type=view" class="view"><span><img src="'.asset("assets/admin/images/user-management-icons/activity/view.svg").'" class="img-fluid" alt=""></span></a></li>
          <li><a data-toggle="tooltip" title="Activate" href="'.route('admin.user.active',($user_id)).'" class="check"><span><img src="'.asset("assets/admin/images/user-management-icons/activity/check-square.svg").'" class="img-fluid" alt=""></span></a></li>
         ';

    } elseif($list_type == 'email_pending') {
        $html .=' <li><a data-toggle="tooltip" title="Email verify" href="'.route('admin.user.email.verify',($user_id)).'" class="check"><span><img src="'.asset("assets/admin/images/user-management-icons/activity/check-square.svg").'" class="img-fluid" alt=""></span></a></li>';

    } elseif ($list_type == 'phone_pending') {
        $html .=' <li><a data-toggle="tooltip" title="Phone verify" href="'.route('admin.user.phone.verify',($user_id)).'" class="check"><span><img src="'.asset("assets/admin/images/user-management-icons/activity/check-square.svg").'" class="img-fluid" alt=""></span></a></li>';
    }
    $html .='</ul></div>';
    return $html;
}

// Html render
/**
 * @param $route
 * @param $id
 * @return string
 */
function edit_html($route, $id)
{
    $html = '<li class="viewuser"><a title="'.__('Edit').'" href="' . route($route, ($id)) . '"><i class="fa fa-pencil"></i></a></li>';
    return $html;
}


/**
 * @param $route
 * @param $id
 * @return string
 * @throws Exception
 */

function receipt_view_html($image_link)
{
    $num = random_int(1111111111,9999999999999);
    $html = '<div class="deleteuser"><a title="'.__('Bank receipt').'" href="#view_' . $num . '" data-toggle="modal">Bank Deposit</a> </div>';
    $html .= '<div id="view_' . $num . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-lg">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Bank receipt') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><img src="'.$image_link.'" alt=""></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function delete_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('delete').'" href="#delete_' . ($id) . '" data-toggle="modal"><span><img src="'.asset("assets/admin/images/user-management-icons/activity/delete-user.svg").'" class="img-fluid" alt=""></span></a> </li>';
    $html .= '<div id="delete_' . ($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Delete') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to delete ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
function delete_html2($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('delete').'" href="#delete_' . ($id) . '" data-toggle="modal"><span><i class="fa fa-trash"></i></span></a> </li>';
    $html .= '<div id="delete_' . ($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Delete') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to delete ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function suspend_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('Suspend').'" href="#suspends_' . ($id) . '" data-toggle="modal"><span><img src="'.asset("assets/admin/images/user-management-icons/activity/block-user.svg").'" class="img-fluid" alt=""></span></a> </li>';
    $html .= '<div id="suspends_' . ($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Suspend') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to suspend ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function active_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('Active').'" href="#active_' . ($id) . '" data-toggle="modal"><span class="flaticon-delete"></span></a> </li>';
    $html .= '<div id="active_' . ($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Activate') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Active ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-success" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function accept_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('Accept').'" href="#accept_' . decrypt($id) . '" data-toggle="modal"><span class=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>
    </span></a> </li>';
    $html .= '<div id="accept_' . decrypt($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Accept') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Accept ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-success" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function reject_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('Reject').'" href="#reject_' . decrypt($id) . '" data-toggle="modal"><span class=""><i class="fa fa-minus-square" aria-hidden="true"></i>
    </span></a> </li>';
    $html .= '<div id="reject_' . decrypt($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Reject') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Reject ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
/**
 * @param $route
 * @param $id
 * @return string
 */
function ChangeStatus($route, $id)
{
    $html = '<li class=""><a href="#status_' . $id . '" data-toggle="modal"><i class="fa fa-ban"></i></a> </li>';
    $html .= '<div id="status_' . $id . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Block') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Block this product ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

/**
 * @param $route
 * @param $id
 * @return string
 */
function BlockStatusChange($route, $id)
{   $html = '<ul class="activity-menu">';
    $html .= '<li class=" "><a title="'.__('Status change').'" href="#blockuser' . $id . '" data-toggle="modal"><i class="fa fa-check"></i></a> </li>';
    $html .= '<div id="blockuser' . $id . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Block') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Unblock this product ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-success"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</ul>';

    return $html;
}

/**
 * @param $route
 * @param $param
 * @return string
 */
function cancelSentItem($route,$param)
{
    $html  = '<li class=""><a title="'.__('Cancel').'" class="delete" href="#blockuser' . $param . '" data-toggle="modal"><i class="fa fa-remove"></i></a> </li>';
    $html .= '<div id="blockuser' . $param . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Cancel') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to cancel this product ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-success"href="' . route($route).$param. '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';


    return $html;
}

//status search
/**
 * @param $keyword
 * @return array
 */
function status_search($keyword)
{
    $st = [];
    if (strpos('_active', strtolower($keyword)) != false) {
        array_push($st, STATUS_SUCCESS);
    }
    if (strpos('_pending', strtolower($keyword)) != false) {
        array_push($st, STATUS_PENDING);
    }
    if (strpos('_inactive', strtolower($keyword)) != false) {
        array_push($st, STATUS_PENDING);
    }

    if (strpos('_deleted', strtolower($keyword)) != false) {
        array_push($st, STATUS_DELETED);
    }
    return $st;
}

function cim_search($keyword)
{

    return $keyword;
}

/**
 * @param $route
 * @param $status
 * @param $id
 * @return string
 */
function statusChange_html($route, $status, $id)
{
    $icon = ($status != STATUS_SUCCESS) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>';
    $status_title = ($status != STATUS_SUCCESS) ? statusAction(STATUS_SUCCESS) : statusAction(STATUS_SUSPENDED);
    $html = '';
    $html .= '<a title="'.__('Status change').'" href="' . route($route, encrypt($id)) . '">' . $icon . '<span>' . $status_title . '</span></a> </li>';
    return $html;
}

//exists img search
/**
 * @param $image
 * @param $path
 * @return string
 */
function imageSrc($image, $path)
{

    $return = asset('admin/images/default.jpg');
    if (!empty($image) && file_exists(public_path($path . '/' . $image))) {
        $return = asset($path . '/' . $image);
    }
    return $return;
}
//exists img search
/**
 * @param $image
 * @param $path
 * @return string
 */
function imageSrcUser($image, $path)
{

    $return = asset('user/assets/images/profile/default.png');
    if (!empty($image) && file_exists(public_path($path . '/' . $image))) {
        $return = asset($path . '/' . $image);
    }
    return $return;
}

function imageSrcVerification($image, $path)
{


    $return = asset('/assets/images/default_card.svg');
    if (!empty($image) && file_exists(public_path($path . '/' . $image))) {
        $return = asset($path . '/' . $image);
    }
    return $return;
}

/**
 * @param $title
 */
function title($title)
{
    session(['title' => $title]);
}


/**
 * @param int $length
 * @return string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * @return bool|string|\Webpatser\Uuid\Uuid
 * @throws Exception
 */
function uniqueNumber()
{

    $rand = Uuid::generate();
    $rand = substr($rand,30);
    $prefix = Auth::user()->prefix;
    if(ProductSerialAndGhost::where('serial_id',$prefix.$rand)->orwhere('ghost_id',$prefix.'G'.$rand)->exists())
        return uniqueNumber();
    else
        return $rand;
}



function customNumberFormat($value)
{
    if (is_integer($value)) {
        return number_format($value, 8, '.', '');
    } elseif (is_string($value)) {
        $value = floatval($value);
    }
    $number = explode('.', number_format($value, 10, '.', ''));
    return $number[0] . '.' . substr($number[1], 0, 2);
}

if (!function_exists('max_level')) {
    function max_level()
    {
        $max_level = allsetting('max_affiliation_level');

        return $max_level ? $max_level : 3;
    }

}

if (!function_exists('user_balance')) {
    function user_balance($userId)
    {
        $balance = Wallet::where('user_id', $userId)->sum(DB::raw('balance + referral_balance'));

        return $balance ? $balance : 0;
    }

}

if (!function_exists('visual_number_format'))
{
    function visual_number_format($value)
    {
        if (is_integer($value)) {
            return number_format($value, 2, '.', '');
        } elseif (is_string($value)) {
            $value = floatval($value);
        }
        $number = explode('.', number_format($value, 14, '.', ''));
        $intVal = (int)$value;
        if ($value > $intVal || $value < 0) {
            $intPart = $number[0];
            $floatPart = substr($number[1], 0, 8);
            $floatPart = rtrim($floatPart, '0');
            if (strlen($floatPart) < 2) {
                $floatPart = substr($number[1], 0, 2);
            }
            return $intPart . '.' . $floatPart;
        }
        return $number[0] . '.' . substr($number[1], 0, 2);
    }
}

// comment author name
function comment_author_name($id)
{
    $name = '';
    $user = User::where('id', $id)->first();
    if(isset($user)) {
        $name = $user->first_name.' '.$user->last_name;
    }

    return $name;
}

function gauth_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="' . __('Remove gauth') . '" href="#remove_gauth_' . ($id) . '" data-toggle="modal"><span class=""><img src="'.asset("assets/admin/images/user-management-icons/activity/check-square.svg").'" class="img-fluid" alt=""></span></a> </li>';
    $html .= '<div id="remove_gauth_' . ($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Remove Gauth') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to remove gauth ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
if (!function_exists('all_months')) {
    function all_months($val = null)
    {
        $data = array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
            11 => 11,
            12 => 12,
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}
function custom_number_format($value)
{
    if (is_integer($value)) {
        return number_format($value, 8, '.', '');
    } elseif (is_string($value)) {
        $value = floatval($value);
    }
    $number = explode('.', number_format($value, 14, '.', ''));
    return $number[0] . '.' . substr($number[1], 0, 8);
}

function converts_currency($amountInUsd, $to = 'BTC', $price)
{
    try {
        $array['amount'] = $amountInUsd;

        if ($to == "LTCT"){
            $to = "LTC";
        }

        if ( ($price['error'] == "ok") ) {

            $one_coin = $price['result'][$to]['rate_btc']; // dynamic coin rate in btc

            $one_usd = $price['result']['USD']['rate_btc']; // 1 usd == btc rate

            $total_amount_in_usd = bcmul($one_usd, $amountInUsd,8);

            return custom_number_format(bcdiv($total_amount_in_usd, $one_coin,8));
        }
    } catch (\Exception $e) {

        return number_format(0, 8);
    }
}


function convert_to_crypt($amountInBTC, $to)
{
    try {
        $coinpayment = new CoinPaymentsAPI();

        $price = $coinpayment->GetRates('');
        if ( ($price['error'] == "ok") ) {

            $one_coin = $price['result'][$to]['rate_btc']; // dynamic coin rate in btc
            $one_usd = $price['result']['USD']['rate_btc']; // 1 usd ==  btc rate

            $total_amount_in_btc = bcmul($one_coin, $amountInBTC,8);
            $total_amount_in_usd = bcdiv($total_amount_in_btc, $one_usd,8);

            return custom_number_format(bcdiv($total_amount_in_usd, settings('coin_price'),8));
        }
    } catch (\Exception $e) {
        return custom_number_format($amountInBTC, 8);
    }
}


//User Activity
function createUserActivity($userId, $action = '', $ip = null, $device = null){
    if ($ip == null) {
        $current_ip = get_clientIp();
    } else {
        $current_ip = $ip;
    }
    if($device == null){
        $agent = new Agent();
        $deviceType = isset($agent) && $agent->isMobile() == true ? 'Mobile' : 'Web';
    }else{
        $deviceType = $device == 1 ?  'Mobile' : 'Web';
    }

//        try{
//            $location = GeoIP::getLocation($current_ip);
//            $country = $location->country;
//        }catch(\Exception $e){
//            $country  = '';
//        }

    $activity['user_id'] = $userId;
    $activity['action'] = $action;
    $activity['ip_address'] = isset($current_ip) ? $current_ip : '0.0.0.0';
    $activity['source'] = $deviceType;
    $activity['location'] = '';
    ActivityLog::create($activity);
}
// user image
function show_image($id=null, $type)
{
    $img = asset('assets/common/img/avater.png');
    if ($type =='logo') {
        if (!empty(allsetting('logo'))) {
            $img = asset(path_image().allsetting('logo'));
        } else {
            $img = asset('assets/user/images/logo.svg');
        }
    } elseif($type == 'login_logo') {
        if (!empty(allsetting('login_logo'))) {
            $img = asset(path_image().allsetting('login_logo'));
        } else {
            $img = asset('assets/user/images/logo.svg');
        }
    } else {
        $user = User::where('id',$id)->first();
        if (isset($user) && !empty($user->photo)) {
            $img = asset(IMG_USER_PATH.$user->photo);
        }
    }
    return $img;
}
// plan image
function show_plan_image($plan_id,$img=null)
{
    $image = asset('assets/common/img/badge/Gold.svg');
    if (!empty($img)) {
        $image = asset(path_image().$img);
    } else {
        if ($plan_id == 1) {
            $image = asset('assets/common/img/badge/Silver.svg');
        } elseif ($plan_id == 2) {
            $image = asset('assets/common/img/badge/Gold.svg');
        } elseif ($plan_id == 3) {
            $image = asset('assets/common/img/badge/Platinum.svg');
        }
    }

    return $image;
}

// member plan bonus percentage
function plan_bonus_percentage($type,$bonus,$amount)
{
    $bonus_percentage = $bonus;
    if ($type == PLAN_BONUS_TYPE_FIXED) {
        $bonus_percentage = (100 * $bonus) / $amount;
    }

    return number_format($bonus_percentage,2);
}
// calculate bonus
function calculate_plan_bonus($bonus_percentage,$amount)
{
    $bonus = ($bonus_percentage * $amount) / 100;

    return number_format($bonus,8);
}

// get coin payment address
function get_coin_payment_address($payment_type)
{
    try {
        $coin_payment = new CoinPaymentsAPI();
        $address = $coin_payment->GetCallbackAddress($payment_type);
        if ( isset($address['error']) && ($address['error'] == 'ok') ) {
            return $address['result']['address'];
        } else {
            Log::info($address);
            return false;
        }
    } catch (\Exception $e) {
        Log::info('address generate ex -> '.$e->getMessage());
    }

}



// calculate fees of ico phase
function calculate_phase_percentage($amount, $fees)
{
    $fees = ($amount*$fees)/100;

    return $fees;
}

// check primary wallet
function is_primary_wallet($wallet_id, $coin_type)
{
    $wallets = Wallet::where(['user_id' => Auth::id(), 'coin_type' => $coin_type, 'is_primary'=> 1])->get();
    $this_primary_id = 0;
    $primary = 0;
    if (isset($wallets[0])) {
        foreach ($wallets as $wallet) {
            if ($wallet->id == $wallet_id) {
                $this_primary_id = $wallet->id;
            }
        }
    }
    if ($this_primary_id == $wallet_id) {
        $primary = 1;
    }

    return $primary;

}

// check coin type
function check_coin_type($type)
{
    $coin = Coin::where('type', $type)->first();
    if (isset($coin)) {
        return $coin->type;
    }

    return 'BTC';
}

// find primary wallet
function get_primary_wallet($user_id, $coin_type)
{
    $coin = Coin::where('type', $coin_type)->first();
    $primaryWallet = Wallet::where(['user_id' => $user_id, 'coin_type' => $coin_type, 'is_primary' => 1])->first();
    $wallets = Wallet::where(['user_id' => $user_id, 'coin_type' => $coin_type])->first();
    if (isset($primaryWallet)) {
        return $primaryWallet;
    } elseif (isset($wallets)) {
        $wallets->update(['is_primary' =>1]);
        return $wallets;
    } else {
        $createWallet = Wallet::create(['user_id' => $user_id, 'coin_id' => $coin->id, 'name' => $coin_type.' Wallet', 'coin_type' => $coin_type, 'is_primary' => 1,'unique_code'=>uniqid().date('').time()]);
        return $createWallet;
    }
}


// calculate trade fees
function trade_fees($amount, $coin)
{
    $fees = 0;
    $fees_percentage = $coin->trade_fees;
    $fees =  bcdiv(bcmul($amount , $fees_percentage,8),100,8);

    return $fees;
}
// calculate escrow fees
function escrow_fees($amount, $coin)
{
    $fees = 0;
    $fees_percentage = $coin->escrow_fees;
    $fees =  bcdiv(bcmul($amount , $fees_percentage,8),100,8);

    return $fees;
}

// get offer rate
function get_offer_rate($amount,$to,$from,$offer,$type)
{
    $rate = $offer->coin_rate;
    if($type == 'reverse') {
        $rate = 1/$offer->coin_rate;
    }
    return bcmul(custom_number_format($rate,8), $amount,8);
//    if ($offer->rate_type == RATE_TYPE_STATIC) {
//        $rate = $offer->coin_rate;
//        if($type == 'reverse') {
//            $rate = 1/$offer->coin_rate;
//        }
//        return bcmul(custom_number_format($rate,8), $amount,8);
//    } else {
//        if($type == 'reverse') {
//            return convert_currency_btc($amount,$from,$to);
//        } else {
//            return convert_currency($amount,$to,$from);
//        }
//    }

}

function is_accept_payment_method($payment_id,$country)
{
    $check = CountryPaymentMethod::where(['payment_method_id' => $payment_id, 'country' => $country])->first();
    if(isset($check)) {
        return true;
    } else {
        return false;
    }
}


function count_trades($user_id)
{
    $trades = Order::where('status', TRADE_STATUS_TRANSFER_DONE)
        ->where(function ($query) use ($user_id) {
            $query->where('buyer_id', $user_id)
                ->orWhere('seller_id', $user_id);
        })->count();

    return $trades;
}

function user_trades_count($user_id,$status)
{
    if ($status == 'total') {
        $trades = Order::where(function ($query) use ($user_id) {
                $query->where('buyer_id', $user_id)
                    ->orWhere('seller_id', $user_id);
            })->count();
    } else {
        $trades = Order::where('is_reported', 0)
            ->where('status', $status)
            ->where(function ($query) use ($user_id) {
                $query->where('buyer_id', $user_id)
                    ->orWhere('seller_id', $user_id);
            })->count();
    }


    return $trades;
}
function user_disputed_trades($user_id)
{
    $trades = Order::where('is_reported', STATUS_ACTIVE)
        ->where(function ($query) use ($user_id) {
            $query->where('buyer_id', $user_id)
                ->orWhere('seller_id', $user_id);
        })->count();

    return $trades;
}

function user_coin_balance($user_id, $type)
{
    $balance = 0;
    $wallets =  Wallet::where(['user_id' => $user_id, 'coin_type' => $type])->get();
    if(isset($wallets[0])) {
        $balance =  $wallets->sum('balance');
    }
     return $balance;
}

function get_user_offer($user_id,$type)
{
    $offers = 0;
    if($type == BUY) {
        $offers = Buy::where(['user_id'=>$user_id, 'status'=>STATUS_ACTIVE])->count();
    } elseif($type == SELL) {
        $offers = Sell::where(['user_id'=>$user_id, 'status'=>STATUS_ACTIVE])->count();
    }

    return $offers;
}

function my_encrypt($plaintext)
{
    $key = '1rTbiyn9p0MAwYI9';
    $plaintext = 1;
    $ciphertext = base64_encode( $plaintext );
    $ciphertext =  $ciphertext.':'.base64_encode($key);

    return $ciphertext;
}

function my_decrypt($ciphertext)
{
    $text = explode(':',$ciphertext);
    $c = base64_decode($text[0]);

    return $c;
}


function check_coin_status($wallet, $type, $amount, $fees = 0)
{
    $data = [
        'success' => false,
        'message' => 'ok',
    ];
    if(isset($wallet)) {

        if($type == CHECK_STATUS) {
            if($wallet->coin_status != STATUS_ACTIVE) {
                $data = [
                    'success' => true,
                    'message' => check_default_coin_type($wallet->coin_type).__(" coin is inactive right now.")
                ];
            }
        }
        if($type == CHECK_WITHDRAWAL_STATUS) {
            if($wallet->is_withdrawal != STATUS_ACTIVE) {
                $data = [
                    'success' => true,
                    'message' => check_default_coin_type($wallet->coin_type).__(" coin is not available for withdrawal right now")
                ];
            }
        }
        if($type == CHECK_WITHDRAWAL_FEES) {
            if($wallet->balance < ($amount + $fees)) {
                $data = [
                    'success' => true,
                    'message' => __("Wallet has no enough balance to withdrawal")
                ];
            }
        }
        if($type == CHECK_MINIMUM_WITHDRAWAL) {
            if (($amount + $fees) < $wallet->minimum_withdrawal) {
                $data = [
                    'success' => true,
                    'message' => __('Minimum withdrawal amount ') . $wallet->minimum_withdrawal . ' ' . check_default_coin_type($wallet->coin_type)
                ];
            }
        }
        if($type == CHECK_MAXIMUM_WITHDRAWAL) {
            if (($amount + $fees) > $wallet->maximum_withdrawal) {
                $data = [
                    'success' => true,
                    'message' => __('Maximum withdrawal amount ') . $wallet->maximum_withdrawal . ' ' . check_default_coin_type($wallet->coin_type)
                ];
            }
        }
    }

    return $data;
}

function check_withdrawal_fees($amount, $fess_percentage)
{
    return ($fess_percentage * $amount) / 100;
}

function show_image_path($img_name, $path)
{
    $img = asset('assets/common/img/default.jpg');
    if (!empty($img_name)) {
        $img = asset(path_image().$path.$img_name);
    }

    return $img;
}

// trade escrow details
function trade_escrow($order_id)
{
    $data['status'] = 0;
    $data['amount'] = 0;
    $data['fees'] = 0;
    $data['fees_percentage'] = 0;
    $escrow = Escrow::find($order_id);
    if (isset($escrow)) {
        $data['status'] = $escrow->status;
        $data['amount'] = $escrow->amount;
        $data['fees'] = $escrow->fees;
        $data['fees_percentage'] = $escrow->fees_percentage;
    }

    return $data;
}

function default_coin_api_settings()
{
    if (empty(allsetting()['chain_link'])) {
        AdminSetting::firstOrCreate(['slug' => 'chain_id'],[ 'value' => ""]);
        AdminSetting::firstOrCreate(['slug' => 'chain_link'],[ 'value' => ""]);
        AdminSetting::firstOrCreate(['slug' => 'contract_address'],[ 'value' => ""]);
        AdminSetting::firstOrCreate(['slug' => 'wallet_address'],[ 'value' => ""]);
        AdminSetting::firstOrCreate(['slug' => 'private_key'],[ 'value' => ""]);
    }
}
function currency_converter($from,$to,$amount) {
    $endpoint = 'convert';
    $access_key = 'YOUR_ACCESS_KEY';

// initialize CURL:
    $ch = curl_init('https://api.currencylayer.com/'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// get the (still encoded) JSON data:
    $json = curl_exec($ch);
    curl_close($ch);

// Decode JSON response:
    $conversionResult = json_decode($json, true);

// access the conversion result
    return $conversionResult['result'];
}


// check available phase
function checkAvailableBuyPhase()
{
    $activePhases = IcoPhase::where('status', STATUS_ACTIVE)->orderBy('start_date', 'asc')->get();
// dd($activePhases);
    if ( isset($activePhases[0])) {
        $phaseInfo = '';
        $phaseStatus = 0;
        $now = Carbon::now()->format("Y-m-d H:i:s");
        $futureDate = '';

        foreach ($activePhases as $activePhase) {
            if ( ($now >= $activePhase->start_date) && $now <= $activePhase->end_date ) {
                $phaseStatus = 1;
                $phaseInfo = $activePhase;
                break;
            } elseif ( $activePhase->start_date > $now ) {
                $phaseStatus = 2;
                $phaseInfo = '';
                $futureDate = $activePhase->start_date;
                break;
            }
        }

        if ( $phaseStatus == 0 ) {
            return [
                'status' => false
            ];
        } elseif ( $phaseStatus == 1 ) {
            return [
                'status' => true,
                'futurePhase' => false,
                'pahse_info' => $phaseInfo
            ];
        } else {
            return [
                'status' => true,
                'futurePhase' => true,
                'pahse_info' => $phaseInfo,
                'futureDate' => $futureDate
            ];
        }
    }

    return [
        'status' => false
    ];
}

function find_coin_type($coin_type)
{
    $type = $coin_type;
    if ($coin_type == DEFAULT_COIN_TYPE) {
        $type = settings('coin_name');
    }

    return $type;
}

function admin_feature_enable($slug)
{
    $feature = false;
    if(isset(settings()[$slug]) && (settings()[$slug] == STATUS_ACTIVE)) {
        $feature = true;
    }
    return $feature;
}

/**
 * use for showing image
 * return image url
 * @param string $image
 * @return string
 */
function check_storage_image_exists($image=''){
    if (Storage::exists($image)) {
        return Storage::url($image);
    }else{
        return adminAsset('images/no-image.png');
    }

}

function adminAsset($path = '') {
    return asset('assets/admin/' . $path);
}

/**
 * Delete file from storage according to env settings
 *
 * @param $destinationPath
 * @param $file
 * @param string $disk
 */
function deleteStorageFile($destinationPath, $file, $disk = '') {
    try {
        if ($file != NULL) {
            if($disk == ''){
                Storage::delete($destinationPath . $file);
            }else{
                Storage::disk($disk)->delete($destinationPath . $file);
            }
        }
    } catch (Exception $e) {

    }
}

function getLastSerialOfFeature($type,$page_id){
    if($type=='feature'){
        $table = 'custom_landing_feature_temp';
    }elseif($type=='coin'){
        $table = 'custom_landing_coins_temp';
    }elseif($type=='team'){
        $table = 'custom_landing_teams_temp';
    }elseif($type=='testimonial'){
        $table = 'custom_landing_testimonial_temp';
    }elseif($type=='faq'){
        $table = 'custom_landing_faqs_temp';
    }elseif($type=='advantage'){
        $table = 'custom_landing_advantage_temp';
    }elseif($type=='work'){
        $table = 'custom_landing_p2p_temp';
    }else{
        $table = 'custom_landing_process_temp';
    }
    $something = DB::table(DB::raw($table))->where('landing_page_id','=',$page_id)->orderBy('id','desc')->first();
    return $something->serial ?? 0;
}

function checkUserKyc($userId, $type, $verificationType)
{
    $response = ['success' => true, 'message' => 'success'];
    if ($type == KYC_DRIVING_REQUIRED) {
        $drive_front = VerificationDetails::where('user_id',$userId)->where('field_name','drive_front')->first();
        $drive_back = VerificationDetails::where('user_id',$userId)->where('field_name','drive_back')->first();
        if((isset($drive_front ) && isset($drive_back)) && (($drive_front->status == STATUS_SUCCESS) && ($drive_back->status == STATUS_SUCCESS))) {
            $response = ['success' => true, 'message' => 'success'];
        } else {
            $response = ['success' => false, 'message' => __('Before ').$verificationType.__(' you must have verified driving licence')];
        }
        return $response;
    } elseif($type == KYC_PASSPORT_REQUIRED) {
        $pass_front = VerificationDetails::where('user_id',$userId)->where('field_name','pass_front')->first();
        $pass_back = VerificationDetails::where('user_id',$userId)->where('field_name','pass_back')->first();
        if((isset($pass_front ) && isset($pass_back)) && (($pass_front->status == STATUS_SUCCESS) && ($pass_back->status == STATUS_SUCCESS))) {
            $response = ['success' => true, 'message' => 'success'];
        } else {
            $response = ['success' => false, 'message' => __('Before ').$verificationType.__(' you must have verified passport')];
        }
        return $response;
    } else {
        $nid_front = VerificationDetails::where('user_id',$userId)->where('field_name','nid_front')->first();
        $nid_back = VerificationDetails::where('user_id',$userId)->where('field_name','nid_back')->first();
        if((isset($nid_front ) && isset($nid_back)) && (($nid_front->status == STATUS_SUCCESS) && ($nid_back->status == STATUS_SUCCESS))) {
            $response = ['success' => true, 'message' => 'success'];
        } else {
            $response = ['success' => false, 'message' => __('Before ').$verificationType.__(' you must have verified NID')];
        }
        return $response;
    }
}
function sendMessage($message, $recipients)
{
    try {
        $all_settings = allsetting();
        $account_sid = $all_settings['twillo_secret_key'];
        $auth_token = $all_settings['twillo_auth_token'];
        $twilio_number = $all_settings['twillo_number'];
        $client = new Aloha\Twilio\Twilio($account_sid,$auth_token,$twilio_number);
        $client = $client->message($recipients, $message);
        $client = $client->status;
        return $client;
    }catch (\Exception $exception){
        return  false;
    }
}


// get wallet personal address
function get_wallet_personal_add($add1,$add2)
{
    $data = explode($add1,$add2);
    return $data[0];
}


function feedback_status($input = null)
{
    $output = [
        0 => '<span class="badge badge-danger">'.__('Very Poor').'</span>',
        1 => '<span class="badge badge-warning">'.__('Poor').'</span>',
        2 => '<span class="badge badge-secondary">'.__('Average').'</span>',
        3 => '<span class="badge badge-info">'.__('Good').'</span>',
        4 => '<span class="badge badge-primary">'.__('Very Good').'</span>',
        5 => '<span class="badge badge-success">'.__('Excellent').'</span>',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function get_user_feedback_rate($user_id)
{
    $buyCount = 0;
    $buyFeedback = 0;
    $sellCount = 0;
    $sellFeedback = 0;
    $userFeedback = 0;
    $buyOrder = Order::where(['buyer_id' => $user_id])->get();
    $sellOrder = Order::where(['seller_id' => $user_id])->get();
    if (isset($buyOrder[0])) {
        $buyCount = sizeof($buyOrder);
        $buyFeedback = $buyOrder->sum('seller_feedback');
    }
    if(isset($sellOrder[0])) {
        $sellCount = sizeof($sellOrder);
        $sellFeedback = $sellOrder->sum('buyer_feedback');
    }
    $totalOrder = $buyCount + $sellCount;
    $totalFeedback = $buyFeedback + $sellFeedback;
    if ($totalOrder > 0) {
        $feedback = $totalOrder*5;
        $userFeedback = bcdiv(bcmul(100,$totalFeedback,8),$feedback,8);
    }
    return number_format($userFeedback,2);
}


function getCoinPaymentApiRates()
{
    $rate = [];
    if(!empty(settings('COIN_PAYMENT_PUBLIC_KEY'))) {
        $coinPayment = new CoinPaymentsAPI();
        $rate = $coinPayment->GetRates()['result'];
        return $rate;
    }
    return $rate;
}
function make_unique_slug($title,$table_name = NULL,$column_name = NULL)
{
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '/' => '-', ' ' => '-'
    );

    // -- Remove duplicated spaces
    $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $title);

    // -- Returns the slug
    $slug = strtolower(strtr($title, $table));
    $slug = str_replace("?","",$slug);
    $columnName = isset($column_name) ? $column_name : 'slug';
    if(isset($table_name)) {
        $item = DB::table($table_name)->where([$columnName => $slug])->first();
        if (isset($item)) {
            $slug = setSlugAttribute($slug, $table_name, $columnName);
        }
    }

    return $slug;
}

function setSlugAttribute($value, $table, $columnName)
{

    if (DB::table($table)->where([$columnName => $value])->exists()) {
        return incrementSlug($value, $table, $columnName);
    }
    return $value;
}

function incrementSlug($slug,$table, $columnName)
{
    $original = $slug;
    $count = 2;

    while (DB::table($table)->where([$columnName => $slug])->exists()) {
        $slug = "{$original}-" . $count++;
    }

    return $slug;
}

function check_online_status($user)
{
    if(Cache::has('is_online' . $user->id)) {
        $data['online_status'] = 'Online';
    } else {
        $data['online_status'] = 'Offline';
    }
    if ($user->last_seen != null) {
        $data['last_seen'] = Carbon::parse($user->last_seen)->diffForHumans();
    } else {
        $data['last_seen'] = __('No data');
    }
    return $data;
}


