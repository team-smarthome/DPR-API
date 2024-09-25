<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class KeyGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate application key';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $key = 'base64:' . base64_encode(random_bytes(32));

        // Ganti APP_KEY di .env jika ada, atau tambahkan jika belum ada
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents(
                $path,
                str_replace('APP_KEY=' . env('APP_KEY'), 'APP_KEY=' . $key, file_get_contents($path))
            );

            $this->info('Application key set successfully.');
        }
    }
}
