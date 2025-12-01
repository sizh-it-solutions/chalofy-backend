<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\WalletRecharge\WalletRechargeController;
Route::get('/wallet_recharge', 'App\Http\Controllers\Front\PaymentFrontController@showPaymentPage')->name('wallet_recharge_form');
//Route::get('/wallet_recharge', [WalletRechargeController::class, 'showPaymentPage'])->name('wallet_recharge_form');
Route::post('/wallet_recharge', [WalletRechargeController::class, 'handlePayment'])
    ->name('wallet_recharge');
Route::get('/wallet_recharge_success', 'App\Http\Controllers\Front\WalletRecharge\WalletRechargeController@paymentSuccess')->name('wallet_recharge_success');
Route::get('/wallet_recharge_fail', 'App\Http\Controllers\Front\WalletRecharge\WalletRechargeController@paymentfail')->name('wallet_recharge_fail');

Route::post('/wallet/webhook/phonepe', [App\Http\Controllers\Front\WalletRecharge\WalletRechargeController::class, 'handlePhonepeWalletWebhook'])
    ->name('wallet.handlePhonepeWalletWebhook');

Route::get('/wallet/return', [App\Http\Controllers\Front\WalletRecharge\WalletRechargeController::class, 'handleReturn'])
    ->name('wallet.handleReturn');
    