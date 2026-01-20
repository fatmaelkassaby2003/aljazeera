<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BudgetRangeResource\Pages;
use App\Filament\Resources\BudgetRangeResource\RelationManagers;
use App\Models\BudgetRange;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BudgetRangeResource extends Resource
{
    protected static ?string $model = BudgetRange::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    
    protected static ?string $navigationLabel = 'نطاقات الأسعار';
    
    protected static ?string $modelLabel = 'نطاق السعر';
    
    protected static ?string $pluralModelLabel = 'نطاقات الأسعار';
    
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->label('التسمية')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('مثال: 50,000 - 100,000 ر.س'),
                    
                Forms\Components\TextInput::make('min_amount')
                    ->label('الحد الأدنى')
                    ->numeric()
                    ->suffix('ر.س')
                    ->nullable()
                    ->helperText('اتركه فارغاً إذا كان "أقل من"'),
                    
                Forms\Components\TextInput::make('max_amount')
                    ->label('الحد الأقصى')
                    ->numeric()
                    ->suffix('ر.س')
                    ->nullable()
                    ->helperText('اتركه فارغاً إذا كان "أكثر من"')
                    ->gt('min_amount'),
                    
                Forms\Components\Toggle::make('is_active')
                    ->label('مفعل')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('التسمية')
                    ->searchable()
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('min_amount')
                    ->label('الحد الأدنى')
                    ->numeric(decimalPlaces: 0)
                    ->suffix(' ر.س')
                    ->placeholder('-'),
                    
                Tables\Columns\TextColumn::make('max_amount')
                    ->label('الحد الأقصى')
                    ->numeric(decimalPlaces: 0)
                    ->suffix(' ر.س')
                    ->placeholder('-'),
                    
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('مفعل'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة')
                    ->placeholder('الكل')
                    ->trueLabel('مفعل')
                    ->falseLabel('غير مفعل'),
            ])
            ->actionsColumnLabel('الإجراءات')
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->extraAttributes(['style' => 'padding: 0.125rem !important;']),
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->extraAttributes(['style' => 'padding: 0.125rem !important;']),
                Tables\Actions\Action::make('delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->iconButton()
                    ->extraAttributes([
                        'onclick' => 'if (!confirm("هل أنت متأكد من حذف هذا النطاق؟")) { event.stopPropagation(); return false; }'
                    ])
                    ->action(function ($record) {
                        $record->delete();
                        \Filament\Notifications\Notification::make()
                            ->title('تم الحذف بنجاح')
                            ->success()
                            ->send();
                    })
                    ->after(function () {
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBudgetRanges::route('/'),
            'create' => Pages\CreateBudgetRange::route('/create'),
            'edit' => Pages\EditBudgetRange::route('/{record}/edit'),
        ];
    }
}
