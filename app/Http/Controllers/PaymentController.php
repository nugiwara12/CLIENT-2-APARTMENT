<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // Display all payments
    public function index()
    {
        // Get all payments
        $payments = Payment::all();

        // Count the total number of payments
        $paymentCount = $payments->count();

        // Get the dates of the payments
        $paymentDates = $payments->pluck('created_at')->map(function($date) {
            return $date->format('Y-m-d'); // Format the date as needed
        });

        // Return the view with the necessary data
        return view('payment.index', compact('payments', 'paymentCount', 'paymentDates'));
    }
    

    // Show the form for creating a new payment
    public function create()
    {
        return view('payment.create');
    }

    // Store function to create a new payment record
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:11',
            'qr_code' => 'required|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Save the QR code and create the payment record
        $qrCodePath = $this->handleImageUpload($request->file('qr_code'), 'qr_codes');

        Payment::create([
            'full_name' => $request->input('full_name'),
            'phone_number' => $request->input('phone_number'),
            'qr_code' => $qrCodePath,
        ]);

        return redirect()->back()->with('success', 'Payment info submitted successfully!');
    }

    // Show function to view a specific payment record
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payment.show', compact('payment'));
    }

    // Update function to modify an existing payment record
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:11',
            'qr_code' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Update QR code if a new file is uploaded
        if ($request->hasFile('qr_code')) {
            // Optionally delete the old QR code file if necessary
            if ($payment->qr_code) {
                Storage::disk('public')->delete($payment->qr_code);
            }
            $qrCodePath = $this->handleImageUpload($request->file('qr_code'), 'qr_codes');
            $payment->qr_code = $qrCodePath;
        }

        // Update other fields
        $payment->full_name = $request->input('full_name');
        $payment->phone_number = $request->input('phone_number');
        $payment->save();

        return redirect()->back()->with('success', 'Payment info updated successfully!');
    }

    // Delete function to remove a specific payment record
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        
        // Optionally delete the QR code file if it exists
        if ($payment->qr_code) {
            Storage::disk('public')->delete($payment->qr_code);
        }

        $payment->delete();

        return redirect()->back()->with('success', 'Payment info deleted successfully!');
    }

    // Handle image upload and return the path
    private function handleImageUpload($file, $folder)
    {
        return $file->store($folder, 'public');
    }
}
