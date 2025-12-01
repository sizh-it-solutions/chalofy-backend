<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ExternalPagesController extends Controller
{
    public function aboutUs()
    {
        return view('external.about-us'); // assuming you have an about-us.blade.php in your views/external directory
    }

    public function privacyPolicy()
    {
        return view('front.external.privacyPolicy'); // assuming you have a contact-us.blade.php in your views/external directory
    }

    // Add more methods for other external pages as needed
}