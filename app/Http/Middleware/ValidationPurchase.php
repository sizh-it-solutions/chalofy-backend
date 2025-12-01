<?php

namespace App\Http\Middleware;
use Closure;
use App\Models\purchaseValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ValidationPurchase
{
    public function handle(Request $request, Closure $next)
    {

       if (!$request->query('isValidated', false)) {
        return redirect()->route('installer.purchaseValidation-error');
    }
        return $next($request);
    }
}
