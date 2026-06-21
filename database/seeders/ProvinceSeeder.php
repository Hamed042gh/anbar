<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $provinces = [
            ['id' => 1, 'name' => 'آذربایجان شرقی', 'slug' => 'azarbayjan-sharghi', 'slug_fa' => 'آذربايجان-شرقی', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 2, 'name' => 'آذربایجان غربی', 'slug' => 'azarbayjan-gharbi', 'slug_fa' => 'آذربايجان-غربی', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 3, 'name' => 'اردبیل', 'slug' => 'ardebil', 'slug_fa' => 'اردبیل', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 4, 'name' => 'اصفهان', 'slug' => 'esfahan', 'slug_fa' => 'اصفهان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 5, 'name' => 'البرز', 'slug' => 'alborz', 'slug_fa' => 'البرز', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 6, 'name' => 'ایلام', 'slug' => 'ilam', 'slug_fa' => 'ايلام', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 7, 'name' => 'بوشهر', 'slug' => 'boushehr', 'slug_fa' => 'بوشهر', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 8, 'name' => 'تهران', 'slug' => 'tehran', 'slug_fa' => 'تهران', 'is_active' => 0, 'active_for_order' => 1],
            ['id' => 9, 'name' => 'چهارمحال و بختیاری', 'slug' => 'chaharmahal', 'slug_fa' => 'چهارمحال-بختياری', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 10, 'name' => 'خراسان جنوبی', 'slug' => 'khorasan-jonobi', 'slug_fa' => 'خراسان-جنوبی', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 11, 'name' => 'خراسان رضوی', 'slug' => 'khorasan-razavi', 'slug_fa' => 'خراسان-رضوی', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 12, 'name' => 'خراسان شمالی', 'slug' => 'khorasan-shomali', 'slug_fa' => 'خراسان-شمالی', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 13, 'name' => 'خوزستان', 'slug' => 'khozestan', 'slug_fa' => 'خوزستان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 14, 'name' => 'زنجان', 'slug' => 'zanjan', 'slug_fa' => 'زنجان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 15, 'name' => 'سمنان', 'slug' => 'semnan', 'slug_fa' => 'سمنان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 16, 'name' => 'سیستان و بلوچستان', 'slug' => 'sistan-balochestan', 'slug_fa' => 'سيستان-بلوچستان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 17, 'name' => 'فارس', 'slug' => 'fars', 'slug_fa' => 'فارس', 'is_active' => 1, 'active_for_order' => 1],
            ['id' => 18, 'name' => 'قزوین', 'slug' => 'ghazvin', 'slug_fa' => 'قزوین', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 19, 'name' => 'قم', 'slug' => 'ghom', 'slug_fa' => 'قم', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 20, 'name' => 'کردستان', 'slug' => 'kordestan', 'slug_fa' => 'کردستان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 21, 'name' => 'کرمان', 'slug' => 'kerman', 'slug_fa' => 'کرمان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 22, 'name' => 'کرمانشاه', 'slug' => 'kermanshah', 'slug_fa' => 'کرمانشاه', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 23, 'name' => 'کهگیلویه و بویر احمد', 'slug' => 'kohgiloyeh-boyrahmad', 'slug_fa' => 'كهگيلويه-بويراحمد', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 24, 'name' => 'گلستان', 'slug' => 'golestan', 'slug_fa' => 'گلستان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 25, 'name' => 'گیلان', 'slug' => 'gilan', 'slug_fa' => 'گیلان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 26, 'name' => 'لرستان', 'slug' => 'lorestan', 'slug_fa' => 'لرستان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 27, 'name' => 'مازندران', 'slug' => 'mazandaran', 'slug_fa' => 'مازندران', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 28, 'name' => 'مرکزی', 'slug' => 'markazi', 'slug_fa' => 'مرکزی', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 29, 'name' => 'هرمزگان', 'slug' => 'hormozgan', 'slug_fa' => 'هرمزگان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 30, 'name' => 'همدان', 'slug' => 'hamedan', 'slug_fa' => 'همدان', 'is_active' => 0, 'active_for_order' => 0],
            ['id' => 31, 'name' => 'یزد', 'slug' => 'yazd', 'slug_fa' => 'یزد', 'is_active' => 0, 'active_for_order' => 0],
        ];

        foreach ($provinces as $province) {
            Province::updateOrInsert(['id' => $province['id']], $province);
        }
    }
}