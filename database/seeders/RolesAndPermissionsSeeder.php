<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LoyaltyPoints;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Vendor;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'access admin dashboard',
            'manage settings',
            'manage employees',
            'manage vendors',
            'manage products',
            'manage inventory',
            'manage orders',
            'view reports',
            'manage cms',
            'access vendor dashboard',
            'access customer panel',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $vendorRole = Role::firstOrCreate(['name' => 'vendor']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Assign Permissions to Roles
        $adminRole->syncPermissions($permissions); // Admin gets all

        $vendorRole->syncPermissions([
            'access vendor dashboard',
            'manage products',
            'manage orders',
            'view reports',
        ]);

        $employeeRole->syncPermissions([
            'access admin dashboard',
            'manage products',
            'manage inventory',
            'manage orders',
            'manage cms',
        ]);

        $customerRole->syncPermissions([
            'access customer panel',
        ]);

        // --- Create Default Admin User ---
        $admin = User::firstOrCreate(
            ['email' => 'admin@textile.com'],
            [
                'name' => 'Admin Owner',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);
        UserProfile::firstOrCreate([
            'user_id' => $admin->id,
            'phone' => '9876543210',
            'user_group' => 'Admin',
            'status' => 'Active',
            'bio' => 'General Store Manager and System Administrator.',
        ]);

        // --- Create Default Vendor User ---
        $vendorUser = User::firstOrCreate(
            ['email' => 'vendor@textile.com'],
            [
                'name' => 'Varanasi Silks Vendor',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $vendorUser->assignRole($vendorRole);
        UserProfile::firstOrCreate([
            'user_id' => $vendorUser->id,
            'phone' => '9876543211',
            'user_group' => 'Regular',
            'status' => 'Active',
            'bio' => 'Premium Varanasi silk sarees wholesaler.',
        ]);
        Vendor::firstOrCreate([
            'user_id' => $vendorUser->id,
            'company_name' => 'Varanasi Weavers Co.',
            'slug' => 'varanasi-weavers-co',
            'commission_percentage' => 12.50,
            'status' => 'Approved',
            'bank_details' => [
                'bank_name' => 'State Bank of India',
                'account_number' => '123456789012',
                'ifsc_code' => 'SBIN0001234',
            ],
        ]);

        // --- Create Default Employee User ---
        $employeeUser = User::firstOrCreate(
            ['email' => 'employee@textile.com'],
            [
                'name' => 'Jane Staff',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $employeeUser->assignRole($employeeRole);
        UserProfile::firstOrCreate([
            'user_id' => $employeeUser->id,
            'phone' => '9876543212',
            'user_group' => 'Staff',
            'status' => 'Active',
            'bio' => 'Warehouse Supervisor and Order Fulfiller.',
        ]);
        $dept = Department::firstOrCreate([
            'name' => 'Inventory',
            'description' => 'Handles stock adjustments, supplier management and warehouse logistics.',
        ]);
        Employee::firstOrCreate([
            'user_id' => $employeeUser->id,
            'department_id' => $dept->id,
            'salary' => 35000.00,
            'hire_date' => now()->subYear(),
            'status' => 'Active',
        ]);

        // --- Create Default Customer User ---
        $customer = User::firstOrCreate(
            ['email' => 'customer@textile.com'],
            [
                'name' => 'Aravind Kumar',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $customer->assignRole($customerRole);
        UserProfile::firstOrCreate([
            'user_id' => $customer->id,
            'phone' => '9876543213',
            'user_group' => 'VIP',
            'is_vip' => true,
            'status' => 'Active',
            'bio' => 'Loyal customer who loves ethnic collections.',
        ]);
        Address::firstOrCreate([
            'user_id' => $customer->id,
            'label' => 'Home',
            'address_line1' => 'Flat 405, Premium Apartments',
            'address_line2' => 'Road No 3, Banjara Hills',
            'city' => 'Hyderabad',
            'state' => 'Telangana',
            'postal_code' => '500034',
            'country' => 'India',
            'is_default_shipping' => true,
            'is_default_billing' => true,
        ]);
        Wallet::firstOrCreate([
            'user_id' => $customer->id,
            'balance' => 5000.00, // Preloaded balance
        ]);
        LoyaltyPoints::firstOrCreate([
            'user_id' => $customer->id,
            'points_balance' => 350,
        ]);
    }
}
