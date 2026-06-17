<?php

namespace App\Filament\Resources\Permissions;

use App\Enums\NavigationGroup;
use App\Filament\Resources\Permissions\Pages\CreatePermission;
use App\Filament\Resources\Permissions\Pages\EditPermission;
use App\Filament\Resources\Permissions\Pages\ListPermissions;
use App\Filament\Resources\Permissions\Schemas\PermissionForm;
use App\Filament\Resources\Permissions\Tables\PermissionsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;
use UnitEnum;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

     protected static string | UnitEnum | null $navigationGroup = NavigationGroup::User;
    protected static ?string $modelLabel = 'دسترسی‌ها';
    protected static ?string $pluralModelLabel = 'دسترسی‌ها';
    protected static ?string $navigationLabel = 'دسترسی‌ها';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return PermissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PermissionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPermissions::route('/'),
        ];
    }
    // public static function getNavigationGroup(): ?string
    // {
    //     return 'مدیریت کاربران';
    // }
}
