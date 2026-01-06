<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create regular test user
        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        // Create sample products
        $products = [
            [
                'name' => 'Wireless Headphones',
                'description' => 'Premium noise-canceling wireless headphones with 30-hour battery life',
                'price' => 199.99,
                'stock_quantity' => 15,
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracking smartwatch with heart rate monitor',
                'price' => 299.99,
                'stock_quantity' => 8,
            ],
            [
                'name' => 'Laptop Stand',
                'description' => 'Ergonomic aluminum laptop stand with adjustable height',
                'price' => 49.99,
                'stock_quantity' => 3,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical gaming keyboard with blue switches',
                'price' => 129.99,
                'stock_quantity' => 25,
            ],
            [
                'name' => 'USB-C Hub',
                'description' => '7-in-1 USB-C hub with HDMI, USB 3.0, and SD card reader',
                'price' => 39.99,
                'stock_quantity' => 50,
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with precision tracking',
                'price' => 29.99,
                'stock_quantity' => 4,
            ],
            [
                'name' => 'Phone Case',
                'description' => 'Protective silicone phone case with shock absorption',
                'price' => 19.99,
                'stock_quantity' => 100,
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Portable waterproof Bluetooth speaker with 12-hour battery',
                'price' => 79.99,
                'stock_quantity' => 12,
            ],
            [
                'name' => 'Screen Protector',
                'description' => 'Tempered glass screen protector with oleophobic coating',
                'price' => 14.99,
                'stock_quantity' => 5,
            ],
            [
                'name' => 'Power Bank',
                'description' => '20000mAh portable power bank with fast charging',
                'price' => 44.99,
                'stock_quantity' => 0,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
