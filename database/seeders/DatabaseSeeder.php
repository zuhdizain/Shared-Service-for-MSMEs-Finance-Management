<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(5)->create();
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'position' => 'Admin',
            'phone'    => '021813199',
            'gender'   => 'Wanita',
            'password' => bcrypt('123456'),
            'authorization_level' => 2,
        ]);
        User::create([
            'name'     => 'Nadya Zahra',
            'email'    => 'nadyazahra@gmail.com',
            'position' => 'Staff Human Resource',
            'phone'    => '021813199',
            'gender'   => 'Wanita',
            'password' => bcrypt('123456'),
            'authorization_level' => 1,
        ]);
        User::create([
            'name'     => 'Rivaldi Abdul',
            'email'    => 'rivaldi@gmail.com',
            'position' => 'Staff Inventory',
            'phone'    => '021813198',
            'gender'   => 'Pria',
            'password' => bcrypt('123456'),
            'authorization_level' => 1,
        ]);
        User::create([
            'name'     => 'Mas Jelek',
            'email'    => 'supplier@gmail.com',
            'position' => 'Supplier',
            'phone'    => '021813197',
            'gender'   => 'Pria',
            'password' => bcrypt('123456'),
            'authorization_level' => 1,
        ]);
        User::create([
            'name'     => 'Yaseer1',
            'email'    => 'yaseer1@gmail.com',
            'position' => 'Staff Sales',
            'phone'    => '021813196',
            'gender'   => 'Pria',
            'password' => bcrypt('123456'),
            'authorization_level' => 1,
        ]);
        User::create([
            'name'     => 'Yaseer2',
            'email'    => 'yaseer2@gmail.com',
            'position' => 'Staff Sales',
            'phone'    => '021813195',
            'gender'   => 'Pria',
            'password' => bcrypt('123456'),
            'authorization_level' => 1,
        ]);
        User::create([
            'name'     => 'Zuhdi1',
            'email'    => 'zuhdi1@gmail.com',
            'position' => 'Staff Finance',
            'phone'    => '021813194',
            'gender'   => 'Pria',
            'password' => bcrypt('123456'),
            'authorization_level' => 1,
        ]);
        User::create([
            'name'     => 'Zuhdi2',
            'email'    => 'zuhdi2@gmail.com',
            'position' => 'Staff Finance',
            'phone'    => '021813193',
            'gender'   => 'Pria',
            'password' => bcrypt('123456'),
            'authorization_level' => 1,
        ]);

        // Seeder for Company
        Company::create([
            'user_id'  => '1',
            'company_name' => 'CobaCoba PTE',
            'company_email' => 'cobacoba@gmail.com',
            'company_phone' => '0123456789',
            'company_address' => 'Jl. Sesame Street, no. 127',
        ]);
        Company::create([
            'user_id'  => '2',
            'company_name' => 'Pink Cola Indonesia',
            'company_email' => 'pinkcola@gmail.com',
            'company_phone' => '0123456789',
            'company_address' => 'Jl. Sesame Street, no. 127',
        ]);
        Company::create([
            'user_id'  => '3',
            'company_name' => 'Bisa Di Coba',
            'company_email' => 'cobadulu@gmail.com',
            'company_phone' => '0123456789',
            'company_address' => 'Jl. Sesame Street, no. 127',
        ]);

        // Seeder for Division
        Division::create([
            'user_id' => '2',
            'division_name'    => 'Human Resource',
            'division_payroll' => '3500000',
        ]);
        Division::create([
            'user_id' => '2',
            'division_name'    => 'Finance',
            'division_payroll' => '2500000',
        ]);
        Division::create([
            'user_id' => '2',
            'division_name'    => 'Inventory',
            'division_payroll' => '3000000',
        ]);

        // Seeder for Employee
        Employee::create([
            'division_id' => '1',
            'user_id' => '2',
            'employee_name' => 'Nadya Zahra',
            'employee_email' => 'test@test.com',
            'employee_position' => 'Staff',
            'employee_phone' => '0123456789',
            'employee_gender' => 'Wanita',
            'employee_religion' => 'Iya',
            'employee_age' => '22',
            'employee_marriage' => 'Belum Menikah',
            'employee_child' => '0',
            'employee_status' => 'Karyawan Tetap',
            'employee_acceptanceDate' => '2022-08-05',
            'last_education' => 'S1 Telkom University',
            'employee_hospitalChart' => 'Tidak Ada',
            'employee_address' => 'Jl. Bumi, no. 127',
            'employee_image' => 'image.jpg',
        ]);
        Employee::create([
            'division_id' => '3',
            'user_id' => '2',
            'employee_name' => 'Rivaldi Abdul',
            'employee_email' => 'test@test.com',
            'employee_position' => 'Staff',
            'employee_phone' => '0123456789',
            'employee_gender' => 'Pria',
            'employee_religion' => 'Iya',
            'employee_age' => '22',
            'employee_marriage' => 'Belum Menikah',
            'employee_child' => '0',
            'employee_status' => 'Karyawan Tetap',
            'employee_acceptanceDate' => '2022-08-05',
            'last_education' => 'S1 Telkom University',
            'employee_hospitalChart' => 'Tidak Ada',
            'employee_address' => 'Jl. Bumi, no. 127',
            'employee_image' => 'image.jpg',
        ]);
        Employee::create([
            'division_id' => '2',
            'user_id' => '2',
            'employee_name' => 'Zuhdi Zain',
            'employee_email' => 'test@test.com',
            'employee_position' => 'Staff',
            'employee_phone' => '0123456789',
            'employee_gender' => 'Pria',
            'employee_religion' => 'Iya',
            'employee_age' => '22',
            'employee_marriage' => 'Belum Menikah',
            'employee_child' => '0',
            'employee_status' => 'Karyawan Tetap',
            'employee_acceptanceDate' => '2022-08-05',
            'last_education' => 'S1 Telkom University',
            'employee_hospitalChart' => 'Tidak Ada',
            'employee_address' => 'Jl. Bumi, no. 127',
            'employee_image' => 'image.jpg',
        ]);

        // Seeder for Costumer
        $customer = [
            [
                'customer_name' => 'Zuhdi',
                'customer_phone' => '08987654321',
                'customer_email' => 'zuhdi@gmail.com',
                'customer_address' => 'Bekasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_name' => 'Nadya',
                'customer_phone' => '08987654322',
                'customer_email' => 'nadya@gmail.com',
                'customer_address' => 'Depok',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_name' => 'Rivaldi',
                'customer_phone' => '08987654323',
                'customer_email' => 'rivaldi@gmail.com',
                'customer_address' => 'Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($customer as $key => $value) {
            Customer::create($value);
        }

        // Seeder for product type
        $type = [
            [
                'type' => 'Baju',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Celana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($type as $key => $value) {
            ProductType::create($value);
        }

        // Seeder for product
        $product = [
            [
                'product_code' => 'BJ01',
                'user_id' => 5,
                'type_id' => 1,
                'product_name' => 'Kemeja Oxford Slim Fit Lengan Panjang',
                'product_price' => 299000,
                'product_quantity' => 100,
                'date' => now(),
                'desc' => 'Kemeja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'BJ02',
                'user_id' => 5,
                'type_id' => 1,
                'product_name' => 'AIRism Katun T-Shirt Oversize Kerah Tinggi',
                'product_price' => 129000,
                'product_quantity' => 150,
                'date' => now(),
                'desc' => 'T-Shirt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'CL01',
                'user_id' => 6,
                'type_id' => 2,
                'product_name' => 'Jeans Potongan Klasik Helmut Lang',
                'product_price' => 499000,
                'product_quantity' => 200,
                'date' => now(),
                'desc' => 'Jeans',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($product as $key => $value) {
            Product::create($value);
        }
    }
}
