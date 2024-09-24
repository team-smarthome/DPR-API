<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MakeModelCommand extends Command
{
    protected $signature = 'make:model {name}';
    protected $description = 'Create a new model class';

    public function handle()
    {
        $name = $this->argument('name');
        $modelPath = base_path("app/Models/{$name}.php");

        if (File::exists($modelPath)) {
            $this->error("Model {$name} already exists!");
            return;
        }

        $template = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass {$name} extends Model\n{\n    //\n}\n";

        File::put($modelPath, $template);

        $this->info("Model {$name} created successfully at {$modelPath}");
    }
}
