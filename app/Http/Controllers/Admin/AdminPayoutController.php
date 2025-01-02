<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest;
use Illuminate\Http\Request;

class AdminPayoutController extends Controller
{
    /**
     * Display a list of all pending payout requests.
     */
    public function index()
    {
        $payoutRequests = PayoutRequest::with('artist')->where('status', 'pending')->orderBy('created_at', 'DESC')->get();
        return view('admin.payout-requests', compact('payoutRequests'));
    }

    /**
     * Display the payout request history.
     */
    public function history()
    {
        $payoutHistory = PayoutRequest::with('artist')->where('status', '!=', 'pending')->orderBy('created_at', 'DESC')->get();
        return view('admin.payout-history', compact('payoutHistory'));
    }

    /**
     * Approve a specific payout request.
     */
    public function approve($id)
    {
        $payout = PayoutRequest::findOrFail($id);
        $payout->status = 'approved';
        $payout->save();

        return back()->with('success', 'Payout request approved successfully.');
    }

    /**
     * Decline a specific payout request.
     */
    public function decline($id)
    {
        $payout = PayoutRequest::findOrFail($id);
        $payout->status = 'declined';
        $payout->save();

        return back()->with('error', 'Payout request declined.');
    }
}
