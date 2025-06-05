<?php

namespace App\Services;

use App\Models\ErpConnection;
use Illuminate\Support\Facades\DB;
use Exception;

class ErpConnectionService
{
    public static function configurarConexao($connectionId)
    {
        $conexao = ErpConnection::findOrFail($connectionId);

        // Descriptografa a senha antes de usar
        $password = null;
        if (!empty($conexao->password)) {
            try {
                $password = decrypt($conexao->password);
            } catch (Exception $e) {
                $password = null; // Falha na descriptografia, usa null
            }
        }

        // Define dinamicamente a conexão 'erp_dynamic'
        config([
            'database.connections.erp_dynamic' => [
                'driver' => $conexao->tipo_banco,
                'host' => $conexao->host,
                'port' => $conexao->porta,
                'database' => $conexao->database,
                'username' => $conexao->username,
                'password' => $password,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
                'strict' => false,
            ],
        ]);

        // Testa a conexão
        try {
            DB::connection('erp_dynamic')->getPdo();
            return [
                'success' => true,
                'message' => 'Conexão realizada com sucesso.',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao conectar ao banco ERP: ' . $e->getMessage(),
            ];
        }
    }

    public static function gerarMigrationsAutomaticas(): array
    {
        try {
            $connection = DB::connection('erp_dynamic');

            $database = $connection->getDatabaseName();

            $tabelasRaw = $connection->select('SHOW TABLES');
            $tabelaKey = 'Tables_in_' . $database;
            $tabelas = array_map(fn($item) => $item->$tabelaKey, $tabelasRaw);

            $migrations = [];

            foreach ($tabelas as $tabela) {
                $colunas = $connection->select("
                    SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_KEY, EXTRA, CHARACTER_MAXIMUM_LENGTH
                    FROM information_schema.columns 
                    WHERE table_schema = ? AND table_name = ?
                    ORDER BY ORDINAL_POSITION
                ", [$database, $tabela]);

                $migration = "<?php\n\nuse Illuminate\\Database\\Migrations\\Migration;\nuse Illuminate\\Database\\Schema\\Blueprint;\nuse Illuminate\\Support\\Facades\\Schema;\n\n";
                $migration .= "return new class extends Migration {\n";
                $migration .= "    public function up()\n    {\n";
                $migration .= "        Schema::create('{$tabela}', function (Blueprint \$table) {\n";

                foreach ($colunas as $col) {
                    $nullable = $col->IS_NULLABLE === 'YES' ? '->nullable()' : '';
                    $primary = $col->COLUMN_KEY === 'PRI' ? '->primary()' : '';
                    $autoIncrement = strpos($col->EXTRA, 'auto_increment') !== false ? '->autoIncrement()' : '';

                    $tipo = match ($col->DATA_TYPE) {
                        'int', 'integer' => 'integer',
                        'bigint' => 'bigInteger',
                        'varchar' => 'string',
                        'char' => 'char',
                        'text' => 'text',
                        'datetime' => 'dateTime',
                        'date' => 'date',
                        'timestamp' => 'timestamp',
                        'decimal' => 'decimal',
                        'float' => 'float',
                        'double' => 'double',
                        'boolean', 'tinyint' => 'boolean',
                        default => 'string',
                    };

                    if (in_array($tipo, ['string', 'char']) && $col->CHARACTER_MAXIMUM_LENGTH) {
                        $migration .= "            \$table->{$tipo}('{$col->COLUMN_NAME}', {$col->CHARACTER_MAXIMUM_LENGTH}){$nullable}{$primary}{$autoIncrement};\n";
                    } elseif ($tipo === 'decimal') {
                        $migration .= "            \$table->decimal('{$col->COLUMN_NAME}', 8, 2){$nullable}{$primary}{$autoIncrement};\n";
                    } else {
                        $migration .= "            \$table->{$tipo}('{$col->COLUMN_NAME}'){$nullable}{$primary}{$autoIncrement};\n";
                    }
                }

                $migration .= "        });\n    }\n\n";
                $migration .= "    public function down()\n    {\n";
                $migration .= "        Schema::dropIfExists('{$tabela}');\n";
                $migration .= "    }\n";
                $migration .= "};\n";

                $migrations[$tabela] = $migration;
            }

            return $migrations;
        } catch (Exception $e) {
            return ['error' => 'Erro ao gerar migrations: ' . $e->getMessage()];
        }
    }
}
