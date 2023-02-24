<?php

namespace Laraditz\PermissionPlus\Console;

use Illuminate\Console\Command;


class GeneratePermissionPlusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission-plus:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all routes for permissions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app('permission-plus')->generatePermissions();
    }
}
