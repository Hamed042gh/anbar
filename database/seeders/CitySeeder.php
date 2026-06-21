<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * نام جدول هدف
     */
    protected string $table = 'cities';

    /**
     * مسیر فایل دیتای شهرها (pipe-separated)
     * هر سطر: id|name|slug_en|slug_fa|province_id|is_active|active_for_order|created_at|updated_at|deleted
     */
    protected string $dataFile = __DIR__ . '/data/cities.csv';

    /**
     * تعداد ردیف در هر insert (برای جلوگیری از خطای too many placeholders)
     */
    protected int $chunkSize = 200;

    public function run(): void
    {
        if (!file_exists($this->dataFile)) {
            $this->command?->error("فایل دیتا پیدا نشد: {$this->dataFile}");
            return;
        }

        $handle = fopen($this->dataFile, 'r');
        if ($handle === false) {
            $this->command?->error("امکان باز کردن فایل دیتا وجود ندارد.");
            return;
        }

        // خط هدر را رد می‌کنیم
        $header = fgets($handle);

        $now = now();
        $buffer = [];
        $total = 0;

        while (($line = fgets($handle)) !== false) {
            $line = rtrim($line, "\r\n");
            if ($line === '') {
                continue;
            }

            $parts = explode('|', $line);

            // اطمینان از تعداد ستون‌ها
            if (count($parts) !== 10) {
                $this->command?->warn("ردیف نامعتبر رد شد: {$line}");
                continue;
            }

            [$id, $name, $slugEn, $slugFa, $provinceId, $isActive, $activeForOrder, $createdAt, $updatedAt, $deleted] = $parts;

            $buffer[] = [
                'id'               => (int) $id,
                'name'             => $name,
                'slug_en'          => $slugEn === '' ? null : $slugEn,
                'slug_fa'          => $slugFa,
                'province_id'      => $provinceId,
                'is_active'        => (int) $isActive,
                'active_for_order' => (int) $activeForOrder,
                'created_at'       => $createdAt === '' ? null : $createdAt,
                'updated_at'       => $updatedAt === '' ? $now : $updatedAt,
                'deleted'          => (int) $deleted,
            ];

            if (count($buffer) >= $this->chunkSize) {
                $this->upsertChunk($buffer);
                $total += count($buffer);
                $buffer = [];
            }
        }

        if (!empty($buffer)) {
            $this->upsertChunk($buffer);
            $total += count($buffer);
        }

        fclose($handle);

        $this->command?->info("سیدر شهرها با موفقیت اجرا شد. تعداد ردیف: {$total}");
    }

    /**
     * درج یا به‌روزرسانی یک دسته از ردیف‌ها بر اساس id
     */
    protected function upsertChunk(array $rows): void
    {
        DB::table($this->table)->upsert(
            $rows,
            ['id'],
            ['name', 'slug_en', 'slug_fa', 'province_id', 'is_active', 'active_for_order', 'created_at', 'updated_at', 'deleted']
        );
    }
}