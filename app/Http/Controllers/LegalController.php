<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegalController extends Controller
{
    /**
     * Show the Terms & Conditions page.
     */
    public function terms(): View
    {
        return view('legal.terms');
    }

    /**
     * Show the Privacy Policy page.
     */
    public function privacy(): View
    {
        return view('legal.privacy');
    }

    /**
     * Show the Refund Policy page.
     */
    public function refunds(): View
    {
        return view('legal.refunds');
    }
}
