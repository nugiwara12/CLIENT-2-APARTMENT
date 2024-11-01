<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use App\Rules\MatchOldPassword;
use Auth;
use DB;
use Carbon\Carbon;
use Session;
use Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 entries per page if not specified
        $search = $request->input('search'); // Get the search input
    
        // Query to filter users based on search input
        $query = User::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('role', 'LIKE', "%{$search}%");
            });
        }
    
        $users = $query->paginate($perPage); // Use pagination instead of fetching all users
    
        // Check due dates and update is_past_due status accurately
        foreach ($users as $user) {
            if ($user->due_date) {
                if (Carbon::parse($user->due_date)->isToday()) {
                    $user->is_past_due = false; // Due date is today, not past due
                } elseif (Carbon::parse($user->due_date)->isPast()) {
                    $user->is_past_due = true;  // Due date has passed, mark as past due
                } else {
                    $user->is_past_due = false; // Due date is in the future
                }
                $user->save();
            }
        }
    
        // Count the number of users with past due dates
        $pastDueCount = User::where('is_past_due', true)->count();
    
        return view('usermanagement.index', compact('users', 'pastDueCount', 'search')); // Include search in compact
    }
    
    public function create()
    {
        return view('usermanagement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required','regex:/^[A-z a-z]+$/','string','max:255'],
            'role'       => 'required|string|max:255',
            'email' => ['required','regex:/^[A-z a-z 0-9 @_.]+$/','string','max:255','email','unique:users'],
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            
        ]);
        User::create($request->all());
 
        return redirect()->route('usermanagement')->with('success', 'UserManagement Users added successfully');
    }

    public function setDueDate(Request $request, $id)
    {
        $request->validate([
            'due_date' => 'nullable|date',
        ]);

        $user = User::findOrFail($id);
        $user->due_date = $request->due_date;
        $user->save();

        return redirect()->route('usermanagement')->with('success', 'Due date set successfully');
    }
    public function pastDue()
    {
        // Get users with due dates that have passed
        $pastDueUsers = User::whereNotNull('due_date')
                            ->where('due_date', '<', Carbon::now())
                            ->get();

        return view('usermanagement.index', compact('pastDueUsers'));
    }
    public function updatePastDueStatus()
{
    $users = User::all();

    // Check due dates and update is_past_due status accurately
    foreach ($users as $user) {
        if ($user->due_date) {
            $dueDate = Carbon::parse($user->due_date);

            if ($dueDate->isToday()) {
                $user->is_past_due = false; // Due date is today, not past due
            } elseif ($dueDate->isPast()) {
                $user->is_past_due = true;  // Due date has passed, mark as past due
            } else {
                $user->is_past_due = false; // Due date is in the future
            }
            $user->save();
        }
    }
}



    public function show(string $id)
    {
        $users = User::findOrFail($id);
  
        return view('usermanagement.show', compact('users'));
    }
    public function edit(string $id)
    {
        // Fetch a single user instance
        $user = User::findOrFail($id);
    
        // Pass the single user instance to the view
        return view('components.modal.usermanagement.edit', compact('user'));
    }
    
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name'  => ['required','regex:/^[A-z a-z]+$/','string','max:255'],
            'role'  => ['required','string','max:255'],
            'email' => ['required','regex:/^[A-z a-z 0-9 @_.]+$/','string','max:255','email'],
        ]);
    
        // Fetch the user instance to update
        $user = User::findOrFail($id);
    
        // Update the user with the validated data
        $user->update($validatedData);
    
        // Return a JSON response
        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }

    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
  
        $users->delete();
  
        return redirect()->route('usermanagement')->with('success', 'UserManagement deleted successfully');
    }
    public function activity()
    {
        $activityLog = DB::table('activity_logs')->get();
        return view ('activity_log', compact('activityLog'));
    }
    public function changePasswordView()
    {
        return view('usermanagement.change_password');
    }
    
    public function changePasswordDB(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        return redirect()->route('dashboard');
    }
}
