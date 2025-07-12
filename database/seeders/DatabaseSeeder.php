<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo roles
        $roles = ['admin', 'writer', 'editor', 'approver', 'user'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Tạo categories
        $categories = [
            'Kiến tạo xã hội số',
            'Tin báo chí',
            'Thông cáo báo chí',
            'MWC',
            'Công bố thông tin',
            'Trách nhiệm xã hội',
            'Tin dịch vụ',
            'Tin dịch vụ doanh nghiệp',
        ];
        
        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category],
                ['slug' => Str::slug($category)]
            );
        }

        //Tạo status
        
        $statuses = [
            'draft',
            'pending',
            'pending review',
            'chờ approver duyệt chỉnh sửa',
            'chờ editor duyệt chỉnh sửa',
            'đã duyệt yêu cầu chỉnh sửa',
            'pending approve',
            'rejected',
            'published',
            'unpublished',
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate(['status' => $status]);
        }
    }
}
