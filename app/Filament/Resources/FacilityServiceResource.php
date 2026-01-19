<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilityServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FacilityServiceResource extends Resource
{
    protected static ?string $model = \App\Models\FacilityService::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'الخدمات';
    protected static ?string $modelLabel = 'إدارة المرافق';
    protected static ?string $pluralModelLabel = 'إدارة المرافق';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\Section::make('تفاصيل الخدمة')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم الخدمة')
                            ->default('إدارة المرافق')
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
                                Forms\Components\FileUpload::make('images')
                                    ->label('صور النوع')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->disk('public')
                                    ->directory('services/facility/types')
                                    ->visibility('public'),
                                Forms\Components\Repeater::make('items')
                                    ->label('البنود')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('عنوان البند')
                                            ->required(),
                                        Forms\Components\Textarea::make('description')
                                            ->label('شرح البند')
                                            ->rows(2),
                                        Forms\Components\Repeater::make('points')
                                            ->label('نقاط البند')
                                            ->schema([
                                                Forms\Components\TextInput::make('point')
                                                    ->label('النقطة')
                                                    ->required(),
                                            ]),
                                    ])
                                    ->collapsible(),
                                Forms\Components\Textarea::make('description')
                                    ->label('الشرح')
                                    ->rows(2),
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
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->extraAttributes(['style' => 'padding: 0.125rem !important;']),
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->extraAttributes(['style' => 'padding: 0.125rem !important;']),
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
            'index' => Pages\ListFacilityServices::route('/'),
            'edit' => Pages\EditFacilityService::route('/{record}/edit'),
            'view' => Pages\ViewFacilityService::route('/{record}'),
        ];
    }
}
