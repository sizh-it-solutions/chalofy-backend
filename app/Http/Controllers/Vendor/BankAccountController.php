<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Validator;
use \Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\{Booking, Module, AppUser, GeneralSetting, AppUsersBankAccount};
use App\Models\Modern\{Item};
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, EmailTrait, SMSTrait, PushNotificationTrait, NotificationTrait, UserWalletTrait, VendorWalletTrait};

class BankAccountController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, EmailTrait, SMSTrait, PushNotificationTrait, NotificationTrait, UserWalletTrait, VendorWalletTrait;
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $vendorId = $user->id;
        }

        $bankAccount = AppUsersBankAccount::where('user_id', $vendorId)->first();

        return view('vendor.bankAccount.index', compact('bankAccount'));

    }

    public function storeOrUpdate(Request $request)
{
    $request->validate([
        'account_name'  => 'required|string|max:255',
        'bank_name'     => 'required|string|max:255',
        'branch_name'   => 'required|string|max:255',
        'account_number'=> 'required|string|max:255',
        'iban'          => 'required|string|max:255',
        'swift_code'    => 'required|string|max:255',
    ]);

    $bankAccount = AppUsersBankAccount::firstOrNew(['user_id' => auth()->user()->id]);

    $bankAccount->fill($request->only([
        'account_name', 'bank_name', 'branch_name', 
        'account_number', 'iban', 'swift_code'
    ]));

    $bankAccount->save();

    return redirect()->route('vendor.bankaccount')->with('success', 'Bank account information saved successfully.');
}




}