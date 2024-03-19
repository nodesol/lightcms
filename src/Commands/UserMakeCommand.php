<?php

namespace Nodesol\Lightcms\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Hash;
use Nodesol\Lightcms\Models\LightcmsUser;

class UserMakeCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lightcms:user
                            {name}
                            {email}
                            {password}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a cms user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = LightcmsUser::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password')),
        ]);
        $this->comment('User Created: ');
        $this->output($user);

        return self::SUCCESS;
    }
}
