<?php

namespace Hrshadhin\Userstamps;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;


class UserstampsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro(
            'userstamps', function () {
                $this->unsignedInteger('created_by')->nullable()
                    ->index();
                $this->unsignedInteger('updated_by')->nullable()
                    ->index();
                $this->unsignedInteger('deleted_by')->nullable()
                    ->index();
            }
        );
        Blueprint::macro(
            'dropUserstamps', function () {
                $this->dropColumn(['created_by', 'updated_by', 'deleted_by']);
            }
        );
    }
}
