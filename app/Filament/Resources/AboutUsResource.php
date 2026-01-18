<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsResource\Pages;
use App\Models\AboutUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'إدارة النظام';
    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return 'معلوماتنا';
    }

    public static function getPluralModelLabel(): string
    {
        return 'تعرف على كياننا';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('صورة تعريفية')
                            ->image()
                            ->directory('about-us')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label('وصف الكيان')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('الرؤية والرسالة والقيم')
                    ->schema([
                        Forms\Components\Repeater::make('vision')
                            ->label('نقاط الرؤية')
                            ->schema([
                                Forms\Components\TextInput::make('point')
                                    ->label('النقطة')
                                    ->required(),
                            ])
                            ->defaultItems(1)
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('mission')
                            ->label('نقاط الرسالة')
                            ->schema([
                                Forms\Components\TextInput::make('point')
                                    ->label('النقطة')
                                    ->required(),
                            ])
                            ->defaultItems(1)
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('values')
                            ->label('نقاط القيم')
                            ->schema([
                                Forms\Components\TextInput::make('point')
                                    ->label('النقطة')
                                    ->required(),
                            ])
                            ->defaultItems(1)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة')
                    ->circular()
                    ->extraAttributes(['style' => 'margin-inline-start: -6rem !important;']),
                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime(),
            ])
            ->filters([])
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
            'index' => Pages\ListAboutUs::route('/'),
            'create' => Pages\CreateAboutUs::route('/create'),
            'view' => Pages\ViewAboutUs::route('/{record}'),
            'edit' => Pages\EditAboutUs::route('/{record}/edit'),
        ];
    }
}
