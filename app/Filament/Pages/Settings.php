<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedCog6Tooth;
    protected static ?string $title = 'تنظیمات پنل';
    protected string $view = 'filament.pages.settings';
    protected static ?int $navigationSort = 100;

    public ?array $data = [];

   public function mount(): void
    {
        $this->form->fill([
            'primary_color' => Setting::get('primary_color', '#1E3A5F'),
            'company_name' => Setting::get('company_name', ''),
            'invoice_footer_text' => Setting::get('invoice_footer_text', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ColorPicker::make('primary_color')
                    ->label('رنگ اصلی پنل'),

                TextInput::make('company_name')
                    ->label('نام شرکت'),

                Textarea::make('invoice_footer_text')
                    ->label('متن پایین فاکتور'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('تنظیمات ذخیره شد')
            ->success()
            ->send();
    }
}