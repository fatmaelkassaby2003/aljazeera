<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialServiceResource\Pages;
use App\Models\FinancialService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FinancialServiceResource extends Resource
{
    protected static ?string $model = FinancialService::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'الخدمات';
    protected static ?string $modelLabel = 'القوائم المالية';
    protected static ?string $pluralModelLabel = 'القوائم المالية';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('name', 'القوائم المالية');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\Section::make('تفاصيل الخدمة')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم الخدمة')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('price')
                            ->label('السعر')
                            ->numeric()
                            ->suffix(' ر.س'),
                        Forms\Components\Textarea::make('description')
                            ->label('الوصف')
                            ->rows(3)
                            ->columnSpanFull(),
                         Forms\Components\Textarea::make('important_note')
                            ->label('ملحوظة مهمة')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('التفاصيل الإضافية')
                    ->schema([
                        Forms\Components\Repeater::make('types')
                            ->label('أنواع الخدمة')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('العنوان')
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->label('الشرح')
                                    ->rows(2),
                            ])
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('work_mechanism')
                            ->label('آلية العمل')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('العنوان')
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->label('الشرح')
                                    ->rows(2),
                            ])
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('financial_periods')
                            ->label('الفترات المالية المتاحة')
                            ->schema([
                                Forms\Components\TextInput::make('period')
                                    ->label('الفترة')
                                    ->required(),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الخدمة')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->numeric(decimalPlaces: 0)
                    ->suffix(' ر.س'),
            ])
            ->filters([])
            ->actionsColumnLabel('الإجراءات')
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return true;
    }

    public static function canDeleteAny(): bool
    {
        return true;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinancialServices::route('/'),
            'edit' => Pages\EditFinancialService::route('/{record}/edit'),
            'view' => Pages\ViewFinancialService::route('/{record}'),
        ];
    }
}
