<?php

namespace App\Console\Commands;

use App\Exceptions\UnknownRoleException;
use App\Exceptions\UnknownUserException;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;

class SetUserAsSU extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:give-su {userId : The id of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @throws UnknownUserException|UnknownRoleException
     */
    public function handle()
    {
        $user = User::find($this->argument('userId'));
        $role = Role::where('name', 'su')->first();

        if(empty($user)) {
            throw new UnknownUserException();
        }

        if(empty($role)) {
            throw new UnknownRoleException();
        }

        try {
            $user->role_id = $role->id;
            $user->save();

            $this->info("$user->id: $user->name now has a <fg=red>su role</fg=red>");
        } catch (Exception $exception) {
            $this->error('Something went wrong during the role set.');
            $this->line($exception->getMessage());
            $this->line($exception->getTraceAsString());
        }
    }
}
