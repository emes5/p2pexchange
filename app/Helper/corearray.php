<?php

//User Roles
use App\Model\CountryList;

function userRole($input = null)
{
    $output = [
        USER_ROLE_ADMIN => __('Admin'),
        USER_ROLE_USER => __('User')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
//User Activity Array
function userActivity($input = null)
{
    $output = [
         USER_ACTIVITY_LOGIN => __('Log In'),
         USER_ACTIVITY_MOVE_COIN => __("Move coin"),
         USER_ACTIVITY_WITHDRAWAL => __('Withdraw coin'),
         USER_ACTIVITY_CREATE_WALLET => __('Create new wallet'),
         USER_ACTIVITY_CREATE_ADDRESS => __('Create new address'),
         USER_ACTIVITY_MAKE_PRIMARY_WALLET => __('Make wallet primary'),
         USER_ACTIVITY_PROFILE_IMAGE_UPLOAD => __('Upload profile image'),
         USER_ACTIVITY_UPDATE_PASSWORD => __('Update password'),
         USER_ACTIVITY_LOGOUT => __("Logout"),
         USER_ACTIVITY_PROFILE_UPDATE => __('Profile update')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
//Discount Type array
function discount_type($input = null)
{
    $output = [
        DISCOUNT_TYPE_FIXED => __('Fixed'),
        DISCOUNT_TYPE_PERCENTAGE => __('Percentage')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

 function sendFeesType($input = null){
    $output = [
        DISCOUNT_TYPE_FIXED => __('Fixed'),
        DISCOUNT_TYPE_PERCENTAGE => __('Percentage')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function status($input = null)
{
    $output = [
        STATUS_ACTIVE => __('Active'),
        STATUS_DEACTIVE => __('Deactive'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function deposit_status($input = null)
{
    $output = [
        STATUS_ACCEPTED => __('Accepted'),
        STATUS_PENDING => __('Pending'),
        STATUS_REJECTED => __('Rejected'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function offer_active_status($input = null)
{
    $output = [
        STATUS_ACTIVE => __('Active'),
        STATUS_DEACTIVE => __('Inactive'),
        STATUS_DELETED => __('Deleted'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function price_rate_type($input = null)
{
    $output = [
        RATE_ABOVE => __('Above'),
        RATE_BELOW => __('Below'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function coin_rate_type($input = null)
{
    $output = [
        RATE_TYPE_DYNAMIC => __('Dynamic Rate'),
        RATE_TYPE_STATIC => __('Static'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function byCoinType($input = null)
{
    $output = [
        CARD => __('CARD'),
        BTC => __('Coin Payment'),
        BANK_DEPOSIT => __('BANK DEPOSIT'),

    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function addressType($input = null){
    $output = [

        ADDRESS_TYPE_INTERNAL => __('Internal'),
        ADDRESS_TYPE_EXTERNAL => __('External'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


function statusAction($input = null)
{
    $output = [
        STATUS_PENDING => __('Pending'),
        STATUS_SUCCESS => __('Active'),
        STATUS_REJECTED => __('Rejected'),
        //STATUS_FINISHED => __('Finished'),
        STATUS_SUSPENDED => __('Suspended'),
       // STATUS_REJECT => __('Rejected'),
        STATUS_DELETED => __('Deleted'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


function actions($input = null)
{
    $output = [

    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function days($input=null){
    $output = [
        DAY_OF_WEEK_MONDAY => __('Monday'),
        DAY_OF_WEEK_TUESDAY => __('Tuesday'),
        DAY_OF_WEEK_WEDNESDAY => __('Wednesday'),
        DAY_OF_WEEK_THURSDAY => __('Thursday'),
        DAY_OF_WEEK_FRIDAY => __('Friday'),
        DAY_OF_WEEK_SATURDAY => __('Saturday'),
        DAY_OF_WEEK_SUNDAY => __('Sunday')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function months($input=null){
    $output = [
        1 => __('January'),
        2 => __('February'),
        3 => __('Merch'),
        4 => __('April'),
        5 => __('May'),
        6 => __('June'),
        7 => __('July'),
        8 => __('August'),
        9 => __('September'),
        10 => __('October'),
        11 => __('November'),
        12 => __('December'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function customPages($input=null){
    $output = [
        'faqs' => __('FAQS'),
        't_and_c' => __('T&C')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


function paymentTypes($input = null)
{
    if (env('APP_ENV') == 'production' )
        $output = [
            PAYMENT_TYPE_LTC => 'LTC',
            PAYMENT_TYPE_BTC => 'BTC',
            PAYMENT_TYPE_USD => 'USDT',
            PAYMENT_TYPE_ETH => 'ETH',
            PAYMENT_TYPE_DOGE => 'DOGE',
            PAYMENT_TYPE_BCH => 'BCH',
            PAYMENT_TYPE_DASH => 'DASH',
        ];
    else
        $output = [
            PAYMENT_TYPE_LTC => 'LTCT',
            PAYMENT_TYPE_BTC => 'BTC',
            PAYMENT_TYPE_USD => 'USDT',
            PAYMENT_TYPE_ETH => 'ETH',
            PAYMENT_TYPE_DOGE => 'DOGE',
            PAYMENT_TYPE_BCH => 'BCH',
            PAYMENT_TYPE_DASH => 'DASH',
        ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

// payment method list
function paymentMethods($input = null)
{
    $output = [
        BTC => __('Coin Payment'),
        BANK_DEPOSIT => __('Bank Deposit')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
// payment method list
function paymentStatus($input = null)
{
    $output = [
        STATUS_ACTIVE => __('Payment Complete'),
        STATUS_DEACTIVE => __('Pending')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

// buy sell list
function buy_sell($input = null)
{
    $output = [
        BUY_SELL => __('Buy/Sell'),
        BUY => __('Buy'),
        SELL => __('Sell')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

// trade order status
function trade_order_status($input = null)
{
    $output = [
        TRADE_STATUS_INTERESTED => __('Waiting for escrow'),
        TRADE_STATUS_ESCROW => __('Waiting for payment'),
        TRADE_STATUS_PAYMENT_DONE => __('Waiting for releasing escrow'),
        TRADE_STATUS_TRANSFER_DONE => __('Transaction Successful'),
        TRADE_STATUS_CANCEL => __('Cancelled'),
        TRADE_STATUS_REPORT => __('Order reported'),
        TRADE_STATUS_CANCELLED_ADMIN => __('Cancelled By Admin'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
// trade order dispute status
function trade_order_dispute($input = null)
{
    $output = [
        YES => __('Yes'),
        NO => __('No')
        ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


// check coin type
function check_default_coin_type($coin_type)
{
    $type = $coin_type;
    if($coin_type == DEFAULT_COIN_TYPE) {
        $type = settings('coin_name');
    }
    return $type;
}
//gender name
function genderName($input = null)
{
    $output = [
        MALE => __('Male'),
        FEMALE => __('Female'),
        OTHER => __('Other'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function element_prefix($input){
    $output = [
        1 => '',
        2 => '-two',
        3 => '-three'
    ];
    return $output[$input];
}


function contract_decimals($input = null)
{
    $output = [
        6 => 'picoether',
        9 => 'nanoether',
        12 => 'microether',
        15 => 'milliether',
        18 => 'ether',
        21 => 'kether',
        24 => 'mether',
        27 => 'gether',
        30 => 'tether',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        $result = 'ether';
        if (isset($output[$input])) {
            $result = $output[$input];
        }
        return $result;
    }
}
function contract_decimals_reverse($input = null)
{
    $output = [
        'picoether' => 6,
        'nanoether' => 9,
        'microether' => 12,
        'milliether' => 15,
        'ether' => 18,
        'kether' => 21,
        'mether' => 24,
        'gether' => 27,
        'tether' => 30,
    ];
    if (is_null($input)) {
        return $output;
    } else {
        $result = 'ether';
        if (isset($output[$input])) {
            $result = $output[$input];
        }
        return $result;
    }
}
function contract_decimals_value($input = null)
{
    $output = [
        6 => 1000000,
        9 => 1000000000,
        12 => 1000000000000,
        15 => 1000000000000000,
        18 => 1000000000000000000,
        21 => 1000000000000000000000,
        24 => 1000000000000000000000000,
        27 => 1000000000000000000000000000,
        30 => 1000000000000000000000000000000,
    ];
    if (is_null($input)) {
        return $output;
    } else {
        $result = 18;
        if (isset($output[$input])) {
            $result = $output[$input];
        }
        return $result;
    }
}

function countrylist($input=null) {
    if (is_null($input)) {
        $allCountry = CountryList::where(['status' => STATUS_ACTIVE])->get();
        if (isset($allCountry[0])) {
            $output = [];
            foreach ($allCountry as $setting) {
                $output[$setting->key] = __($setting->value);
            }
            return $output;
        }
        return [];
    } else {
        $allCountry = CountryList::where(['key' => $input])->first();
        if ($allCountry) {
            $output = __($allCountry->value);
            return $output;
        }
        return '';
    }
}

function countrylistOld($input=null) {
    $output = [
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "IO" => "British Indian Ocean Territory",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos (Keeling) Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, the Democratic Republic of the",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Cote D'Ivoire",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands (Malvinas)",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and Mcdonald Islands",
        "VA" => "Holy See (Vatican City State)",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran, Islamic Republic of",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea, Democratic People's Republic of",
        "KR" => "Korea, Republic of",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Lao People's Democratic Republic",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libyan Arab Jamahiriya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macao",
        "MK" => "Macedonia, the Former Yugoslav Republic of",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "MX" => "Mexico",
        "FM" => "Micronesia, Federated States of",
        "MD" => "Moldova, Republic of",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestinian Territory, Occupied",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Reunion",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "SH" => "Saint Helena",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome and Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "CS" => "Serbia and Montenegro",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and the South Sandwich Islands",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan, Province of China",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania, United Republic of",
        "TH" => "Thailand",
        "TL" => "Timor-Leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "UM" => "United States Minor Outlying Islands",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela",
        "VN" => "Viet Nam",
        "VG" => "Virgin Islands, British",
        "VI" => "Virgin Islands, U.s.",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe"

    ];

    if (is_null($input)) {
        return $output;
    } else {

        return $output[$input];
    }
}

function feedback_status_api($input = null)
{
    $output = [
        0 => __('Very Poor'),
        1 => __('Poor'),
        2 => __('Average'),
        3 => __('Good'),
        4 => __('Very Good'),
        5 => __('Excellent'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function show_user_image_path($img_name)
{
    $img = asset('assets/common/img/avater.png');
    if (!empty($img_name)) {
        $img = asset(IMG_USER_PATH.$img_name);
    }

    return $img;
}
/*********************************************
 *        End Ststus Functions
 *********************************************/
