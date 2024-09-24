<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRequestCommand extends Command
{
    protected $signature = 'make:request {name}';
    protected $description = 'Create a new request class';

    public function handle()
    {
        $name = $this->argument('name');
        $requestPath = base_path("app/Http/Requests/{$name}Request.php");

        if (File::exists($requestPath)) {
            $this->error("Request class {$name} already exists!");
            return;
        }

        $template = "<?php\n\nnamespace App\Http\Requests;\n\nuse Illuminate\Foundation\Http\FormRequest;\n\nclass {$name}Request extends FormRequest\n{\n    public function authorize()\n    {\n        return true;\n    }\n\n    public function rules()\n    {\n        return [\n            // Define your validation rules here\n        ];\n    }\n}\n";

        File::put($requestPath, $template);

        $this->info("Request class {$name} created successfully at {$requestPath}");
    }
}
