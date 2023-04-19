<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/coin-payment-notifier','Api\WalletNotifier@coinPaymentNotifier')->name('coinPaymentNotifier');

Route::group(['namespace' => 'Api'], function () {
    Route::post('sign-up','AuthController@signUp');
    Route::post('sign-in','AuthController@login');
    Route::post('email-verify','AuthController@emailVerify');
    Route::post('forgot-password','AuthController@sendResetCode');
    Route::post('reset-password','AuthController@resetPassword');
    Route::post('resend-email-verification-code', 'AuthController@resendEmailVerificationCode');
});

Route::group(['namespace' => 'Api', 'middleware' => 'auth:api'], function () {
    Route::post('g2f-verify-app','AuthController@g2fVerifyApp')->name('g2fVerifyApp');
});
Route::group(['namespace' => 'Api', 'middleware' => ['auth:api','two_step']], function () {
    Route::get('profile-view', 'User\ProfileController@profileView');
    Route::get('profile-edit', 'User\ProfileController@profileEdit');
    Route::post('save-edited-profile', 'User\ProfileController@saveEditedProfile');
    Route::post('send-verification-code', 'User\ProfileController@sendPhoneVerificationCode');
    Route::post('verify-verification-code', 'User\ProfileController@verifyPhoneVerificationCode');
    Route::post('change-password', 'AuthController@changePassword');
    Route::get('id-verification', 'User\ProfileController@idVerificationInfo');
    Route::post('submit-verification-images', 'User\ProfileController@submitVerificationImages');
    Route::get('activity-list', 'User\DashboardController@activityList');
    Route::get('notification-list', 'User\DashboardController@notificationList');
    Route::get('faq-list', 'User\DashboardController@faqList');
    Route::post('set-notification-status', 'User\DashboardController@setNotificationStatus');
    Route::post('save-language', 'User\ProfileController@saveLanguage')->name('saveLanguage');
    Route::post('google-secret-save', 'User\ProfileController@googleSecretSave')->name('googleSecretSave');
    Route::get('user-dashboard-app', 'User\DashboardController@userDashboardApp');
    Route::get('deposite-or-withdraw-list','User\DashboardController@depositeOrWithdrawList');
    Route::get('deposite-and-withdraw-list','User\DashboardController@depositeAndWithdrawList');
    Route::get('user-wallet-list', 'User\WalletController@myPocketList');
    Route::get('wallet-coin-list', 'User\WalletController@pocketCoinList');
    Route::post('create-wallet','User\WalletController@createWallet');
    Route::get('wallet-details-app', 'User\WalletController@walletDetailsByid');
    Route::get('goto-address-app','User\WalletController@gotoAddressApp');
    Route::post('generate-new-address','User\WalletController@generateNewAddressApp');
    Route::get('show-pass-address','User\WalletController@showPassAddress');
    Route::get('deposit-list','User\WalletController@depositList');
    Route::get('withdraw-list','User\WalletController@withdrawList');
    Route::post('withdrawal-process', 'User\WalletController@withdrawalProcess')->name('withdrawalProcess');
    Route::get('generate-referral-link','User\ReferralController@generateReferralLink');
    Route::get('my-reference-referral','User\ReferralController@myReferenceReferral');
    Route::get('my-reference-list','User\ReferralController@myReferenceList');
    Route::get('my-earnings','User\ReferralController@myEarnings');
    Route::get('general-settings','User\ProfileController@generalSettings')->name('generalSettings');
    Route::get('goto-setting-page','User\ProfileController@gotoSettingPage')->name('gotoSettingPage');
    Route::get('offer-list','User\OfferController@offerList')->name('offerList');
    Route::get('create-offer','User\OfferController@createOffer')->name('createOffer');
    Route::post('save-offer','User\OfferController@saveoffer')->name('saveOffer');
    Route::post('change-offer-status','User\OfferController@changeOfferStatus')->name('changeOfferStatus');
    Route::get('search-offers','MarketPlace\MarketPlaceController@searchOffers')->name('searchOffers');
    Route::get('search-options','MarketPlace\MarketPlaceController@searchOptions')->name('searchOptions');
    Route::post('open-trade-app','MarketPlace\MarketPlaceController@openTradeApp')->name('openTradeApp');
    Route::post('get-coin-trade-rate-app', 'MarketPlace\MarketPlaceController@getTradeCoinRateApp')->name('getTradeCoinRateApp');
    Route::post('save-order', 'MarketPlace\MarketPlaceController@saveOrder')->name('saveOrder');
    Route::get('trade-details-{id}', 'MarketPlace\MarketPlaceController@tradeDetailsApp')->name('tradeDetailsApp');
    Route::get('trade-profile-{user_id}', 'MarketPlace\MarketPlaceController@tradeProfile')->name('tradeProfile');
    Route::get('trade-list', 'MarketPlace\MarketPlaceController@tradeList')->name('tradeList');
    Route::post('send-order-message-from-app', 'MarketPlace\MarketPlaceController@sendOrderMessageApp')->name('sendOrderMessageApp');
    Route::post('google-login-enable-or-disable', 'User\ProfileController@googleLoginEnableDisable')->name('googleLoginEnableDisable');
    Route::post('cancel-trade-app', 'MarketPlace\MarketPlaceController@tradeCancelApp')->name('tradeCancelApp');
    Route::post('report-user-order-app', 'MarketPlace\MarketPlaceController@reportUserOrderApp')->name('reportUserOrderApp');
    Route::get('fund-escrow/{id}', 'MarketPlace\MarketPlaceController@fundEscrowApp')->name('fundEscrowApp');
    Route::get('released-escrow/{id}', 'MarketPlace\MarketPlaceController@releasedEscrowApp')->name('releasedEscrowApp');
    Route::post('upload-payment-sleep-app', 'MarketPlace\MarketPlaceController@uploadPaymentSleepApp')->name('uploadPaymentSleepApp');
    Route::post('get-country-payment-method-app', 'User\OfferController@getCountryPaymentMethodApp')->name('getCountryPaymentMethodApp');
    Route::post('log-out-app','AuthController@logOutApp')->name('logOutApp');
});

