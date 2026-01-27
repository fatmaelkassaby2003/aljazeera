<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Support\Exceptions\Halt;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.pages.edit-profile';

    protected static ?string $navigationGroup = 'إدارة النظام';

    protected static ?string $navigationLabel = 'الملف الشخصي';

    protected static ?string $title = 'تعديل الملف الشخصي';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(auth()->user()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('المعلومات الشخصية')
                    ->schema([
                        TextInput::make('name')
                            ->label('الاسم')
                            ->required(),
                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->unique('users', 'email', auth()->user()),
                    ])->columns(2),
                
                Section::make('تغيير كلمة المرور')
                    ->description('اتركها فارغة إذا كنت لا تريد تغييرها')
                    ->schema([
                        TextInput::make('password')
                            ->label('كلمة المرور الجديدة')
                            ->password()
                            ->rule(Password::default()),
                        TextInput::make('password_confirmation')
                            ->label('تأكيد كلمة المرور')
                            ->password()
                            ->same('password'),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('حفظ التغييرات')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            if (empty($data['password'])) {
                unset($data['password']);
                unset($data['password_confirmation']);
            } else {
                $data['password'] = Hash::make($data['password']);
                unset($data['password_confirmation']);
            }

            auth()->user()->update($data);

            Notification::make()
                ->title('تم التحديث بنجاح')
                ->success()
                ->send();
            
        } catch (Halt $exception) {
            return;
        }
    }
}
