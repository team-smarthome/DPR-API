<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeControllerCommand extends Command
{
    protected $signature = 'make:controller {name}';
    protected $description = 'Create a new controller class';

    public function handle()
    {
        $name = $this->argument('name');
        $controllerPath = base_path("app/Http/Controllers/{$name}Controller.php");

        if (File::exists($controllerPath)) {
            $this->error("Controller {$name} already exists!");
            return;
        }

        $template = "<?php\n\nnamespace App\Http\Controllers;\n\nuse App\Models\\{$name};\nuse Illuminate\Http\Request;\n\nclass {$name}Controller extends Controller\n{\n    public function index()\n    {\n        return {$name}::all();\n    }\n\n    public function show(\$id)\n    {\n        return {$name}::find(\$id);\n    }\n\n    public function store(Request \$request)\n    {\n        return {$name}::create(\$request->all());\n    }\n\n    public function update(Request \$request, \$id)\n    {\n        \$model = {$name}::find(\$id);\n        \$model->update(\$request->all());\n        return \$model;\n    }\n\n    public function destroy(\$id)\n    {\n        return {$name}::destroy(\$id);\n    }\n}\n";

        File::put($controllerPath, $template);

        $this->info("Controller {$name} created successfully at {$controllerPath}");
    }
}
