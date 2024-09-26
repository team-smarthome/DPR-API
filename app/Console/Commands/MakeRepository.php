<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepository extends Command
{
  protected $signature = 'make:repository {name}';
  protected $description = 'Create a new repository with an interface';

  public function handle()
  {
    $name = $this->argument('name');

    $interfaceDir = base_path('app/Repositories/Interfaces');
    $repositoryDir = base_path('app/Repositories/Implementations');
    $interfaceName = "{$name}RepositoryInterface.php";
    $repositoryName = "{$name}Repository.php";

    if (!is_dir($interfaceDir)) {
      mkdir($interfaceDir, 0755, true);
    }

    if (!is_dir($repositoryDir)) {
      mkdir($repositoryDir, 0755, true);
    }

    file_put_contents($interfaceDir . '/' . $interfaceName, $this->getInterfaceTemplate($name));
    file_put_contents($repositoryDir . '/' . $repositoryName, $this->getRepositoryTemplate($name));

    $this->addBindingToServiceProvider($name);

    $this->info("Repository {$name} created successfully.");
  }

  protected function getInterfaceTemplate($name)
  {
    return "<?php\n\nnamespace App\Repositories\Interfaces;\n\nuse App\Models\\{$name};\n\ninterface {$name}RepositoryInterface\n{\n    public function create(array \$data): {$name};\n    public function get(): array;\n    public function getById(string \$id): ?{$name};\n    public function update(string \$id, array \$data): ?{$name};\n    public function delete(string \$id): bool;\n}\n";
  }

  protected function getRepositoryTemplate($name)
  {
    return "<?php\n\nnamespace App\Repositories\Implementations;\n\nuse App\Models\\{$name};\nuse App\Repositories\Interfaces\\{$name}RepositoryInterface;\n\nclass {$name}Repository implements {$name}RepositoryInterface\n{\n    public function create(array \$data): {$name}\n    {\n        return {$name}::create(\$data);\n    }\n\n    public function get(): array\n    {\n        return {$name}::all()->toArray();\n    }\n\n    public function getById(string \$id): ?{$name}\n    {\n        return {$name}::find(\$id);\n    }\n\n    public function update(string \$id, array \$data): ?{$name}\n    {\n        \$model = {$name}::find(\$id);\n        if (\$model) {\n            \$model->update(\$data);\n            return \$model;\n        }\n        return null;\n    }\n\n    public function delete(string \$id): bool\n    {\n        \$model = {$name}::find(\$id);\n        return \$model ? \$model->delete() : false;\n    }\n}\n";
  }
  protected function addBindingToServiceProvider($name)
  {
    $serviceProviderPath = base_path('app/Providers/AppServiceProvider.php');

    $content = file_get_contents($serviceProviderPath);

    $bindingTemplate = "\$this->app->bind(App\Repositories\Interfaces\\{$name}RepositoryInterface::class, App\Repositories\Implementations\\{$name}Repository::class);\n";

    if (strpos($content, $bindingTemplate) === false) {

      $insertPosition = strpos($content, 'public function register()') + strlen('public function register()') + 1;

      $newContent = substr_replace($content, $bindingTemplate, $insertPosition, 0);

      file_put_contents($serviceProviderPath, $newContent);
      $this->info("Binding added to AppServiceProvider.");
    } else {
      $this->info("Binding already exists in AppServiceProvider.");
    }
  }
}
