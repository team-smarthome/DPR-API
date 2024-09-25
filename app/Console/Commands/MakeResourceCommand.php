<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeResourceCommand extends Command
{
  protected $signature = 'make:response {name}';
  protected $description = 'Create a new response class';

  public function handle()
  {
    $name = $this->argument('name');
    $responsePath = base_path("app/Http/Responses/{$name}Response.php");

    if (File::exists($responsePath)) {
      $this->error("Response class {$name} already exists!");
      return;
    }

    $template = "<?php\n\nnamespace App\Http\Responses;\n\nclass {$name}Response\n{\n    protected \$data;\n\n    public function __construct(\$data)\n    {\n        \$this->data = \$data;\n    }\n\n    public function toArray()\n    {\n        return [\n            'data' => \$this->data,\n            'status' => 'success',\n        ];\n    }\n}\n";

    File::put($responsePath, $template);

    $this->info("Response class {$name} created successfully at {$responsePath}");
  }
}
