<?php


// User Role Type

const USER_ROLE_ADMIN = 1;
const USER_ROLE_USER = 2;
const USER_ROLE_SUB_ADMIN = 3;

// Status
const STATUS_PENDING = 0;
const STATUS_ACCEPTED = 1;
const STATUS_REJECTED = 2;
const STATUS_SUCCESS = 1;
const STATUS_SUSPENDED = 4;
const STATUS_DELETED = 5;
const STATUS_ALL = 6;

const STATUS_ACTIVE = 1;
const STATUS_DEACTIVE = 0;

const BTC = 1;
const CARD = 2;
const PAYPAL = 3;
const BANK_DEPOSIT = 4;


const  SEND_FEES_FIXED  = 1;
const  SEND_FEES_PERCENTAGE  = 2;

//Varification send Type
const Mail = 1;
const PHONE = 2;


const IOS = 1;
const ANDROIND = 2;

// User Activity
const ADDRESS_TYPE_EXTERNAL = 1;
const ADDRESS_TYPE_INTERNAL = 2;

const IMG_PATH = 'uploaded_file/uploads/';
const IMG_VIEW_PATH = 'uploaded_file/uploads/';

const IMG_USER_PATH = 'uploaded_file/users/';
const IMG_SLEEP_PATH = 'uploaded_file/sleep/';
const IMG_USER_VIEW_PATH = 'uploaded_file/users/';
const IMG_SLEEP_VIEW_PATH = 'uploaded_file/sleep/';
const IMG_USER_VERIFICATION_PATH = 'users/verifications/';

const DISCOUNT_TYPE_FIXED = 1;
const DISCOUNT_TYPE_PERCENTAGE = 2;

const DEPOSIT = 1;
const WITHDRAWAL = 2;

const PAYMENT_TYPE_BTC = 1;
const PAYMENT_TYPE_USD = 2;
const PAYMENT_TYPE_ETH = 3;
const PAYMENT_TYPE_LTC = 4;
const PAYMENT_TYPE_LTCT = 5;
const PAYMENT_TYPE_DOGE = 6;
const PAYMENT_TYPE_BCH = 7;
const PAYMENT_TYPE_DASH = 8;
const PAYMENT_TYPE_USDT = 9;
// plan bonus
const PLAN_BONUS_TYPE_FIXED = 1;
const PLAN_BONUS_TYPE_PERCENTAGE = 2;

//
const CREDIT = 1;
const DEBIT = 2;

//User Activity
const USER_ACTIVITY_LOGIN=1;
const USER_ACTIVITY_MOVE_COIN=2;
const USER_ACTIVITY_WITHDRAWAL=3;
const USER_ACTIVITY_CREATE_WALLET=4;
const USER_ACTIVITY_CREATE_ADDRESS=5;
const USER_ACTIVITY_MAKE_PRIMARY_WALLET=6;
const USER_ACTIVITY_PROFILE_IMAGE_UPLOAD=7;
const USER_ACTIVITY_UPDATE_PASSWORD=8;
const USER_ACTIVITY_UPDATE_EMAIL=12;
const USER_ACTIVITY_ACTIVE=9;
const USER_ACTIVITY_HALF_ACTIVE=10;
const USER_ACTIVITY_INACTIVE=11;
const USER_ACTIVITY_LOGOUT=12;
const USER_ACTIVITY_PROFILE_UPDATE=13;

// Marketplace
//offer type
const BUY=1;
const BUYER=1;
const SELL=2;
const SELLER=2;
const BUY_SELL=3;

//rate type
const RATE_TYPE_DYNAMIC = 1;
const RATE_TYPE_STATIC = 2;

// price type
const RATE_ABOVE = 1;
const RATE_BELOW = 2;

// trade status
const TRADE_STATUS_INTERESTED = 0;
const TRADE_STATUS_ESCROW = 1;
const TRADE_STATUS_PAYMENT_DONE = 2;
const TRADE_STATUS_TRANSFER_DONE = 3;
const TRADE_STATUS_CANCEL = 4;
const TRADE_STATUS_REPORT = 5;
const TRADE_STATUS_CANCELLED_ADMIN = 6;

// escrow status
const ESCROW_STATUS_PENDING = 0;
const ESCROW_STATUS_SUCCESS = 1;
const ESCROW_STATUS_RETURN = 2;
const ESCROW_STATUS_RETURN_ADMIN = 3;

const AGREE = 1;
const NOT_AGREE = 2;

const CHECK_STATUS = 1;
const CHECK_WITHDRAWAL_STATUS = 2;
const CHECK_WITHDRAWAL_FEES = 3;
const CHECK_MINIMUM_WITHDRAWAL = 4;
const CHECK_MAXIMUM_WITHDRAWAL = 5;

const YES = 1;
const NO = 0;

const DEFAULT_COIN_TYPE="DEFAULT";
const COIN_TYPE_LTCT="LTCT";

const MALE = 1;
const FEMALE = 2;
const OTHER = 3;

const LANDING_BANNER_FOLDER = 'landing/banner';
const LANDING_TRADE_FOLDER = 'landing/trade';
const LANDING_ABOUT_FOLDER = 'landing/about';
const LANDING_FEATURE_FOLDER = 'landing/feature';
const LANDING_ADVANTAGE_FOLDER = 'landing/advantage';
const LANDING_WORK_FOLDER = 'landing/work';
const LANDING_PROCESS_FOLDER = 'landing/process';
const LANDING_TEAM_FOLDER = 'landing/team';
const LANDING_TESTIMONIAL_FOLDER = 'landing/testimonial';

const KYC_NID_REQUIRED = 1;
const KYC_PASSPORT_REQUIRED = 2;
const KYC_DRIVING_REQUIRED = 3;

const COMMAND_TYPE_CACHE = 1;
const COMMAND_TYPE_CONFIG = 2;
const COMMAND_TYPE_ROUTE = 3;
const COMMAND_TYPE_VIEW = 4;
const COMMAND_TYPE_WALLET = 5;
const COMMAND_TYPE_TRADE_FEES = 6;
const COMMAND_TYPE_MIGRATE = 7;
const COMMAND_TYPE_COIN_PAIR = 8;
const COMMAND_TYPE_PASSPORT_INSTALL = 9;
const COMMAND_TYPE_TOKEN_DEPOSIT = 10;
const COMMAND_TYPE_ADJUST_TOKEN_DEPOSIT = 11;
const COMMAND_TYPE_DISTRIBUTE_MEMBERSHIP_BONUS = 12;
const COMMAND_TYPE_CREATE_USERNAME = 13;
const COMMAND_TYPE_DB_SEEDER = 14;

//wallet types
const PERSONAL_WALLET = 1;
const CO_WALLET = 2;

//co wallet feature's admin settings
const CO_WALLET_FEATURE_ACTIVE_SLUG = 'co_wallet_feature_active';
const MAX_CO_WALLET_USER_SLUG = 'max_co_wallet_user';
const CO_WALLET_WITHDRAWAL_USER_APPROVAL_PERCENTAGE_SLUG = 'co_wallet_withdrawal_user_approval_percentage';
