<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRequestCommand extends Command
{
  protected $signature = 'make:request {name} {folder?}';
  protected $description = 'Create a new request class';

  public function handle()
  {
    $name = $this->argument('name');
    $folder = $this->argument('folder') ? $this->argument('folder') : '';
    $folderPath = $folder ? "app/Http/Requests/{$folder}" : "app/Http/Requests";
    $requestPath = base_path("{$folderPath}/{$name}Request.php");

    if (!File::exists(base_path($folderPath))) {
      File::makeDirectory(base_path($folderPath), 0755, true);
    }

    if (File::exists($requestPath)) {
      $this->error("Request class {$name} already exists!");
      return;
    }

    $namespace = $folder ? "App\Http\Requests\\" . str_replace('/', '\\', $folder) : "App\Http\Requests";
    $template = "<?php\n\nnamespace {$namespace};\n\nuse Illuminate\Foundation\Http\FormRequest;\n\nclass {$name}Request extends FormRequest\n{\n    public function authorize()\n    {\n        return true;\n    }\n\n    public function rules()\n    {\n        return [\n            // Define your validation rules here\n        ];\n    }\n}\n";

    File::put($requestPath, $template);

    $this->info("Request class {$name} created successfully at {$requestPath}");
  }
}
