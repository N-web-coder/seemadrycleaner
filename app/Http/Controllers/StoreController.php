<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Locality;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('locality')->latest()->paginate(10);
        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        $localities = Locality::where('is_active', true)->get();
        return view('admin.stores.create', compact('localities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'locality_id' => 'required|exists:localities,id',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
            // Manager details
            'manager_name' => 'required|string|max:255',
            'manager_email' => 'required|email|unique:users,email',
            'manager_phone' => 'required|string|max:20',
            'manager_password' => 'required|string|min:6',
            'razorpay_key' => 'nullable|string|max:255',
            'razorpay_secret' => 'nullable|string|max:255',
        ]);

        \DB::beginTransaction();
        try {
            $store = Store::create([
                'name' => $request->name,
                'locality_id' => $request->locality_id,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'razorpay_key' => $request->razorpay_key,
                'razorpay_secret' => $request->razorpay_secret,
                'is_active' => $request->has('is_active'),
            ]);

            \App\Models\User::create([
                'name' => $request->manager_name,
                'email' => $request->manager_email,
                'phone' => $request->manager_phone,
                'password' => \Hash::make($request->manager_password),
                'role' => 'manager',
                'store_id' => $store->id
            ]);

            \DB::commit();
            return redirect()->route('admin.stores.index')->with('success', 'Store and Manager created successfully.');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Store $store)
    {
        $localities = Locality::where('is_active', true)->get();
        // Get the first manager associated with this store
        $manager = \App\Models\User::where('store_id', $store->id)->where('role', 'manager')->first();
        return view('admin.stores.edit', compact('store', 'localities', 'manager'));
    }

    public function update(Request $request, Store $store)
    {
        $manager = \App\Models\User::where('store_id', $store->id)->where('role', 'manager')->first();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'locality_id' => 'required|exists:localities,id',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            // Manager edit validation
            'manager_name' => 'required|string|max:255',
            'manager_email' => 'required|email|unique:users,email,' . ($manager->id ?? 0),
            'manager_phone' => 'required|string|max:20',
            'manager_password' => 'nullable|string|min:6',
            'razorpay_key' => 'nullable|string|max:255',
            'razorpay_secret' => 'nullable|string|max:255',
        ]);

        \DB::beginTransaction();
        try {
            $store->update([
                'name' => $request->name,
                'locality_id' => $request->locality_id,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'razorpay_key' => $request->razorpay_key,
                'razorpay_secret' => $request->razorpay_secret,
                'is_active' => $request->has('is_active'),
            ]);

            if ($manager) {
                $userData = [
                    'name' => $request->manager_name,
                    'email' => $request->manager_email,
                    'phone' => $request->manager_phone,
                ];
                if ($request->manager_password) {
                    $userData['password'] = \Hash::make($request->manager_password);
                }
                $manager->update($userData);
            }

            \DB::commit();
            return redirect()->route('admin.stores.index')->with('success', 'Store and Manager updated successfully.');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index')->with('success', 'Store deleted successfully.');
    }
}
