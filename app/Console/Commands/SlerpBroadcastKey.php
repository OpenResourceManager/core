<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SlerpBroadcastKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slerp:bckey {--show : Display the key instead of modifying files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a new broadcast key.';

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
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('show')) {
            $key = $this->laravel['config']['slerp.bc_key'];
            $this->info('The current Broadcast Key is: ');
        } else {
            $key = $this->generateRandomSecureKey();
            $this->setBroadcastKeyInEnv($key);
            $this->info('Broadcast Key set successfully: ');
        }
        $this->info($key);
    }

    /**
     * Sets Broadcast Key in environment file
     *
     * @param $key
     */
    protected function setBroadcastKeyInEnv($key)
    {
        file_put_contents($this->laravel->environmentFilePath(), str_replace(
            'BC_KEY=' . $this->laravel['config']['slerp.bc_key'],
            'BC_KEY=' . $key,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    /**
     * Generate Random Secure Key
     *
     * Generates a cryptographically secure key
     *
     * @param int $length
     * @return string
     */
    function generateRandomSecureKey($length = 32)
    {
        return generate_random_encoded_bytes($length);
    }
}
