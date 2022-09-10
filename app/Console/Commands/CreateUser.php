<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {email} {pwd}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user for the application, including an email and password (in that order).';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::create([
            'email' => $this->argument('email'),
            'name' => 'admin_account',
            'password' => Hash::make($this->argument('pwd'))
        ]);
        echo "\nUser with e-mail \"" . $this->argument('email') . "\" and password \"" . $this->argument('pwd') . "\" has been created.\n" .
            "\nPlease copy your account details to a safe location, you will not be sent your password again." .
            "\nIf a password needs to be changed or an account deleted, use user:change or user:delete respectively.\n";
        return 0;
    }
}
