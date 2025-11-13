<?php

namespace App\Providers;

use App\Events\HandleGlobalShortcutRefreshEvent;
use Illuminate\Support\Facades\Config;
use Native\Desktop\Facades\GlobalShortcut;
use Native\Desktop\Facades\Menu;
use Native\Desktop\Facades\MenuBar;

class NativeAppServiceProvider
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        $deepLinkPrefix = config('nativephp.deeplink_scheme').'://';
        MenuBar::create()
            ->icon(public_path('images/menuBarIconTemplate@2x.png'))
            ->route('menubar.index')->withContextMenu(
                Menu::make(
                    Menu::link("{$deepLinkPrefix}refresh", 'Refresh', 'CmdOrCtrl+R'),
                    Menu::separator(),
                    Menu::link('https://larajobs.com', 'View LaraJobs.com', 'CmdOrCtrl+L'),
                    Menu::link('https://larajobs.com/create', 'Post a Job', 'CmdOrCtrl+P'),
                    Menu::link('https://larajobs.com/laravel-consultants', 'Hire a Laravel Consultant', 'CmdOrCtrl+H'),
                    Menu::separator(),
                    Menu::quit()
                )
            );

        GlobalShortcut::key('CmdOrCtrl+Shift+J')
            /**
             * See: https://nativephp.com/docs/desktop/2/the-basics/global-hotkeys
             */
            ->event(HandleGlobalShortcutRefreshEvent::class)
            ->register();

        // For debugging
        if (Config::get('app.debug', false)) {
            // Window::open()->alwaysOnTop();
        }
    }
}
