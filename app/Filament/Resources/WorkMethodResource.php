<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkMethodResource\Pages;
use App\Models\WorkMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkMethodResource extends Resource
{
    protected static ?string $model = WorkMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'إدارة النظام';
    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return 'طريقة العمل';
    }

    public static function getPluralModelLabel(): string
    {
        return 'كيف ندير عملنا';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('تفاصيل طريقة العمل')
                    ->description('أدخل عنوان ووصف طريقة العمل')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('العنوان'),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpanFull()
                            ->rows(5)
                            ->label('الشرح'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->label('العنوان'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->label('الشرح'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('تاريخ الإضافة'),
            ])
            ->filters([
                //
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
                        'onclick' => 'if (!confirm("هل أنت متأكد من حذف هذا العنصر؟")) { event.stopPropagation(); return false; }'
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
            'index' => Pages\ListWorkMethods::route('/'),
            'create' => Pages\CreateWorkMethod::route('/create'),
            'view' => Pages\ViewWorkMethod::route('/{record}'),
            'edit' => Pages\EditWorkMethod::route('/{record}/edit'),
        ];
    }
}
