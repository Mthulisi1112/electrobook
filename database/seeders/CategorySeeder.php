<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Interior Categories
        $interior = Category::create([
            'name' => 'Interior',
            'type' => 'interior',
            'order' => 1,
            'description' => 'Interior home services and improvements'
        ]);

        Category::insert([
            [
                'name' => 'Home Repairs & Maintenance',
                'slug' => 'home-repairs',
                'type' => 'interior',
                'parent_id' => $interior->id,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cleaning & Organization',
                'slug' => 'cleaning',
                'type' => 'interior',
                'parent_id' => $interior->id,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Renovations & Upgrades',
                'slug' => 'renovations',
                'type' => 'interior',
                'parent_id' => $interior->id,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // Exterior Categories
        $exterior = Category::create([
            'name' => 'Exterior',
            'type' => 'exterior',
            'order' => 2,
            'description' => 'Exterior home care and outdoor services'
        ]);

        Category::insert([
            [
                'name' => 'Exterior Home Care',
                'slug' => 'exterior-care',
                'type' => 'exterior',
                'parent_id' => $exterior->id,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Landscaping & Outdoor Services',
                'slug' => 'landscaping',
                'type' => 'exterior',
                'parent_id' => $exterior->id,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Moving',
                'slug' => 'moving',
                'type' => 'exterior',
                'parent_id' => $exterior->id,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Installation & Assembly',
                'slug' => 'installation',
                'type' => 'exterior',
                'parent_id' => $exterior->id,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // General Contracting Categories
        $contracting = Category::create([
            'name' => 'General Contracting',
            'type' => 'contracting',
            'order' => 3,
            'description' => 'Professional contracting and remodeling services'
        ]);

        Category::insert([
            [
                'name' => 'Carpenters',
                'slug' => 'carpenters',
                'type' => 'contracting',
                'parent_id' => $contracting->id,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bathroom Remodeling',
                'slug' => 'bathroom-remodeling',
                'type' => 'contracting',
                'parent_id' => $contracting->id,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kitchen Remodeling',
                'slug' => 'kitchen-remodeling',
                'type' => 'contracting',
                'parent_id' => $contracting->id,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Flooring Installation',
                'slug' => 'flooring',
                'type' => 'contracting',
                'parent_id' => $contracting->id,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Interior Design',
                'slug' => 'interior-design',
                'type' => 'contracting',
                'parent_id' => $contracting->id,
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Carpet Installation',
                'slug' => 'carpet',
                'type' => 'contracting',
                'parent_id' => $contracting->id,
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Interior Painting',
                'slug' => 'painting',
                'type' => 'contracting',
                'parent_id' => $contracting->id,
                'order' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Basement Remodeling',
                'slug' => 'basement',
                'type' => 'contracting',
                'parent_id' => $contracting->id,
                'order' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}