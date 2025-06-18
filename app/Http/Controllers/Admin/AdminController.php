<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FoodItem;
use App\Models\Category;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_items' => FoodItem::sum('quantity'),
            'total_categories' => Category::count(),
            'total_donations' => Donation::count(),
            'expired_items' => FoodItem::expired()->count(),
            'low_stock_items' => FoodItem::lowStock()->count(),
            'total_value' => FoodItem::sum('cost') ?? 0,
            'monthly_donations' => Donation::whereMonth('donation_date', now()->month)->count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        $recent_donations = Donation::with('donationItems.foodItem')
            ->latest()
            ->take(5)
            ->get();

        // Monthly donation chart data
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'donations' => Donation::whereYear('donation_date', $date->year)
                    ->whereMonth('donation_date', $date->month)
                    ->count(),
                'value' => Donation::whereYear('donation_date', $date->year)
                    ->whereMonth('donation_date', $date->month)
                    ->sum('total_value')
            ];
        }

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_donations', 'monthlyData'));
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,staff,volunteer',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully!');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,staff,volunteer',
            'is_active' => 'boolean'
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully!');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully!');
    }

    public function reports()
    {
        $totalItems = FoodItem::sum('quantity');
        $totalValue = FoodItem::sum('cost') ?? 0;
        $expiredItems = FoodItem::expired()->count();
        $lowStockItems = FoodItem::lowStock()->count();

        // Category breakdown
        $categoryStats = Category::withCount('foodItems')
            ->with(['foodItems' => function($query) {
                $query->selectRaw('category_id, sum(quantity) as total_quantity, sum(cost) as total_value')
                    ->groupBy('category_id');
            }])
            ->get()
            ->map(function($category) {
                return [
                    'name' => $category->name,
                    'color' => $category->color,
                    'items_count' => $category->food_items_count,
                    'total_quantity' => $category->foodItems->sum('quantity') ?? 0,
                    'total_value' => $category->foodItems->sum('cost') ?? 0,
                ];
            });

        // Monthly trends
        $monthlyTrends = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyTrends[] = [
                'month' => $date->format('M Y'),
                'donations' => Donation::whereYear('donation_date', $date->year)
                    ->whereMonth('donation_date', $date->month)
                    ->count(),
                'items_added' => FoodItem::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('quantity'),
                'total_value' => Donation::whereYear('donation_date', $date->year)
                    ->whereMonth('donation_date', $date->month)
                    ->sum('total_value')
            ];
        }

        return view('admin.reports', compact('totalItems', 'totalValue', 'expiredItems', 'lowStockItems', 'categoryStats', 'monthlyTrends'));
    }
}
