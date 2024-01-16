<?php

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Filament\Resources\AssignmentResource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
 

class AssignSubmit extends Page
{
    protected static string $resource = AssignmentResource::class;

    protected static string $view = 'filament.resources.assignment-resource.pages.assign-submit';
    use InteractsWithForms;

    public function mount(): void
    {
        static::authorizeResourceAccess();
    }



}
// class EditCompany extends Page implements HasForms
// {
//     use InteractsWithForms;

//     public ?array $data = []; 
//     public function mount(): void 
//     {
//         $this->form->fill();
//     }
 
//     public function form(Form $form): Form
//     {
//         return $form
//             ->schema([
//                 TextInput::make('name')
//                     ->required(),
//             ])
//             ->statePath('data');
//     } 
// }