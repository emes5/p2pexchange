<?php

namespace App\Services;

use App\Model\Role;
use App\Model\RolePermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RolePermissionService
{
    static $permission_data = null;
    static function getMenu(){
        $menus = [];
        $menus[] = [
            'title' => __('Dashboard'),
            'url' => route('adminDashboard'),
            'action' => 'dashboard',
            'icon' => asset('assets/admin/images/sidebar-icons/dashboard.svg'),
            'sub' => false,
            'status' => true
        ];
        $menus[] = [
            'title' => __('User Management'),
            'url' => '#',
            'action' => 'users',
            'icon' => asset('assets/admin/images/sidebar-icons/user.svg'),
            'sub' => true,
            'status' => self::check_permission('users','',true)
        ];
        $menus[] = [
            'title' => __('Admin Management'),
            'url' => '#',
            'action' => 'role',
            'icon' => asset('assets/user/images/sidebar-icons/user.svg'),
            'sub' => true,
            'status' => self::check_permission('role','',true)
        ];
        $menus[] = [
            'title' => __('Coin'),
            'url' => '#',
            'action' => 'coin',
            'icon' => asset('assets/admin/images/sidebar-icons/coin.svg'),
            'sub' => true,
            'status' => self::check_permission('coin','',true)
        ];
        $menus[] = [
            'title' => __('Buy Coin'),
            'url' => '#',
            'action' => 'buy_coin',
            'icon' => asset('assets/user/images/sidebar-icons/coin.svg'),
            'sub' => true,
            'status' => (self::check_permission('buy_coin','',true) && admin_feature_enable('buy_coin_feature'))
        ];
        $menus[] = [
            'title' => __('Wallet List'),
            'url' => route('adminWalletList'),
            'action' => 'pocket',
            'icon' => asset('assets/admin/images/sidebar-icons/wallet.svg'),
            'sub' => false,
            'status' => self::check_permission('pocket','adminWalletList')
        ];
        $menus[] = [
            'title' => __('Transaction History'),
            'url' => '#',
            'action' => 'transaction',
            'icon' => asset('assets/admin/images/sidebar-icons/Transaction-1.svg'),
            'sub' => true,
            'status' => self::check_permission('transaction','',true)
        ];
        $menus[] = [
            'title' => __('Offer List'),
            'url' => '#',
            'action' => 'offer',
            'icon' => asset('assets/user/images/sidebar-icons/My-Offer-1.svg'),
            'sub' => true,
            'status' => self::check_permission('offer','',true)
        ];
        $menus[] = [
            'title' => __('Trade'),
            'url' => '#',
            'action' => 'order',
            'icon' => asset('assets/user/images/sidebar-icons/Trade-1.svg'),
            'sub' => true,
            'status' => self::check_permission('order','',true)
        ];
        $menus[] = [
            'title' => __('Payment Method'),
            'url' => route('paymentMethodList'),
            'action' => 'payment_method',
            'icon' => asset('assets/user/images/sidebar-icons/Payment-method-1.svg'),
            'sub' => false,
            'status' => self::check_permission('payment_method','paymentMethodList')
        ];
        $menus[] = [
            'title' => __('Notification'),
            'url' => '#',
            'action' => 'notification',
            'icon' => asset('assets/admin/images/sidebar-icons/Notification.svg'),
            'sub' => true,
            'status' => self::check_permission('notification','',true)
        ];
        $menus[] = [
            'title' => __('Settings'),
            'url' => '#',
            'action' => 'setting',
            'icon' => asset('assets/admin/images/sidebar-icons/settings.svg'),
            'sub' => true,
            'status' => self::check_permission('setting','',true)
        ];
        $menus[] = [
            'title' => __('Logs'),
            'url' => route('adminLogs'),
            'action' => 'log',
            'icon' => asset('assets/user/images/sidebar-icons/Trade-1.svg'),
            'sub' => false,
            'status' => self::check_permission('log','adminLogs')
        ];
        return $menus;
    }

    static function getSubMenu($action){
        $sub_menu = [];
        $sub_menu['users'] = [
            [
                'title' => __('User'),
                'url' => route('adminUsers'),
                'action' => 'user',
                'status' => self::check_permission('user','adminUsers')
            ],
            [
                'title' => __('Pending ID Verification'),
                'url' => route('adminUserIdVerificationPending'),
                'action' => 'pending_id',
                'status' => self::check_permission('pending_id','adminUserIdVerificationPending')
            ]
        ];
        $sub_menu['coin'] = [
            [
                'title' => __('Coin List'),
                'url' => route('adminCoinList'),
                'action' => 'coin',
                'status' => self::check_permission('coin','adminCoinList')
            ],
            [
                'title' => __('Ico Phase List'),
                'url' => route('adminPhaseList'),
                'action' => 'phase',
                'status' => (self::check_permission('phase','adminPhaseList') && admin_feature_enable('buy_coin_feature'))
            ]
        ];
        $sub_menu['buy_coin'] = [
            [
                'title' => __('Buy Coin List'),
                'url' => route('adminPendingCoinOrder'),
                'action' => 'buy_coin',
                'status' => self::check_permission('buy_coin','adminPendingCoinOrder')
            ]
        ];
        $sub_menu['transaction'] = [
            [
                'title' => __('All Transaction'),
                'url' => route('adminTransactionHistory'),
                'action' => 'transaction_all',
                'status' => self::check_permission('transaction_all','adminTransactionHistory')
            ],
            [
                'title' => __('Pending Withdrawal'),
                'url' => route('adminPendingWithdrawal'),
                'action' => 'transaction_withdrawal',
                'status' => self::check_permission('transaction_withdrawal','adminPendingWithdrawal')
            ],
            [
                'title' => __('Pending Deposit History'),
                'url' => route('adminPendingDepositHistory'),
                'action' => 'pending_deposit',
                'status' => self::check_permission('pending_deposit','adminPendingDepositHistory')
            ],
            [
                'title' => __('Gas Sent History'),
                'url' => route('adminGasSendHistory'),
                'action' => 'gas_sent',
                'status' => self::check_permission('gas_sent','adminGasSendHistory')
            ],
            [
                'title' => __('Token Receive History'),
                'url' => route('adminTokenReceiveHistory'),
                'action' => 'receive_token',
                'status' => self::check_permission('receive_token','adminTokenReceiveHistory')
            ],
        ];
        $sub_menu['offer'] = [
            [
                'title' => __('Buy Offer'),
                'url' => route('offerList',BUY),
                'action' => 'buy_offer',
                'status' => self::check_permission('buy_offer','offerList')
            ],
            [
                'title' => __('Sell Offer'),
                'url' => route('offerList',SELL),
                'action' => 'sell_offer',
                'status' => self::check_permission('buy_offer','offerList')
            ],
        ];
        $sub_menu['order'] = [
            [
                'title' => __('Trade List'),
                'url' => route('orderList'),
                'action' => 'order',
                'status' => self::check_permission('order','orderList')
            ],
            [
                'title' => __('Dispute List'),
                'url' => route('orderDisputeList'),
                'action' => 'dispute',
                'status' => self::check_permission('dispute','orderDisputeList')
            ],
            [
                'title' => __('Payment Window'),
                'url' => route('adminPaymentWindowList'),
                'action' => 'payment_window',
                'status' => self::check_permission('payment_window','adminPaymentWindowList')
            ],
        ];
        $sub_menu['role'] = [
            [
                'title' => __('Admin List'),
                'url' => route('adminList'),
                'action' => 'admin_list',
                'status' => self::check_permission('admin_list','adminList')
            ],
            [
                'title' => __('Role Management'),
                'url' => route('roleList'),
                'action' => 'role_section',
                'status' => self::check_permission('role_section','roleList')
            ],
        ];
        $sub_menu['notification'] = [
            [
                'title' => __('Notification'),
                'url' => route('sendNotification'),
                'action' => 'notify',
                'status' => self::check_permission('notify','sendNotification')
            ],
            [
                'title' => __('Bulk Email'),
                'url' => route('sendEmail'),
                'action' => 'email',
                'status' => self::check_permission('email','sendEmail')
            ],
        ];
        $sub_menu['setting'] = [
            [
                'title' => __('Feature Settings'),
                'url' => route('adminFeatureSettings'),
                'action' => 'feature',
                'status' => self::check_permission('feature','adminFeatureSettings')
            ],
            [
                'title' => __('General Settings'),
                'url' => route('adminSettings'),
                'action' => 'general',
                'status' => self::check_permission('general','adminSettings')
            ],
//            [
//                'title' => __('Landing Settings'),
//                'url' => route('landingSettings'),
//                'action' => 'landing',
//                'status' => self::check_permission('landing','landingSettings')
//            ],
            [
                'title' => __('Custom Pages'),
                'url' => route('adminCustomPageList'),
                'action' => 'custom_pages',
                'status' => self::check_permission('custom_pages','adminCustomPageList')
            ],
            [
                'title' => __('Landing Page Settings'),
                'url' => route('landingPageSettings'),
                'action' => 'landing',
                'status' => self::check_permission('landing','landingPageSettings')
            ],
            [
                'title' => __('Footer Settings'),
                'url' => route('landingPageFooterSettings'),
                'action' => 'footer_setting',
                'status' => self::check_permission('footer_setting','landingPageFooterSettings')
            ],
            [
                'title' => __('Bank Settings'),
                'url' => route('bankList'),
                'action' => 'bank',
                'status' => (self::check_permission('bank','bankList')  && admin_feature_enable('bankList'))
            ],
            [
                'title' => __('Testimonial'),
                'url' => route('adminTestimonialList'),
                'action' => 'testimonial',
                'status' => self::check_permission('testimonial','adminTestimonialList')
            ],
            [
                'title' => __('Subscribers'),
                'url' => route('subscribers'),
                'action' => 'subscribers',
                'status' => self::check_permission('subscribers','subscribers')
            ],
            [
                'title' => __('FAQ'),
                'url' => route('adminFaqList'),
                'action' => 'faq',
                'status' => self::check_permission('faq','adminFaqList')
            ],
            [
                'title' => __('Configuration'),
                'url' => route('adminConfiguration'),
                'action' => 'config',
                'status' => self::check_permission('config','adminConfiguration')
            ],
        ];

        return $sub_menu[$action];
    }

    static function permission($list = false){
        $permission = [];
        $permission['dashboard'] = [
           [
            'for' => __('Dashboard'),
            'name' => 'adminDashboard',
            'slug' => 'read',
            'title' => __('Read'),
            'status' => false
           ],
            [
                'for' => 'other',
                'name' => 'dashboard',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => false
            ],
        ];
        $permission['user'] = [
            [
                'for' => __('User List'),
                'name' => 'adminUsers',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('User List'),
                'name' => "admin_UserAddEdit",
                'slug' => 'create',
                'title' => __('Create'),
                'status' => true
            ],
            [
                'for' => __('User List'),
                'name' => "admin_UserEdit",
                'slug' => 'update',
                'title' => __('Update'),
                'status' => true
            ],
            [
                'for' => __('User List'),
                'name' => "admin_user_delete",
                'slug' => 'delete',
                'title' => __('Delete'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'user',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],

        ];
        $permission['admin_list'] = [
            [
                'for' => __('Sub Admin'),
                'name' => 'adminList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Sub Admin'),
                'name' => 'adminAddEdit',
                'slug' => 'create',
                'title' => __('Create'),
                'status' => true
            ],
            [
                'for' => __('Sub Admin'),
                'name' => 'adminEdit',
                'slug' => 'update',
                'title' => __('Update'),
                'status' => true
            ],
            [
                'for' => __('Sub Admin'),
                'name' => 'userStatusAction',
                'slug' => 'suspend',
                'title' => __('Suspend'),
                'status' => true
            ],
            [
                'for' => __('Sub Admin'),
                'name' => 'userStatusAction',
                'slug' => 'delete',
                'title' => __('Delete'),
                'status' => true
            ],
        ];
        $permission['role_section'] = [
            [
                'for' => __('Role Management'),
                'name' => 'roleList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Role Management'),
                'name' => 'roleAddEdit',
                'slug' => 'create',
                'title' => __('Create'),
                'status' => true
            ],
            [
                'for' => __('Role Management'),
                'name' => 'role-add-edit',
                'slug' => 'update',
                'title' => __('Update'),
                'status' => true
            ],
            [
                'for' => __('Role Management'),
                'name' => 'roleDelete',
                'slug' => 'delete',
                'title' => __('Delete'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'role_other',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ]
        ];
        $permission['pending_id'] = [
            [
                'for' => __('Pending ID Verification'),
                'name' => 'adminUserIdVerificationPending',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Pending ID Verification'),
                'name' => 'adminUserVerificationActive',
                'slug' => 'active',
                'title' => __('Active'),
                'status' => true
            ],
            [
                'for' => __('Pending ID Verification'),
                'name' => 'varificationReject',
                'slug' => 'reject',
                'title' => __('Reject'),
                'status' => true
            ],
        ];
        $permission['coin'] = [
            [
                'for' => __('Coin List'),
                'name' => 'adminCoinList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Coin List'),
                'name' => 'adminCoinUpdate',
                'slug' => 'update',
                'title' => __('Update'),
                'status' => true
            ],
            [
                'for' => __('Coin List'),
                'name' => 'adminCoinStatus',
                'slug' => 'status',
                'title' => __('Status'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'coin',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['phase'] = [
            [
                'for' => __('Ico Phase List'),
                'name' => 'adminPhaseList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => admin_feature_enable('buy_coin_feature')
            ],
            [
                'for' => 'other',
                'name' => 'phase',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['buy_coin'] = [
            [
                'for' => __('Buy Coin List'),
                'name' => 'adminPendingCoinOrder',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => admin_feature_enable('buy_coin_feature')
            ],
            [
                'for' => 'other',
                'name' => 'buy_coin',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['pocket'] = [
            [
                'for' => __('Wallet List'),
                'name' => 'adminWalletList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ]
        ];
        $permission['transaction_all'] = [
            [
                'for' => __('All Transaction'),
                'name' => 'adminTransactionHistory',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('All Transaction'),
                'name' => 'other',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ]
        ];
        $permission['transaction_withdrawal'] = [
            [
                'for' => __('Pending Withdrawal'),
                'name' => 'adminPendingWithdrawal',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Pending Withdrawal'),
                'name' => 'adminAcceptPendingWithdrawal',
                'slug' => 'accept',
                'title' => __('Accept'),
                'status' => true
            ],
            [
                'for' => __('Pending Withdrawal'),
                'name' => 'adminRejectPendingWithdrawal',
                'slug' => 'reject',
                'title' => __('Reject'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'other',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['pending_deposit'] = [
            [
                'for' => __('Pending Deposit History'),
                'name' => 'adminPendingDepositHistory',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Pending Deposit History'),
                'name' => 'adminPendingDepositAccept',
                'slug' => 'accept',
                'title' => __('Accept'),
                'status' => true
            ],
            [
                'for' => __('Pending Deposit History'),
                'name' => 'adminPendingDepositReject',
                'slug' => 'reject',
                'title' => __('Reject'),
                'status' => true
            ]
        ];
        $permission['gas_sent'] = [
            [
                'for' => __('Gas Sent History'),
                'name' => 'adminGasSendHistory',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
        ];
        $permission['receive_token'] = [
            [
                'for' => __('Token Receive History'),
                'name' => 'adminTokenReceiveHistory',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
        ];
        $permission['buy_offer'] = [
            [
                'for' => __('Buy Offer/Sell Offer'),
                'name' => 'offerList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Buy Offer'),
                'name' => 'offerDetails',
                'slug' => 'details',
                'title' => __('Details'),
                'status' => true
            ],
        ];
        $permission['order'] = [
            [
                'for' => __('Trade List'),
                'name' => 'orderList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Trade List'),
                'name' => 'orderDetails',
                'slug' => 'details',
                'title' => __('Details'),
                'status' => true
            ],

        ];
        $permission['dispute'] = [
            [
                'for' => __('Dispute List'),
                'name' => 'orderDisputeList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Dispute List'),
                'name' => 'orderDisputeDetails',
                'slug' => 'details',
                'title' => __('Details'),
                'status' => true
            ],
        ];
        $permission['payment_method'] = [
            [
                'for' => __('Payment Method'),
                'name' => 'paymentMethodList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Payment Method'),
                'name' => 'paymentMethodSave',
                'slug' => 'create',
                'title' => __('Create'),
                'status' => true
            ],
            [
                'for' => __('Payment Method'),
                'name' => 'paymentMethodSave',
                'slug' => 'update',
                'title' => __('update'),
                'status' => true
            ],
            [
                'for' => __('Payment Method'),
                'name' => 'paymentMethodStatusChange',
                'slug' => 'status',
                'title' => __('Status'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'payment_method',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['notify'] = [
            [
                'for' => __('Send Notification'),
                'name' => 'sendNotification',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Bulk Email'),
                'name' => 'sendNotificationProcess',
                'slug' => 'send',
                'title' => __('Send Notification'),
                'status' => true
            ]
        ];
        $permission['email'] = [
            [
                'for' => __('Bulk Email'),
                'name' => 'sendEmail',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Bulk Email'),
                'name' => 'sendEmailProcess',
                'slug' => 'send',
                'title' => __('Send Email'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'email',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['feature'] = [
            [
                'for' => __('Feature Settings'),
                'name' => 'adminFeatureSettings',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Feature Settings'),
                'name' => 'adminFeatureSettingsSave',
                'slug' => 'update',
                'title' => __('Update'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'feature',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['general'] = [
            [
                'for' => __('General Settings'),
                'name' => 'adminSettings',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('General Settings'),
                'name' => 'adminCommonSettings',
                'slug' => 'etting',
                'title' => __('Setting'),
                'status' => true
            ],
            [
                'for' => __('General Settings'),
                'name' => 'adminSaveEmailSettings',
                'slug' => 'email',
                'title' => __('Email'),
                'status' => true
            ],
            [
                'for' => __('General Settings'),
                'name' => 'adminSaveSmsSettings',
                'slug' => 'twillo',
                'title' => __('Twillo'),
                'status' => true
            ],
            [
                'for' => __('General Settings'),
                'name' => 'adminReferralFeesSettings',
                'slug' => 'referral',
                'title' => __('Referral'),
                'status' => true
            ],
            [
                'for' => __('General Settings'),
                'name' => 'adminSavePaymentSettings',
                'slug' => 'coin_payment',
                'title' => __('Coin Payment'),
                'status' => true
            ],
            [
                'for' => __('General Settings'),
                'name' => 'adminSaveDefaultCoinSettings',
                'slug' => 'default_coin',
                'title' => __('Default Coin'),
                'status' => true
            ],
            [
                'for' => __('General Settings'),
                'name' => 'adminSaveTermsCondition',
                'slug' => 'privacy_policy',
                'title' => __('Privacy Policy'),
                'status' => true
            ],
            [
                'for' => __('General Settings'),
                'name' => 'adminSaveKycSettings',
                'slug' => 'kyc',
                'title' => __('KYC'),
                'status' => true
            ],
            [
                'for' => __('General Settings'),
                'name' => 'adminSaveChartSettings',
                'slug' => 'chart',
                'title' => __('Chart'),
                'status' => true
            ],
            [
                'for' => __('General Settings'),
                'name' => 'adminSaveFontSettings',
                'slug' => 'font',
                'title' => __('Font'),
                'status' => true
            ],
//            [
//                'for' => 'other',
//                'name' => 'general',
//                'slug' => 'other',
//                'title' => __('Other'),
//                'status' => true
//            ],
        ];
//        $permission['landing'] = [
//            [
//                'for' => __('Landing Settings'),
//                'name' => 'landingSettings',
//                'slug' => 'read',
//                'title' => __('Read'),
//                'status' => true
//            ],
//        [
//            'for' => 'other',
//            'name' => 'landing',
//            'slug' => 'other',
//            'title' => __('Other'),
//            'status' => true
//        ],
//        ];
        $permission['custom_pages'] = [
            [
                'for' => __('Custom Pages'),
                'name' => 'adminCustomPageList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Custom Pages'),
                'name' => 'adminCustomPageSave',
                'slug' => 'create',
                'title' => __('Create'),
                'status' => true
            ],
            [
                'for' => __('Custom Pages'),
                'name' => 'adminCustomPageSave',
                'slug' => 'edit',
                'title' => __('Edit'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'custom_pages',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['landing'] = [
            [
                'for' => __('Landing Page Settings'),
                'name' => 'landingPageSettings',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'landing',
                'slug' => 'other',
                'title' => __('Update'),
                'status' => true
            ],
        ];
        $permission['footer_setting'] = [
            [
                'for' => __('Footer Settings'),
                'name' => 'landingPageFooterSettings',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Footer Settings'),
                'name' => 'landingPageFooterSave',
                'slug' => 'update',
                'title' => __('Update'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'footer_setting',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['bank'] = [
            [
                'for' => __('Bank Settings'),
                'name' => 'bankList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'bank',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['testimonial'] = [
            [
                'for' => __('Testimonial'),
                'name' => 'adminTestimonialList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Testimonial'),
                'name' => 'adminTestimonialSave',
                'slug' => 'create',
                'title' => __('Create'),
                'status' => true
            ],
            [
                'for' => __('Testimonial'),
                'name' => 'adminTestimonialSave',
                'slug' => 'update',
                'title' => __('Update'),
                'status' => true
            ],
            [
                'for' => __('Testimonial'),
                'name' => 'adminTestimonialDelete',
                'slug' => 'delete',
                'title' => __('Delete'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'testimonial',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['subscribers'] = [
            [
                'for' => __('Subscribers'),
                'name' => 'subscribers',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
        ];
        $permission['faq'] = [
            [
                'for' => __('FAQ'),
                'name' => 'adminFaqList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('FAQ'),
                'name' => 'adminFaqSave',
                'slug' => 'Create',
                'title' => __('Create'),
                'status' => true
            ],
            [
                'for' => __('FAQ'),
                'name' => 'adminFaqSave',
                'slug' => 'update',
                'title' => __('Update'),
                'status' => true
            ],
            [
                'for' => __('FAQ'),
                'name' => 'adminFaqDelete',
                'slug' => 'delete',
                'title' => __('Delete'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'faq',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['config'] = [
            [
                'for' => __('Configuration'),
                'name' => 'adminConfiguration',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => 'other',
                'name' => 'config',
                'slug' => 'other',
                'title' => __('Other'),
                'status' => true
            ],
        ];
        $permission['log'] = [
            [
                'for' => __('Admin Logs'),
                'name' => 'adminLogs',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
        ];
        $permission['payment_window'] = [
            [
                'for' => __('Payment Window'),
                'name' => 'adminPaymentWindowList',
                'slug' => 'read',
                'title' => __('Read'),
                'status' => true
            ],
            [
                'for' => __('Payment Window'),
                'name' => 'adminPaymentWindowAdd',
                'slug' => 'payment_window_add',
                'title' => __('Others'),
                'status' => true
            ],
            [
                'for' => __('Payment Window'),
                'name' => 'adminPaymentWindowSave',
                'slug' => 'create',
                'title' => __('Create'),
                'status' => true
            ],
            [
                'for' => __('Payment Window'),
                'name' => 'adminPaymentWindowEdit',
                'slug' => 'update',
                'title' => __('Update'),
                'status' => true
            ],
            [
                'for' => __('Payment Window'),
                'name' => 'adminPaymentWindowDelete',
                'slug' => 'delete',
                'title' => __('Delete'),
                'status' => true
            ],
        ];

        if($list) return $permission;
    }

    public function create_permission($request,$id){
        $array_data = array_keys($request);
        RolePermission::where('role_id', $id)->delete();
        foreach ($array_data as $item){
            foreach(getPermissionField() as $name => $row) {
                foreach ($row as $field) {
                    if($item == $field['name']){
                        $data['role_id'] = $id;
                        $data['group'] = $name;
                        $data['name'] = $field['name'];
                        $data['slug'] = $field['slug'];
                        $data['status'] = true;
                        RolePermission::create($data);
                    }
                }
            }
        }

    }

    public function addOrEditRole($request){
        DB::beginTransaction();
        try{
            if(!isset($request->id)){
                $role_id = Role::create([
                    'title' => $request->title
                ]);
                $this->create_permission($request->except(['_token','title']),$role_id->id);
            }else{
                $role = Role::where('id',$request->id)->update([
                    'title' => $request->title
                ]);
                $this->create_permission($request->except(['_token','title']),$request->id);
            }

        }catch (\Exception $e){
            dd($e);
            return false;
        }
        DB::commit();
        return true;
    }

    static function check_permission($group, $url, $sub = false){
        if(Auth::user()->role == 1) return true;
        if(self::$permission_data == null)
            self::$permission_data = RolePermission::where('role_id',Auth::user()->role_id)->get();
        $sub_menu = $sub ? getAllSubMenus($group) : [];
        foreach (self::$permission_data as $permission){
            if($sub){
                foreach ($sub_menu as $menu) {
                    if (($permission->group == $menu['action']) && ($permission->slug == 'read')) {
                        if ($permission->status == 1) return true;
                    }
                }
            }else{
                if(($permission->group == $group) && ($permission->name == $url) && ($permission->slug == 'read')){
                    if($permission->status == 1) return true;
                    return false;
                }
            }
        }
        return false;
    }
}

