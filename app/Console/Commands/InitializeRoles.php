<?php

namespace App\Console\Commands;

use App\Exceptions\MissingRoleIdColumnException;
use App\Exceptions\UnknownRoleException;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Schema;

class InitializeRoles extends Command
{
    protected const DEFAULT_ROLE_ID = 1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:init {roleId? : The id of the role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize roles in users with null role_id';

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
     * @throws MissingRoleIdColumnException
     * @throws UnknownRoleException
     */
    public function handle()
    {
        $roleId = $this->argument('roleId') ?? static::DEFAULT_ROLE_ID;

        if(!Schema::hasColumn((new User)->getTable(), 'role_id')) {
            throw new MissingRoleIdColumnException();
        }

        if(empty(Role::find($roleId))) {
            throw new UnknownRoleException();
        }

        try {
            User::unguard();

            User::whereNull('role_id')->update(['role_id' => $roleId]);

            $this->info('Roles initialized successfully!');
        } catch (Exception $exception) {
            $this->error('Something went wrong during the initialization');
            $this->info($exception->getMessage());
            $this->info($exception->getTraceAsString());
        } finally {
            User::reguard();
        }
    }
}
