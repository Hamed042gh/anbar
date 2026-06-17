<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    User, Category, Unit, Warehouse, WarehouseLocation,
    Supplier, Customer, PriceList, PriceListItem,
    Product, ProductVariant, Inventory, StockMovement,
    PurchaseOrder, PurchaseOrderItem, PurchaseReceipt, PurchaseReceiptItem,
    Invoice, InvoiceItem, InventoryCheck, InventoryCheckItem,
};
use Illuminate\Support\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::create([
            'name' => 'مدیر سیستم',
            'email' => 'admin@anbar.test',
            'password' => bcrypt('password'),
            'is_super_admin' => true,
        ]);

        $units = collect([
            ['name' => 'عدد', 'symbol' => 'pc'],
            ['name' => 'کیلوگرم', 'symbol' => 'kg'],
            ['name' => 'بسته', 'symbol' => 'pkg'],
            ['name' => 'متر', 'symbol' => 'm'],
        ])->map(fn ($u) => Unit::create($u));

        $categories = collect(['لوازم خانگی', 'لوازم التحریر', 'مواد غذایی', 'پوشاک', 'ابزار و یراق', 'الکترونیک'])
            ->map(fn ($name, $i) => Category::create([
                'name' => $name,
                'slug' => 'cat-' . ($i + 1),
                'is_active' => true,
            ]));

        $warehouses = collect(['انبار مرکزی', 'انبار شعبه دو'])->map(function ($name) {
            $warehouse = Warehouse::create(['name' => $name, 'address' => 'تهران، خیابان نمونه', 'is_active' => true]);
            $locations = collect(range(1, 3))->map(fn ($i) => WarehouseLocation::create([
                'warehouse_id' => $warehouse->id,
                'name' => "محل {$i}",
                'aisle' => "A{$i}", 'rack' => "R{$i}", 'shelf' => "S{$i}",
                'is_active' => true,
            ]));
            $warehouse->setRelation('locations', $locations);
            return $warehouse;
        });

        $suppliers = collect(['شرکت پخش البرز', 'بازرگانی پارس', 'تجارت گستر شرق', 'صنایع فولاد ایران', 'وارداتی کیان'])
            ->map(fn ($name, $i) => Supplier::create([
                'name' => $name,
                'phone' => '0912' . rand(1000000, 9999999),
                'email' => 'supplier' . ($i + 1) . '@test.com',
                'address' => 'تهران', 'balance' => 0, 'is_active' => true,
            ]));

        $customers = collect(['فروشگاه رفاه', 'علی محمدی', 'سوپرمارکت ستاره', 'شرکت آرین تجارت', 'حسین رضایی', 'فروشگاه زنجیره‌ای افق', 'مریم احمدی', 'بازرگانی نوین', 'رضا کریمی', 'فروشگاه مرکزی'])
            ->map(fn ($name, $i) => Customer::create([
                'name' => $name,
               'type' => str_contains($name, 'فروشگاه') || str_contains($name, 'شرکت') || str_contains($name, 'بازرگانی') || str_contains($name, 'سوپرمارکت') ? 'wholesale' : 'retail',
                'phone' => '0912' . rand(1000000, 9999999),
                'email' => 'customer' . ($i + 1) . '@test.com',
                'address' => 'تهران', 'credit_limit' => 0, 'balance' => 0, 'is_active' => true,
            ]));

        $priceList = PriceList::create(['name' => 'لیست قیمت عمومی', 'type' => 'retail', 'is_active' => true]);

        $productNames = [
            'یخچال ساید بای ساید', 'ماشین لباسشویی', 'جاروبرقی', 'پنکه رومیزی', 'اتو بخار',
            'دفتر ۱۰۰ برگ', 'خودکار آبی', 'مداد مشکی', 'پاک‌کن', 'ماژیک رنگی',
            'روغن آفتابگردان', 'برنج ایرانی', 'چای سیاه', 'قند شکسته', 'رب گوجه',
            'پیراهن مردانه', 'شلوار جین', 'تیشرت ساده', 'کاپشن زمستانی', 'کفش ورزشی',
            'دریل برقی', 'پیچ‌گوشتی ست', 'متر فلزی', 'چسب نواری', 'قفل آسانسوری',
        ];

        $variants = collect();
        collect($productNames)->each(function ($name, $i) use ($categories, $units, &$variants) {
            $product = Product::create([
                'category_id' => $categories->random()->id,
                'unit_id' => $units->random()->id,
                'name' => $name,
                'sku' => 'PRD-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'type' => 'simple',
                'is_active' => true,
            ]);

            $cost = rand(50_000, 2_000_000);
            $variants->push(ProductVariant::create([
                'product_id' => $product->id,
                'sku' => $product->sku . '-V1',
                'price' => (int) ($cost * 1.3),
                'cost_price' => $cost,
                'reorder_level' => rand(5, 20),
                'is_default' => true,
                'is_active' => true,
            ]));
        });

        $variants->each(fn ($v) => PriceListItem::create([
            'price_list_id' => $priceList->id,
            'variant_id' => $v->id,
            'price' => $v->price,
        ]));

        $variants->each(function ($variant) use ($warehouses) {
            $warehouse = $warehouses->random();
            $location = $warehouse->locations->random();
            $qty = rand(0, 9) < 3 ? rand(0, max(0, $variant->reorder_level - 1)) : rand($variant->reorder_level + 5, 200);

            Inventory::create([
                'variant_id' => $variant->id,
                'warehouse_id' => $warehouse->id,
                'location_id' => $location->id,
                'quantity' => $qty,
                'avg_cost' => $variant->cost_price,
            ]);
        });

        for ($i = 0; $i < 15; $i++) {
            $orderDate = Carbon::now()->subDays(rand(1, 60));
            $warehouse = $warehouses->random();
            $status = rand(0, 4) === 0 ? 'draft' : 'received';

            $order = PurchaseOrder::create([
                'number' => 'PO-' . $orderDate->format('Ymd') . '-' . $i,
                'supplier_id' => $suppliers->random()->id,
                'warehouse_id' => $warehouse->id,
                'user_id' => $user->id,
                'status' => $status,
                'total_amount' => 0, 'paid_amount' => 0,
                'ordered_at' => $orderDate,
            ]);

            $orderTotal = 0;
            $items = collect();
            foreach ($variants->random(rand(2, 5)) as $variant) {
                $qty = rand(10, 50);
                $total = $qty * $variant->cost_price;
                $orderTotal += $total;

                $items->push(PurchaseOrderItem::create([
                    'purchase_order_id' => $order->id,
                    'variant_id' => $variant->id,
                    'quantity' => $qty,
                    'received_quantity' => $status === 'received' ? $qty : 0,
                    'unit_cost' => $variant->cost_price,
                    'total_cost' => $total,
                ]));
            }
            $order->update(['total_amount' => $orderTotal]);

            if ($status === 'received') {
                $receipt = PurchaseReceipt::create([
                    'number' => 'PR-' . $orderDate->format('Ymd') . '-' . $i,
                    'purchase_order_id' => $order->id,
                    'warehouse_id' => $warehouse->id,
                    'user_id' => $user->id,
                    'received_at' => $orderDate->copy()->addDays(rand(1, 3)),
                ]);

                foreach ($items as $item) {
                    PurchaseReceiptItem::create([
                        'purchase_receipt_id' => $receipt->id,
                        'purchase_order_item_id' => $item->id,
                        'variant_id' => $item->variant_id,
                        'quantity' => $item->quantity,
                        'unit_cost' => $item->unit_cost,
                        'total_cost' => $item->total_cost,
                    ]);

                    StockMovement::create([
                        'variant_id' => $item->variant_id,
                        'warehouse_id' => $warehouse->id,
                        'location_id' => $warehouse->locations->random()->id,
                        'user_id' => $user->id,
                        'type' => 'purchase',
                        'quantity' => $item->quantity,
                        'unit_cost' => $item->unit_cost,
                        'referenceable_type' => PurchaseReceipt::class,
                        'referenceable_id' => $receipt->id,
                        'note' => 'رسید خرید ' . $receipt->number,
                        'created_at' => $receipt->received_at,
                        'updated_at' => $receipt->received_at,
                    ]);
                }
            }
        }

        for ($i = 0; $i < 60; $i++) {
            $issuedAt = Carbon::now()->subDays(rand(0, 30))->setTime(rand(9, 19), rand(0, 59));
            $warehouse = $warehouses->random();
            $status = rand(0, 9) === 0 ? 'cancelled' : 'confirmed';

            $invoice = Invoice::create([
                'number' => 'INV-' . $issuedAt->format('Ymd') . '-' . $i,
                'customer_id' => $customers->random()->id,
                'warehouse_id' => $warehouse->id,
                'user_id' => $user->id,
                'price_list_id' => $priceList->id,
                'status' => $status,
                'total_amount' => 0, 'discount_amount' => 0, 'tax_amount' => 0,
                'payable_amount' => 0, 'paid_amount' => 0,
                'issued_at' => $issuedAt,
            ]);

            $total = 0;
            foreach ($variants->random(rand(1, 4)) as $variant) {
                $qty = rand(1, 5);
                $lineTotal = $qty * $variant->price;
                $total += $lineTotal;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'variant_id' => $variant->id,
                    'quantity' => $qty,
                    'unit_price' => $variant->price,
                    'discount_amount' => 0,
                    'total_price' => $lineTotal,
                    'created_at' => $issuedAt, 'updated_at' => $issuedAt,
                ]);

                if ($status !== 'cancelled') {
                    StockMovement::create([
                        'variant_id' => $variant->id,
                        'warehouse_id' => $warehouse->id,
                        'location_id' => $warehouse->locations->random()->id,
                        'user_id' => $user->id,
                        'type' => 'sale',
                        'quantity' => $qty,
                        'unit_cost' => $variant->cost_price,
                        'referenceable_type' => Invoice::class,
                        'referenceable_id' => $invoice->id,
                        'note' => 'فاکتور فروش ' . $invoice->number,
                        'created_at' => $issuedAt, 'updated_at' => $issuedAt,
                    ]);
                }
            }

            $tax = (int) ($total * 0.09);
            $payable = $total + $tax;
            $invoice->update([
                'total_amount' => $total, 'tax_amount' => $tax,
                'payable_amount' => $payable,
                'paid_amount' => $status === 'confirmed' ? $payable : 0,
            ]);
        }

        $check = InventoryCheck::create([
            'warehouse_id' => $warehouses->first()->id,
            'user_id' => $user->id,
            'status' => 'completed',
            'checked_at' => Carbon::now()->subDays(5),
        ]);

        Inventory::where('warehouse_id', $warehouses->first()->id)->get()->each(function ($inv) use ($check) {
            $diff = rand(0, 4) === 0 ? rand(-3, 3) : 0;
            InventoryCheckItem::create([
                'inventory_check_id' => $check->id,
                'variant_id' => $inv->variant_id,
                'system_quantity' => $inv->quantity,
                'actual_quantity' => $inv->quantity + $diff,
                // 'difference' => $diff,
            ]);
        });
    }
}