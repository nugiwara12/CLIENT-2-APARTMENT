<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Controllers\Auth\UserManagementController;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Update the past due status of users
        $userManagement = new UserManagementController();
        $userManagement->updatePastDueStatus();

        // Retrieve the payment count
        $paymentCount = Payment::count();

        // Retrieve and format payment dates
        $paymentDates = Payment::pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d');
        });

        // Get today's date
        $today = Carbon::today();

        // Check if the user has the admin role
        $isAdmin = Auth::user()->role === 'admin';

        // Initialize dueTodayCount
        $dueTodayCount = 0;

        // Prepare variables for due dates and past due dates
        $dueDates = collect();
        $pastDueDates = collect();

        if ($isAdmin) {
            // Admin can see all upcoming due dates
            $dueTodayCount = User::whereDate('due_date', '>=', $today)->count();
            $dueDates = User::whereDate('due_date', '>=', $today)
                    ->orderBy('due_date')
                    ->get(['name', 'due_date']); // Get both name and due_date

            // Fetch all past due dates
            $pastDueDates = User::where('is_past_due', true)
                                ->orderByDesc('due_date')
                                ->get(['name', 'due_date']); 
        } else {
           // Regular users can only see their own due dates
            $dueTodayCount = User::where('id', Auth::id())
                                ->whereDate('due_date', '>=', $today)
                                ->count();

            // Retrieve upcoming due dates for the authenticated user
            $dueDates = User::where('id', Auth::id())
                            ->whereDate('due_date', '>=', $today)
                            ->orderBy('due_date')
                            ->get(['name', 'due_date']); // Get both name and due_date

            // Retrieve past due dates for the authenticated user
            $pastDueDates = User::where('id', Auth::id())
                                ->where('is_past_due', true)
                                ->orderByDesc('due_date')
                                ->get(['name', 'due_date']); 
        }

        // Count of past due dates
        $pastDueCount = $pastDueDates->count();

        // Pass all the collected data to the dashboard view
        return view('dashboard', compact('paymentCount', 'paymentDates', 'dueTodayCount', 'dueDates', 'pastDueDates', 'pastDueCount'));
    }
}
