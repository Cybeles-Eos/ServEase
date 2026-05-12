<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    if (! auth()->user()->isAdmin()) {
        return redirect('/')->with('flash_message', [
            'title' => 'Account Not Found!',
            'message' => 'Please Login Your Account To Continue.',
            'type' => 'error'
        ]);
    }

    $totalUsers = User::query()
        ->where('is_active', 1)
        ->whereIn('role', ['provider', 'customer'])
        ->count();

    $totalProviders = User::query()
        ->where('is_active', 1)
        ->where('role', 'provider')
        ->count();

    $totalCustomers = User::query()
        ->where('is_active', 1)
        ->where('role', 'customer')
        ->count();

    $totalServices = Service::query()
        ->where('is_active', 1)
        ->count();

    $recentServices = Service::with(['provider', 'serviceCategory'])
        ->latest()
        ->paginate(4, ['*'], 'services_page');

    $recentUsers = User::query()
        ->whereIn('role', ['provider', 'customer'])
        ->latest()
        ->paginate(4, ['*'], 'users_page');

    return view('admin.page.admin.index', compact(
        'totalUsers',
        'totalProviders',
        'totalCustomers',
        'totalServices',
        'recentServices',
        'recentUsers'
    ));
}

    public function users()
    {
        $users = User::query()
            ->whereIn('role', ['provider', 'customer'])
            ->with(['provider', 'customer'])
            ->orderBy('name')
            ->get();

        return view('admin.page.admin.user.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.page.admin.user.create');
    }

    public function storeUser(Request $request)
    {
        $role = $request->input('role');

        $rules = [
            'role' => ['required', Rule::in(['customer', 'provider'])],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if ($role === 'customer') {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['phone_number'] = ['nullable', 'string', 'max:255'];
            $rules['personal_email'] = ['nullable', 'email', 'max:255'];
            $rules['street_address'] = ['nullable', 'string', 'max:255'];
            $rules['city'] = ['nullable', 'string', 'max:255'];
            $rules['barangay'] = ['nullable', 'string', 'max:255'];
            $rules['zipcode'] = ['nullable', 'string', 'max:255'];
        } else {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['phone_number'] = ['required', 'string', 'max:255'];
            $rules['personal_email'] = ['nullable', 'email', 'max:255'];
            $rules['home_address'] = ['required', 'string', 'max:255'];
            $rules['province'] = ['required', 'string', 'max:255'];
            $rules['barangay'] = ['nullable', 'string', 'max:255'];
            $rules['zipcode'] = ['required', 'string', 'max:255'];
            $rules['profession'] = ['required', 'string', 'max:255'];
            $rules['year_exp'] = ['required', 'integer', 'min:0'];
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $role) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $role,
                'is_active' => true,
            ]);

            if ($role === 'customer') {
                $user->customer()->create([
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'phone_number' => $validated['phone_number'] ?? null,
                    'personal_email' => $validated['personal_email'] ?? null,
                    'street_address' => $validated['street_address'] ?? null,
                    'city' => $validated['city'] ?? null,
                    'barangay' => $validated['barangay'] ?? null,
                    'zipcode' => $validated['zipcode'] ?? null,
                ]);
            } else {
                $user->provider()->create([
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'phone_number' => $validated['phone_number'],
                    'personal_email' => $validated['personal_email'] ?? null,
                    'home_address' => $validated['home_address'],
                    'province' => $validated['province'],
                    'barangay' => $validated['barangay'] ?? null,
                    'zipcode' => $validated['zipcode'],
                    'profession' => $validated['profession'],
                    'year_exp' => $validated['year_exp'],
                ]);
            }
        });

        return redirect()->route('admin.users')->with('flash_message', [
            'title' => '',
            'message' => 'User created successfully.',
            'type' => 'success',
        ]);
    }

    public function showUser(User $user)
    {
        $this->assertManagedUser($user);
        $user->load(['provider', 'customer']);

        return view('admin.page.admin.user.show', compact('user'));
    }

    public function editUser(User $user)
    {
        $this->assertManagedUser($user);
        $user->load(['provider', 'customer']);

        return view('admin.page.admin.user.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $this->assertManagedUser($user);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'change_password' => ['required', 'in:0,1'],
            'is_active' => ['required', 'in:0,1'],
        ];

        if ($request->boolean('change_password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        if ($user->role === 'customer') {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['phone_number'] = ['nullable', 'string', 'max:255'];
            $rules['personal_email'] = ['nullable', 'email', 'max:255'];
            $rules['street_address'] = ['nullable', 'string', 'max:255'];
            $rules['city'] = ['nullable', 'string', 'max:255'];
            $rules['barangay'] = ['nullable', 'string', 'max:255'];
            $rules['zipcode'] = ['nullable', 'string', 'max:255'];
        } else {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['phone_number'] = ['required', 'string', 'max:255'];
            $rules['personal_email'] = ['nullable', 'email', 'max:255'];
            $rules['home_address'] = ['required', 'string', 'max:255'];
            $rules['province'] = ['required', 'string', 'max:255'];
            $rules['barangay'] = ['nullable', 'string', 'max:255'];
            $rules['zipcode'] = ['required', 'string', 'max:255'];
            $rules['profession'] = ['required', 'string', 'max:255'];
            $rules['year_exp'] = ['required', 'integer', 'min:0'];
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $user) {
            $payload = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'is_active' => (bool) $validated['is_active'],
            ];

            if (($validated['change_password'] ?? '0') === '1') {
                $payload['password'] = Hash::make($validated['password']);
            }

            $user->update($payload);

            if ($user->role === 'customer') {
                $user->customer()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'first_name' => $validated['first_name'],
                        'last_name' => $validated['last_name'],
                        'phone_number' => $validated['phone_number'] ?? null,
                        'personal_email' => $validated['personal_email'] ?? null,
                        'street_address' => $validated['street_address'] ?? null,
                        'city' => $validated['city'] ?? null,
                        'barangay' => $validated['barangay'] ?? null,
                        'zipcode' => $validated['zipcode'] ?? null,
                    ]
                );
            } else {
                $user->provider()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'first_name' => $validated['first_name'],
                        'last_name' => $validated['last_name'],
                        'phone_number' => $validated['phone_number'],
                        'personal_email' => $validated['personal_email'] ?? null,
                        'home_address' => $validated['home_address'],
                        'province' => $validated['province'],
                        'barangay' => $validated['barangay'] ?? null,
                        'zipcode' => $validated['zipcode'],
                        'profession' => $validated['profession'],
                        'year_exp' => $validated['year_exp'],
                    ]
                );
            }
        });

        return redirect()->route('admin.users')->with('flash_message', [
            'title' => '',
            'message' => 'User updated successfully.',
            'type' => 'success',
        ]);
    }

    public function destroyUser(Request $request, User $user)
    {
        $this->assertManagedUser($user);

        if ($user->id === auth()->id()) {
            abort(403);
        }

        $user->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'User deleted successfully.']);
        }

        return redirect()->route('admin.users')->with('flash_message', [
            'title' => '',
            'message' => 'User deleted successfully.',
            'type' => 'success',
        ]);
    }

    private function assertManagedUser(User $user): void
    {
        if (! in_array($user->role, ['provider', 'customer'], true)) {
            abort(404);
        }
    }



    /*
     *
     *  General Setting Controllers
     * 
    */
    public function setting(Request $request)
    {
        $categorySearch = $request->input('category_search');

        $serviceCategories = ServiceCategory::query()
            ->when($categorySearch, function ($query) use ($categorySearch) {
                $query->where('name', 'like', '%' . $categorySearch . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.page.admin.general_setting.index', compact(
            'serviceCategories',
            'categorySearch'
        ));
    }
    public function storeServiceCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:service_categories,name'],
        ]);

        ServiceCategory::create([
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Service category created successfully.',
            'type' => 'success',
        ]);
    }
    public function updateServiceCategory(Request $request, ServiceCategory $serviceCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_categories', 'name')->ignore($serviceCategory->id),
            ],
            'is_active' => ['nullable', 'in:1'],
        ]);

        $serviceCategory->update([
            'name' => $validated['name'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Service category updated successfully.',
            'type' => 'success',
        ]);
    }
    public function destroyServiceCategory(Request $request, ServiceCategory $serviceCategory)
    {
        $serviceCategory->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Service category deleted successfully.',
            ]);
        }

        return redirect()->route('admin.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Service category deleted successfully.',
            'type' => 'success',
        ]);
    }
}
