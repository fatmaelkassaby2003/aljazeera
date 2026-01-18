<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectorResource\Pages;
use App\Models\Sector;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SectorResource extends Resource
{
    protected static ?string $model = Sector::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'إدارة النظام';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'قطاع';
    }

    public static function getPluralModelLabel(): string
    {
        return 'القطاعات';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('تفاصيل القطاع')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('المعلومات الأساسية')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('اسم القطاع'),
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->preload()
                                    ->searchable()
                                    ->label('الفئة')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->label('اسم الفئة'),
                                    ]),
                                Forms\Components\Textarea::make('description')
                                    ->required()
                                    ->columnSpanFull()
                                    ->label('الوصف'),
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('sectors')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->label('صورة القطاع')
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Tabs\Tab::make('الخدمات')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->schema([
                                Forms\Components\Repeater::make('services')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('service')
                                            ->required()
                                            ->label('اسم الخدمة'),
                                    ])
                                    ->addActionLabel('إضافة خدمة')
                                    ->defaultItems(1)
                                    ->label('الخدمات المقدمة')
                                    ->grid(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('المناهج')
                            ->icon('heroicon-o-book-open')
                            ->schema([
                                Forms\Components\Repeater::make('methodologies')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->label('عنوان المنهجية'),
                                        Forms\Components\Textarea::make('description')
                                            ->required()
                                            ->label('وصف المنهجية')
                                            ->columnSpanFull(),
                                    ])
                                    ->addActionLabel('إضافة منهجية')
                                    ->defaultItems(1)
                                    ->label('المناهج المتبعة')
                                    ->columns(2),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->label('الصورة')
                    ->extraAttributes(['style' => 'margin-inline-start: -1rem !important;']),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold')
                    ->sortable()
                    ->label('اسم القطاع'),
                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->color('warning')
                    ->sortable()
                    ->label('الفئة'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->label('الوصف'),
                Tables\Columns\TextColumn::make('services_count')
                    ->counts('services')
                    ->badge()
                    ->color('success')
                    ->label('عدد الخدمات'),
                Tables\Columns\TextColumn::make('methodologies_count')
                    ->counts('methodologies')
                    ->badge()
                    ->color('info')
                    ->label('عدد المناهج'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('تاريخ الإنشاء'),
            ])
            ->filters([
                //
            ])
            ->actionsColumnLabel('الإجراءات')
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\Action::make('delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->iconButton()
                    ->extraAttributes([
                        'onclick' => 'if (!confirm("هل أنت متأكد من حذف هذا العنصر؟")) { event.stopPropagation(); return false; }'
                    ])
                    ->action(function ($record) {
                        \Log::info('DELETE ACTION STARTED', [
                            'record_id' => $record->id,
                            'record_name' => $record->name,
                        ]);
                        
                        try {
                            $record->delete();
                            \Log::info('DELETE ACTION SUCCESS', ['record_id' => $record->id]);
                            
                            // Show success notification
                            \Filament\Notifications\Notification::make()
                                ->title('تم الحذف بنجاح')
                                ->success()
                                ->send();
                                
                        } catch (\Exception $e) {
                            \Log::error('DELETE ACTION FAILED', [
                                'record_id' => $record->id,
                                'error' => $e->getMessage(),
                                'trace' => $e->getTraceAsString()
                            ]);
                            
                            \Filament\Notifications\Notification::make()
                                ->title('فشل الحذف')
                                ->danger()
                                ->send();
                                
                            throw $e;
                        }
                    })
                    ->after(function () {
                        // Force page refresh after delete
                        return redirect()->to(request()->header('Referer'));
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
            'index' => Pages\ListSectors::route('/'),
            'create' => Pages\CreateSector::route('/create'),
            'view' => Pages\ViewSector::route('/{record}'),
            'edit' => Pages\EditSector::route('/{record}/edit'),
        ];
    }
}
