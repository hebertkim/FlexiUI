<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GerarModelsErp extends Command
{
    protected $signature = 'erp:gerar-models {--connection=erp_temp}';
    protected $description = 'Gera models dinamicamente com base nas tabelas da conexão ERP';

    public function handle()
    {
        $connection = $this->option('connection');

        // Obter o nome do banco de dados da conexão
        $database = DB::connection($connection)->getDatabaseName();

        // Buscar todas as tabelas
        $tables = DB::connection($connection)->select('SHOW TABLES');
        $key = 'Tables_in_' . $database;

        // Pasta de destino
        $dir = app_path('Models'); // -> salvará em C:\laragon\www\FlexiUI\back\app\Models

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        foreach ($tables as $table) {
            $tableName = $table->$key;
            $className = Str::studly(Str::singular($tableName));
            $filePath = $dir . '/' . $className . '.php';

            // Conteúdo do model
            $content = "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class $className extends Model
{
    protected \$connection = '$connection';
    protected \$table = '$tableName';
    public \$timestamps = false;
}
";
            // Salvar o arquivo
            file_put_contents($filePath, $content);
            $this->info("Model $className criado.");
        }

        $this->info("✅ Todos os models foram gerados com sucesso em app/Models.");
    }
}
