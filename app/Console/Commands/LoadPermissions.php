<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;

class LoadPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:load-permissions {--update-su : Give to su all permissions.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load missing permissions to database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        foreach (Permission::$permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }
        $this->info('Permissions loaded successfully!');

        if($this->option('update-su')) {
            Role::where('name', 'su')
                ->first()
                ->permissions()
                ->sync(
                    Permission::all()
                        ->map(fn(Permission $permission) => $permission->id)
                );

            $this->info('<fg=red>SU role</fg=red> updated successfully!');
        }
    }
}
