<?php

// Route::group(['group' => 'dashboard','middleware'=> ['permission']],function (){});
Route::group(['prefix'=>'admin','namespace'=>'admin','middleware'=> ['auth','admin','default_lang']],function () {
    // Logs
    Route::group(['group' => 'log','middleware'=> ['permission']],function () {
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('adminLogs');
    });

    Route::group(['group' => 'dashboard','middleware'=> []],function (){
        Route::get('dashboard', 'DashboardController@adminDashboard')->name('adminDashboard');
    });

    Route::group(['group' => 'user','middleware'=> ['permission']],function (){
        Route::get('users', 'UserController@adminUsers')->name('adminUsers');
        Route::get('user-add', 'UserController@UserAddEdit')->name('admin.UserAddEdit');
        Route::get('user-edit', 'UserController@UserEdit')->name('admin.UserEdit');

        Route::get('country-list', 'DashboardController@adminCountryList')->name('adminCountryList');
        Route::post('country-status-change', 'DashboardController@countryStatusChange')->name('countryStatusChange');
        Route::get('profile', 'DashboardController@adminProfile')->name('adminProfile');
        Route::post('user-profile-update', 'DashboardController@UserProfileUpdate')->name('UserProfileUpdate');
        Route::post('upload-profile-image', 'DashboardController@uploadProfileImage')->name('uploadProfileImage');
        Route::get('users', 'UserController@adminUsers')->name('adminUsers');
        Route::get('user-profile', 'UserController@adminUserProfile')->name('adminUserProfile');
        Route::get('user-delete-{id}', 'UserController@adminUserDelete')->name('admin.user.delete');
        Route::get('user-suspend-{id}', 'UserController@adminUserSuspend')->name('admin.user.suspend');
        Route::get('user-active-{id}', 'UserController@adminUserActive')->name('admin.user.active');
        Route::get('user-remove-gauth-set-{id}', 'UserController@adminUserRemoveGauth')->name('admin.user.remove.gauth');
        Route::get('user-email-verify-{id}', 'UserController@adminUserEmailVerified')->name('admin.user.email.verify');
        Route::get('user-phone-verify-{id}', 'UserController@adminUserPhoneVerified')->name('admin.user.phone.verify');
        Route::get('deleted-users', 'UserController@adminDeletedUser')->name('adminDeletedUser');
        Route::get('verification-details-{id}', 'UserController@VerificationDetails')->name('adminUserDetails');
    });

    //    Sub Admin list
    Route::group(['group' => 'admin_list','middleware'=> ['permission']],function () {
        Route::any('admins', 'AdminController@adminList')->name('adminList');
        Route::post('admin-add', 'AdminController@adminAddEdit')->name('adminAddEdit');
        Route::get('admin-edit', 'AdminController@adminEdit')->name('adminEdit');
        Route::post('user-status-action', 'UserController@userStatusAction')->name('userStatusAction');
    });

    //role permission
    Route::group(['group' => 'role_section','middleware'=> ['permission']],function () {
        Route::get('role-list', 'RoleController@list')->name('roleList');
        Route::get('role-edit-add', 'RoleController@addOrEditPage')->name('role-add-edit');
        Route::post('role-edit-add', 'RoleController@addOrEdit')->name('roleAddEdit');
        Route::get('role-details-{id}', 'RoleController@roleDetails')->name('roleDetails');
        Route::get('role-delete-{id}', 'RoleController@roleDelete')->name('roleDelete');
    });

    // ID Varification
    Route::group(['group' => 'pending_id','middleware'=> ['permission']],function (){
        Route::get('pending-id-verified-user', 'UserController@adminUserIdVerificationPending')->name('adminUserIdVerificationPending');
        Route::get('verification-active-{id}-{type}', 'UserController@adminUserVerificationActive')->name('adminUserVerificationActive');
        Route::get('verification-reject', 'UserController@varificationReject')->name('varificationReject');
    });

    Route::group(['group' => 'coin','middleware'=> ['permission']],function (){
        Route::get('coin-list', 'CoinController@adminCoinList')->name('adminCoinList');
        Route::get('coin-edit-{id}', 'CoinController@adminCoinEdit')->name('adminCoinEdit');
        Route::post('coin-details-update', 'CoinController@adminCoinUpdate')->name('adminCoinUpdate');
        Route::post('change-coin-status', 'CoinController@adminCoinStatus')->name('adminCoinStatus');
    });

    Route::group(['middleware'=> ['feature.buy_coin']],function () {
        Route::get('buy-coin-order', 'CoinController@adminPendingCoinOrder')->name('adminPendingCoinOrder');
        Route::get('approved-coin-order', 'CoinController@adminApprovedOrder')->name('adminApprovedOrder');
        Route::get('rejected-coin-order', 'CoinController@adminRejectedOrder')->name('adminRejectedOrder');
        Route::get('accept-pending-buy-coin-{id}', 'CoinController@adminAcceptPendingBuyCoin')->name('adminAcceptPendingBuyCoin');
        Route::get('reject-pending-buy-coin-{id}', 'CoinController@adminRejectPendingBuyCoin')->name('adminRejectPendingBuyCoin');

        Route::get('banks', 'BankController@bankList')->name('bankList');
        Route::get('bank-add', 'BankController@bankAdd')->name('bankAdd');
        Route::get('bank-edit-{id}', 'BankController@bankEdit')->name('bankEdit');
        Route::get('bank-delete-{id}', 'BankController@bankDelete')->name('bankDelete');
        Route::post('bank-add-process', 'BankController@bankAddProcess')->name('bankAddProcess');

        Route::get('ico-phase-list', 'PhaseController@adminPhaseList')->name('adminPhaseList');
        Route::get('ico-phase-add', 'PhaseController@adminPhaseAdd')->name('adminPhaseAdd');
        Route::get('phase-edit-{id}', 'PhaseController@phaseEdit')->name('phaseEdit');
        Route::get('phase-delete-{id}', 'PhaseController@phaseDelete')->name('phaseDelete');
        Route::get('phase-change-{id}', 'PhaseController@phaseStatusChange')->name('phaseStatusChange');
        Route::post('ico-phase-add-process', 'PhaseController@adminPhaseAddProcess')->name('adminPhaseAddProcess');
    });

    Route::group(['group' => 'pocket','middleware'=> ['permission']],function (){
        Route::get('wallet-list', 'TransactionController@adminWalletList')->name('adminWalletList');
    });
    Route::group(['group' => 'transaction_all','middleware'=> ['permission']],function (){
        Route::get('transaction-history', 'TransactionController@adminTransactionHistory')->name('adminTransactionHistory');
        Route::get('withdrawal-history', 'TransactionController@adminWithdrawalHistory')->name('adminWithdrawalHistory');
    });
    Route::group(['group' => 'transaction_withdrawal','middleware'=> ['permission']],function (){
        Route::get('pending-withdrawal', 'TransactionController@adminPendingWithdrawal')->name('adminPendingWithdrawal');
        Route::get('rejected-withdrawal', 'TransactionController@adminRejectedWithdrawal')->name('adminRejectedWithdrawal');
        Route::get('active-withdrawal', 'TransactionController@adminActiveWithdrawal')->name('adminActiveWithdrawal');
        Route::get('accept-pending-withdrawal-{id}', 'TransactionController@adminAcceptPendingWithdrawal')->name('adminAcceptPendingWithdrawal');
        Route::get('reject-pending-withdrawal-{id}', 'TransactionController@adminRejectPendingWithdrawal')->name('adminRejectPendingWithdrawal');
    });
    Route::group(['group' => 'gas_sent','middleware'=> ['permission']],function (){
        Route::get('gas-send-history', 'TransactionController@adminGasSendHistory')->name('adminGasSendHistory');
    });
    Route::group(['group' => 'receive_token','middleware'=> ['permission']],function (){
        Route::get('token-receive-history', 'TransactionController@adminTokenReceiveHistory')->name('adminTokenReceiveHistory');
    });

    Route::group(['group' => 'faq','middleware'=> ['permission']],function (){
        Route::get('faq-list', 'SettingsController@adminFaqList')->name('adminFaqList');
        Route::get('faq-add', 'SettingsController@adminFaqAdd')->name('adminFaqAdd');
        Route::post('faq-save', 'SettingsController@adminFaqSave')->name('adminFaqSave');
        Route::get('faq-edit-{id}', 'SettingsController@adminFaqEdit')->name('adminFaqEdit');
        Route::get('faq-delete-{id}', 'SettingsController@adminFaqDelete')->name('adminFaqDelete');
    });

    Route::group(['group' => 'feature','middleware'=> ['permission']],function (){
        Route::get('feature-settings', 'SettingsController@adminFeatureSettings')->name('adminFeatureSettings');
        Route::post('save-feature-settings', 'SettingsController@adminFeatureSettingsSave')->name('adminFeatureSettingsSave');
    });

    Route::group(['group' => 'general','middleware'=> ['permission']],function (){
        Route::get('general-settings', 'SettingsController@adminSettings')->name('adminSettings');
        Route::post('common-settings', 'SettingsController@adminCommonSettings')->name('adminCommonSettings');
        Route::post('email-save-settings', 'SettingsController@adminSaveEmailSettings')->name('adminSaveEmailSettings');
        Route::post('sms-save-settings', 'SettingsController@adminSaveSmsSettings')->name('adminSaveSmsSettings');
        Route::post('referral-fees-settings', 'SettingsController@adminReferralFeesSettings')->name('adminReferralFeesSettings');
        Route::post('save-payment-settings', 'SettingsController@adminSavePaymentSettings')->name('adminSavePaymentSettings');
        Route::post('save-default-coin-settings', 'SettingsController@adminSaveDefaultCoinSettings')->name('adminSaveDefaultCoinSettings');
        Route::post('terms-condition', 'SettingsController@adminSaveTermsCondition')->name('adminSaveTermsCondition');
        Route::post('save-kyc-settings', 'SettingsController@adminSaveKycSettings')->name('adminSaveKycSettings');
        Route::post('chart-save', 'SettingsController@adminSaveChartSettings')->name('adminSaveChartSettings');
        Route::post('save-font-settings', 'SettingsController@adminSaveFontSettings')->name('adminSaveFontSettings');
    });

    Route::get('payment-methods', 'SettingsController@adminPaymentSetting')->name('adminPaymentSetting');
    Route::post('change-payment-methods', 'SettingsController@changePaymentMethodStatus')->name('changePaymentMethodStatus');

    Route::post('withdrawal-settings', 'SettingsController@adminWithdrawalSettings')->name('adminWithdrawalSettings');
    Route::post('order-settings', 'SettingsController@adminOrderSettings')->name('adminOrderSettings');

    Route::group(['group' => 'email','middleware'=> ['permission']],function (){
        Route::get('send-email', 'DashboardController@sendEmail')->name('sendEmail');
        Route::post('send-email-process', 'DashboardController@sendEmailProcess')->name('sendEmailProcess');
        Route::get('clear-email', 'DashboardController@clearEmailRecord')->name('clearEmailRecord');
    });
    Route::group(['group' => 'notify','middleware'=> ['permission']],function () {
        Route::get('send-notification', 'DashboardController@sendNotification')->name('sendNotification');
        Route::post('send-notification-process', 'DashboardController@sendNotificationProcess')->name('sendNotificationProcess');
    });

    //landing setting
    Route::group(['group' => 'landing','middleware'=> ['permission']],function (){
        Route::get('landing-settings', 'LandingController@landingSettings')->name('landingSettings');
        Route::get('landing-page-settings', 'LandingController@landingPageSettings')->name('landingPageSettings');
        Route::post('update-landing-settings', 'LandingController@updateLandingSettings')->name('updateLandingSettings');

        Route::post('save-section', 'LandingController@saveSection')->name('saveSection');
        Route::post('save-banner', 'LandingController@saveBanner')->name('saveBanner');
        Route::post('save-trade-anywhere', 'LandingController@saveTradeAnywhere')->name('saveTradeAnywhere');
        Route::post('save-about', 'LandingController@saveAbout')->name('saveAbout');
        Route::post('save-feature', 'LandingController@saveFeature')->name('saveFeature');
        Route::post('save-advantage', 'LandingController@saveAdvantage')->name('saveAdvantage');
        Route::post('save-work', 'LandingController@saveWork')->name('saveWork');
        Route::post('save-coin-buy-sell', 'LandingController@saveCoinBuySell')->name('saveCoinBuySell');
        Route::post('save-process', 'LandingController@saveProcess')->name('saveProcess');
        Route::post('save-testimonial', 'LandingController@saveTestimonial')->name('saveTestimonial');
        Route::post('save-team', 'LandingController@saveTeam')->name('saveTeam');
        Route::post('save-faq', 'LandingController@saveFaq')->name('saveFaq');
        Route::post('save-subscribe', 'LandingController@saveSubscribe')->name('saveSubscribe');
        Route::post('save-primary-color', 'LandingController@savePrimaryColor')->name('savePrimaryColor');
        Route::post('save-hover-color', 'LandingController@saveHoverColor')->name('saveHoverColor');
        Route::post('save-and-publish', 'LandingController@saveAndPublish')->name('saveAndPublish');

        Route::post('get-feature-data', 'LandingController@getFeatureData')->name('getFeatureData');
        Route::post('delete-feature-data', 'LandingController@deleteFeatureData')->name('deleteFeatureData');

        Route::post('save-coin-buy-sell-details', 'LandingController@saveCoinBuySellDetails')->name('saveCoinBuySellDetails');
        Route::post('save-feature-details', 'LandingController@saveFeatureDetails')->name('saveFeatureDetails');
        Route::post('save-advantage-details', 'LandingController@saveAdvantageDetails')->name('saveAdvantageDetails');
        Route::post('save-process-details', 'LandingController@saveProcessDetails')->name('saveProcessDetails');
        Route::post('save-testimonial-details', 'LandingController@saveTestimonialDetails')->name('saveTestimonialDetails');
        Route::post('save-team-details', 'LandingController@saveTeamDetails')->name('saveTeamDetails');
        Route::post('save-faq-details', 'LandingController@saveFaqDetails')->name('saveFaqDetails');
        Route::post('save-work-details', 'LandingController@saveWorkDetails')->name('saveWorkDetails');

        Route::post('update-pexer-feature', 'LandingController@updatePexerFeature')->name('updatePexerFeature');
        Route::post('delete-pexer-feature', 'LandingController@pexerFeatureDelete')->name('pexerFeatureDelete');
    });


    Route::group(['group' => 'subscribers','middleware'=> ['permission']],function (){
        Route::get('subscribers', 'LandingController@subscribers')->name('subscribers');
    });

    //testimonial
    Route::group(['group' => 'testimonial','middleware'=> ['permission']],function (){
        Route::get('testimonial-list', 'LandingController@adminTestimonialList')->name('adminTestimonialList');
        Route::get('testimonial-add', 'LandingController@adminTestimonialAdd')->name('adminTestimonialAdd');
        Route::post('testimonial-save', 'LandingController@adminTestimonialSave')->name('adminTestimonialSave');
        Route::get('testimonial-edit-{id}', 'LandingController@adminTestimonialEdit')->name('adminTestimonialEdit');
        Route::get('testimonial-delete-{id}', 'LandingController@adminTestimonialDelete')->name('adminTestimonialDelete');
    });
    //payment window
    Route::group(['group' => 'payment_window','middleware'=> ['permission']],function (){
        Route::get('payment-window-list', 'PaymentWindowController@adminPaymentWindowList')->name('adminPaymentWindowList');
        Route::get('payment-window-add', 'PaymentWindowController@adminPaymentWindowAdd')->name('adminPaymentWindowAdd');
        Route::post('payment-window-save', 'PaymentWindowController@adminPaymentWindowSave')->name('adminPaymentWindowSave');
        Route::get('payment-window-edit-{id}', 'PaymentWindowController@adminPaymentWindowEdit')->name('adminPaymentWindowEdit');
        Route::get('payment-window-delete-{id}', 'PaymentWindowController@adminPaymentWindowDelete')->name('adminPaymentWindowDelete');
    });

    // marketplace
    Route::group(['namespace'=>'marketplace','middleware'=> []],function () {
        Route::get('user-trade-profile-{id}', 'MarketplaceController@userTradeProfile')->name('userTradingProfile');

        Route::group(['group' => 'payment_method','middleware'=> ['permission']],function (){
            Route::get('payment-method-list', 'PaymentMethodController@paymentMethodList')->name('paymentMethodList');
            Route::get('add-payment-method', 'PaymentMethodController@addPaymentMethod')->name('addPaymentMethod');
            Route::get('edit-payment-method/{id}', 'PaymentMethodController@editPaymentMethod')->name('editPaymentMethod');
            Route::post('payment-method-save-process', 'PaymentMethodController@paymentMethodSave')->name('paymentMethodSave');
            Route::post('payment-method-status-change', 'PaymentMethodController@paymentMethodStatusChange')->name('paymentMethodStatusChange');
        });


        Route::group(['group' => 'buy_offer','middleware'=> ['permission']],function (){
            Route::get('offer-list-{type}', 'MarketplaceController@offerList')->name('offerList');
            Route::get('offer-details-{id}-{type}', 'MarketplaceController@offerDetails')->name('offerDetails');
        });

        Route::group(['group' => 'order','middleware'=> ['permission']],function (){
            Route::get('order-list', 'MarketplaceController@orderList')->name('orderList');
            Route::get('order-details/{id}', 'MarketplaceController@orderDetails')->name('orderDetails');
        });

        Route::group(['group' => 'dispute','middleware'=> ['permission']],function (){
            Route::get('order-dispute-list', 'MarketplaceController@orderDisputeList')->name('orderDisputeList');
            Route::get('order-disputes/{id}', 'MarketplaceController@orderDisputeDetails')->name('orderDisputeDetails');
        });


        Route::get('admin-refund-escrow/{id}', 'MarketplaceController@adminRefundEscrow')->name('adminRefundEscrow');
        Route::get('admin-release-escrow/{id}', 'MarketplaceController@adminReleaseEscrow')->name('adminReleaseEscrow');
    });

    // custom page
    Route::group(['group' => 'custom_pages','middleware'=> ['permission']],function (){
        Route::get('custom-page-list', 'LandingController@adminCustomPageList')->name('adminCustomPageList');
        Route::get('custom-page-slug-check', 'LandingController@customPageSlugCheck')->name('customPageSlugCheck');
        Route::get('custom-page-add', 'LandingController@adminCustomPageAdd')->name('adminCustomPageAdd');
        Route::get('custom-page-edit/{id}', 'LandingController@adminCustomPageEdit')->name('adminCustomPageEdit');
//    Route::get('custom-page-delete/{id}', 'LandingController@adminCustomPageDelete')->name('adminCustomPageDelete');
//    Route::get('custom-page-order', 'LandingController@customPageOrder')->name('customPageOrder');
        Route::post('custom-page-save', 'LandingController@adminCustomPageSave')->name('adminCustomPageSave');
    });

    Route::group(['group' => 'footer_setting','middleware'=> ['permission']],function (){
        Route::get('landing-page-footer-settings', 'LandingController@landingPageFooterSettings')->name('landingPageFooterSettings');
        Route::post('get-landing-footer-info', 'LandingController@getlandingFooterInfo')->name('getlandingFooterInfo');
        Route::post('landing-page-footer-save', 'LandingController@landingPageFooterSave')->name('landingPageFooterSave');
    });

    Route::post('download-and-store-font-file', 'FontSettingController@downloadAndStoreFontFile')->name('downloadAndStoreFontFile');
    Route::get('test-web3', 'TestWeb3Controller@index')->name('testWeb3');
    Route::get('admin-config', 'ConfigController@adminConfiguration')->name('adminConfiguration');
    Route::get('run-admin-command/{type}', 'ConfigController@adminRunCommand')->name('adminRunCommand');

    Route::group(['group' => 'pending_deposit','middleware'=> ['permission']],function (){
        Route::get('pending-token-deposit-history', 'TransactionController@adminPendingDepositHistory')->name('adminPendingDepositHistory');
        Route::get('pending-token-deposit-accept-{id}', 'TransactionController@adminPendingDepositAccept')->name('adminPendingDepositAccept');
        Route::get('pending-token-deposit-reject-{id}', 'TransactionController@adminPendingDepositReject')->name('adminPendingDepositReject');
    });


    Route::post('send_test_mail','SettingsController@testMail')->name('testmailsend');
});
Route::group(['prefix'=>'admin','namespace'=>'admin','middleware'=> []],function () {
    Route::get('check-node-url', 'DashboardController@adminCheckNodeUrl')->name('adminCheckNodeUrl');
});
