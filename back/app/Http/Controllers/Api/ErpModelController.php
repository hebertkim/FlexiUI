<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ErpModelController extends Controller
{
    public function gerarModels(Request $request)
    {
        // Validar dados de conexão enviados pelo frontend (host, database, user, etc)
        $data = $request->validate([
            'host' => 'required|string',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'port' => 'nullable|integer',
        ]);

        $connectionName = 'dynamic_erp_conn';

        // Configura a conexão dinâmica
        config([
            "database.connections.{$connectionName}" => [
                'driver' => 'mysql',
                'host' => $data['host'],
                'port' => $data['port'] ?? 3306,
                'database' => $data['database'],
                'username' => $data['username'],
                'password' => $data['password'] ?? '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => false,
                'engine' => null,
            ]
        ]);

        try {
            $conn = DB::connection($connectionName);

            // Testar conexão
            $conn->getPdo();

            // Buscar todas as tabelas
            $tables = $conn->select('SHOW TABLES');
            $tableNames = array_map(fn($t) => array_values((array)$t)[0], $tables);

            foreach ($tableNames as $tableName) {
                $columns = $conn->select("SHOW COLUMNS FROM `$tableName`");

                $modelContent = $this->gerarModelPHP($tableName, $columns);

                $modelName = Str::studly(Str::singular($tableName));
                $modelPath = app_path("Models/{$modelName}.php");

                if (!is_dir(app_path('Models'))) {
                    mkdir(app_path('Models'), 0755, true);
                }

                file_put_contents($modelPath, $modelContent);
            }

            return response()->json(['success' => true, 'message' => 'Models gerados com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro: ' . $e->getMessage()], 500);
        }
    }

    private function gerarModelPHP($table, $columns)
    {
        $className = Str::studly(Str::singular($table));

        $fillableFields = [];
        foreach ($columns as $col) {
            $fillableFields[] = "'" . $col->Field . "'";
        }
        $fillable = implode(', ', $fillableFields);

        return <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class {$className} extends Model
{
    protected \$table = '{$table}';
    protected \$fillable = [{$fillable}];
    public \$timestamps = false;
}
EOD;
    }
}
