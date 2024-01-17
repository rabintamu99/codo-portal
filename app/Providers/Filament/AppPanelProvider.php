<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Navigation\NavigationGroup;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin; 
use Filament\Notifications\Livewire\DatabaseNotifications;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
=======
>>>>>>> Stashed changes

>>>>>>> Stashed changes
class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('/')
            ->login()
            ->breadcrumbs(true)
            ->brandName('CODO ポータル')
            ->sidebarCollapsibleOnDesktop()
            ->plugins([FilamentFullCalendarPlugin::make()])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            ->databaseNotifications()
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            ->navigationGroups([
                NavigationGroup::make()
                     ->label('Shop')
                     ->icon('heroicon-o-shopping-cart'),
                NavigationGroup::make()
                    ->label('Blog')
                    ->icon('heroicon-o-pencil'),
                NavigationGroup::make()
                    ->label(fn (): string => __('navigation.settings'))
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
              //Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
         
    }
}
