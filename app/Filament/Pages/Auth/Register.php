<?php

namespace App\Filament\Pages\Auth;

use App\Models\Companies;
use App\Models\User;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;

class Register extends BaseRegister 
{

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getCompanyNameFormComponent(),
                        $this->getUsernameEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->companyId(),

                    ])
                    ->statePath('data'),
            ),
        ];
    }
    protected function getCompanyNameFormComponent(): Component
    {
        return   
         TextInput::make('company_name')
        ->required()
        ->label('Байгууллагын нэр')
        ->maxLength(255);
    }

    protected function getUsernameEmailFormComponent ()
    {
        return   
         TextInput::make('email')
        ->required()
        ->label('Утасны дугаар эсвэл И-мэйл')
        ->maxLength(255);
    }

    protected function companyId(): Component
    {
    return Hidden::make('company_id')
        ->default(function () {
            return $this->generateCompanyId();
        });
    }

    protected function generateCompanyId(): int
    {
    $maxCompanyId = User::max('company_id'); 
    return $maxCompanyId ? $maxCompanyId + 1 : 1; 
    }
    
    
    
}