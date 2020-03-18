<?php

namespace App\Console\Commands;

use App\Repository\UserRepositoryInterface;
use App\Services\UserService;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class CreateAdministratorAccount extends Command
{
    private $userService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create account  for administrator';

    /**
     * Create a new command instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        // Stop execution and ask a question for name
        $name = $this->ask('What is your name?', 'admin');

        // Stop execution and ask a question for email
        $email = $this->ask('What is your email?', 'admin@admin.com');

        // Stop execution and ask a question for password
        $password = $this->ask('What is the password?', '123456');


        // Confirmation
        if ($this->confirm("{$name}:{$email}:{$password}, do you wish to continue? [y|N]")) {
            $request = new Request
            ([
                'name' => $name,
                'role' => [User::ROLE_ADMIN],
                'email' => $email,
                'password' => bcrypt($password),
            ]);
            echo $this->userService->register($request);
            echo PHP_EOL;
        } else
            echo "Please try again!" . PHP_EOL;


    }
}
