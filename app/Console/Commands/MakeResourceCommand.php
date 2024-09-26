<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeResourceCommand extends Command
{
  protected $signature = 'make:resource {name} {folder?}';
  protected $description = 'Create a new resource class';

  public function handle()
  {
    $name = $this->argument('name');
    $folder = $this->argument('folder') ? $this->argument('folder') : '';
    $folderPath = $folder ? "app/Http/Resources/{$folder}" : "app/Http/Resources";
    $resourcePath = base_path("{$folderPath}/{$name}Resource.php");

    if (!File::exists(base_path($folderPath))) {
      File::makeDirectory(base_path($folderPath), 0755, true);
    }

    if (File::exists($resourcePath)) {
      $this->error("Resource class {$name} already exists!");
      return;
    }

    $namespace = $folder ? "App\Http\Resources\\" . str_replace('/', '\\', $folder) : "App\Http\Resources";
    $template = "<?php\n\nnamespace {$namespace};\n\nuse Illuminate\Http\Resources\Json\JsonResource;\n\nclass {$name}Resource extends JsonResource\n{\n    public function toArray(\$request)\n    {\n        return [\n            // Define your resource structure here\n        ];\n    }\n}\n";

    File::put($resourcePath, $template);

    $this->info("Resource class {$name} created successfully at {$resourcePath}");
  }
}
