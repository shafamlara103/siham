<?php declare(strict_types=1);

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;

final class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
        $this->callAfterResolving(BladeCompiler::class, function () {
            Blade::component('components.userapprove', 'jet-userapprove');
        });
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->login)
                ->orWhere('name', $request->login)
                ->orWhere('username', $request->login)
                ->first();

            if (
                $user &&
                Hash::check($request->password, $user->password)
            ) {
                return $user;
            }
        });
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);
        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }


}
