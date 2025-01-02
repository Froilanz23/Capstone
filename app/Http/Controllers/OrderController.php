<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller {



public function generateInvoices(Order $order)
    {
        // Customer Invoice
        Invoice::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'type' => 'customer',
            'amount' => $order->total,
            'status' => 'pending',
            'issue_date' => now(),
            'due_date' => now()->addDays(7),
            'reference_number' => uniqid('INV-'),
        ]);

        // Artist Invoice
        foreach ($order->orderItems as $item) {
            Invoice::create([
                'order_id' => $order->id,
                'user_id' => $item->product->artist->user_id,
                'type' => 'artist',
                'amount' => $item->price - $item->fee_on_top,
                'status' => 'pending',
                'issue_date' => now(),
                'due_date' => now()->addDays(7),
                'reference_number' => uniqid('INV-'),
            ]);
        }

        // Admin Invoice (if there's a platform fee)
        Invoice::create([
            'order_id' => $order->id,
            'user_id' => null, // No specific user, this is for admin
            'type' => 'admin',
            'amount' => $order->orderItems->sum('fee_on_top'),
            'status' => 'pending',
            'issue_date' => now(),
            'due_date' => now()->addDays(7),
            'reference_number' => uniqid('INV-'),
        ]);
    }

    public function downloadInvoice($orderId)
    {
        $order = Order::with(['orderItems.product.artist', 'transaction'])->findOrFail($orderId);

        $pdf = Pdf::loadView('invoices-order', compact('order'));

        return $pdf->download('invoice-' . $order->id . '.pdf');
    }

    public function downloadInvoiceForArtist($orderId)
{
    $order = Order::with(['orderItems.product.artist', 'transaction'])->findOrFail($orderId);
    $artist = Auth::user()->artist;

    // Filter order items to include only those belonging to this artist
    $artistOrderItems = $order->orderItems->filter(function ($item) use ($artist) {
        return $item->product->artist_id === $artist->id;
    });

    if ($artistOrderItems->isEmpty()) {
        abort(403, 'You do not have permission to access this invoice.');
    }

    $pdf = Pdf::loadView('artist.invoices-artist', compact('order', 'artistOrderItems'));
    return $pdf->download('artist-invoice-' . $order->id . '.pdf');
}

public function downloadInvoiceForAdmin($orderId)
{
    $order = Order::with(['orderItems.product.artist', 'user'])->findOrFail($orderId);

    // Get all artist order items related to this order
    $artistOrderItems = $order->orderItems;

    // Load the view with data
    $pdf = Pdf::loadView('admin.invoices-admin', compact('order', 'artistOrderItems'));

    return $pdf->download('admin-invoice-' . $order->id . '.pdf');
}


}