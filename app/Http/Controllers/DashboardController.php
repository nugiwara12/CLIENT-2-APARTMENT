<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Controllers\Auth\UserManagementController;

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

        // Retrieve the count of users with due dates set for today or in the future
        $today = Carbon::today();
        $dueTodayCount = User::whereDate('due_date', '>=', $today)->count();

        // Retrieve all upcoming due dates, including today
        $dueDates = User::whereDate('due_date', '>=', $today)
                        ->orderBy('due_date')
                        ->pluck('due_date')
                        ->map(function ($date) {
                            return Carbon::parse($date)->format('Y-m-d');
                        });

        // Fetch only the past due dates
        $pastDueDates = User::where('is_past_due', true)
            ->orderByDesc('due_date')
            ->pluck('due_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            });

        // Count of past due dates
        $pastDueCount = $pastDueDates->count();

        // Pass all the collected data to the dashboard view
        return view('dashboard', compact('paymentCount', 'paymentDates', 'dueTodayCount', 'dueDates', 'pastDueDates', 'pastDueCount'));
    }
}
