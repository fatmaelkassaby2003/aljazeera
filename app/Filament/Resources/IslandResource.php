<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IslandResource\Pages;
use App\Models\Island;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IslandResource extends Resource
{
    protected static ?string $model = Island::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = 'إدارة النظام';
    protected static ?int $navigationSort = 0;
    protected static ?string $navigationLabel = 'معلومات الجزيرة';

    public static function getModelLabel(): string
    {
        return 'جزيرة';
    }

    public static function getPluralModelLabel(): string
    {
        return 'معلومات الجزيرة';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات العامة')
                    ->description('تفاصيل الجزيرة الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('اسم الجزيرة'),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpanFull()
                            ->label('الوصف'),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->disk('public')
                            ->directory('islands')
                            ->visibility('public')
                            ->imageEditor()
                            ->label('الصورة الرئيسية')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('المميزات (Highlights)')
                    ->description('أبرز ما يميز الجزيرة')
                    ->schema([
                        Forms\Components\Repeater::make('highlights')
                            ->simple(
                                Forms\Components\TextInput::make('highlight')->required()->label('الميزة')
                            )
                            ->label('قائمة المميزات')
                            ->addActionLabel('إضافة ميزة')
                            ->grid(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->label('الصورة'),
                Tables\Columns\TextColumn::make('name')
                    ->weight('bold')
                    ->label('الاسم'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->label('النبذة'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('آخر تحديث'),
            ])
            ->filters([
                //
            ])
            ->actionsColumnLabel('الإجراءات')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ])->dropdown(),
            ])
            ->bulkActions([
                // No delete
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIslands::route('/'),
            'create' => Pages\CreateIsland::route('/create'),
            'edit' => Pages\EditIsland::route('/{record}/edit'),
        ];
    }
}
