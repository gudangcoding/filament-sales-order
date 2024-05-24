<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Tenancy\EditTeamProfile;
use App\Filament\Pages\Tenancy\RegisterTeam;
use App\Http\Middleware\TenantMiddleware;
use App\Models\Team;
use Filament\Auth\FilamentUser; // Import FilamentUser
use Filament\Contracts\User; // Import User Contract
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Plugin;

class AdminPanelProvider extends PanelProvider
{
    use HasRoles;
    public function panel(Panel $panel): Panel
    {


        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->profile()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->sidebarCollapsibleOnDesktop(true)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ])
            ->plugins([

                FilamentShieldPlugin::make()
            ])

            ->tenant(Team::class, ownershipRelationship: 'team', slugAttribute: 'slug')


            ->tenantRegistration(RegisterTeam::class)
            ->tenantProfile(EditTeamProfile::class)
            ->brandName('PT SAJ')
            ->databaseNotifications()
            ->tenantMenu(function () {
                return auth()->user()->hasRole('super_admin'); // Check for super_admin role
            })
            // ->brandLogo(asset('images/logo.svg'))
        ;
    }
}
