<?php

namespace App\Filament\Resources\Roles;

use App\Enums\NavigationGroup;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Filament\Resources\Roles\Schemas\RoleForm;
use App\Filament\Resources\Roles\Tables\RolesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;
use UnitEnum;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

     protected static string | UnitEnum | null $navigationGroup = NavigationGroup::User;
    protected static ?string $modelLabel = 'نقش‌ها';
    protected static ?string $pluralModelLabel = 'نقش‌ها';
    protected static ?string $navigationLabel = 'نقش‌ها';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
        ];
    }

    // public static function getNavigationGroup(): ?string
    // {
    //     return 'مدیریت کاربران';
    // }
}
