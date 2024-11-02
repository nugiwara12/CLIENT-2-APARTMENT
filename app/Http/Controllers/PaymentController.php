<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth\UserManagementController;

class PaymentController extends Controller
{
    // Display all payments
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 entries per page if not specified
        $search = $request->input('search'); // Retrieve the search query

        // Query payments and apply search filter
        $payments = Payment::when($search, function ($query, $search) {
                return $query->where('full_name', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%")
                            ->orWhere('payment_method', 'like', "%{$search}%")
                            ->orWhere('amount', $search);
            })
            ->paginate($perPage);

        // Existing code for past due status and other counts remains as it is
        $userManagement = new UserManagementController();
        $userManagement->updatePastDueStatus();

        $paymentCount = Payment::count();
        $paymentDates = Payment::pluck('created_at')->map(fn($date) => $date->format('Y-m-d'));

        $today = Carbon::today();
        $dueTodayCount = User::whereDate('due_date', $today)->count();
        $dueDates = User::whereDate('due_date', '>=', $today)
                        ->orderBy('due_date')
                        ->pluck('due_date')
                        ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'));

        $pastDueDates = User::where('is_past_due', true)
                            ->orderByDesc('due_date')
                            ->pluck('due_date')
                            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'));

        $pastDueCount = $pastDueDates->count();

        // Return view with existing data plus new pagination data and search query
        return view('payment.index', compact('payments', 'paymentCount', 'paymentDates', 'dueTodayCount', 'dueDates', 'pastDueDates', 'pastDueCount', 'perPage', 'search'));
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
            'amount' => 'required|numeric',
            'qr_code' => 'required|file|mimes:png,jpg,jpeg|max:2048',
            'payment_method' => 'required|string|max:255', // Validate payment method
            'due_date' => 'required|array', // Validate due_date as an array
            'due_date.*' => 'string|date_format:Y-m-d', // Optional: Validate each due date format if needed
        ]);

        // Save the QR code and create the payment record
        $qrCodePath = $this->handleImageUpload($request->file('qr_code'), 'qr_codes');

        Payment::create([
            'full_name' => $request->input('full_name'),
            'phone_number' => $request->input('phone_number'),
            'amount' => $request->input('amount'),
            'qr_code' => $qrCodePath,
            'payment_method' => $request->input('payment_method'),
            'due_date' => json_encode($request->input('due_date')), // Store due dates as JSON
        ]);

        // Update the user payment status
        $userId = auth()->user()->id; // Assuming you are getting the user id from auth
        $userManagementController = new UserManagementController();
        $userManagementController->processDueDatePayment($userId);
        $userManagementController->processPastDueDatePayment($userId);

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
            'amount' => 'required|numeric',
            'qr_code' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'payment_method' => 'required|string|max:255', // Validate payment method
            'due_date' => 'required|array', // Validate due_date as an array
            'due_date.*' => 'string|date_format:Y-m-d', // Optional: Validate each due date format if needed
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
        $payment->amount = $request->input('amount');
        $payment->payment_method = $request->input('payment_method'); // Update payment method
        $payment->due_date = json_encode($request->input('due_date'));
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