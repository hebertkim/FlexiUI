<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ErpConnection;
use App\Services\ErpConnectionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ErpConnectionController extends Controller
{
    public function index()
    {
        Log::info('Listando todas as conexoes ERP');

        $conexoes = ErpConnection::all();

        foreach ($conexoes as $conexao) {
            if ($conexao->password) {
                try {
                    $conexao->password = decrypt($conexao->password);
                } catch (\Exception $e) {
                    Log::warning("Falha ao descriptografar senha da conexao ID {$conexao->id}: " . $e->getMessage());
                    $conexao->password = null;
                }
            }
        }

        return response()->json($conexoes);
    }

    public function store(Request $request)
    {
        Log::info('Criando ou atualizando conexao ERP');

        $validated = $request->validate([
            'nome_conexao' => 'required|string',
            'tipo_banco' => 'required|string',
            'host' => 'required|string',
            'porta' => 'required|integer',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = encrypt($validated['password']);
        }

        $conexao = ErpConnection::updateOrCreate(
            ['id' => 1],
            $validated
        );

        Log::info("Conexao ERP criada/atualizada com ID {$conexao->id}");

        return response()->json($conexao, 200);
    }

    public function show($id)
    {
        Log::info("Buscando conexao ERP ID {$id}");

        $erp = ErpConnection::findOrFail($id);

        if ($erp->password) {
            try {
                $erp->password = decrypt($erp->password);
            } catch (\Exception $e) {
                Log::warning("Falha ao descriptografar senha da conexao ID {$id}: " . $e->getMessage());
                $erp->password = null;
            }
        }

        return response()->json($erp);
    }

    public function update(Request $request, $id)
    {
        Log::info("Atualizando conexao ERP ID {$id}");

        $erp = ErpConnection::findOrFail($id);
        $data = $request->all();

        if (isset($data['password'])) {
            if (!empty($data['password'])) {
                $data['password'] = encrypt($data['password']);
            } else {
                unset($data['password']);
            }
        }

        $erp->update($data);

        Log::info("Conexao ERP ID {$id} atualizada com sucesso");

        return response()->json(['success' => true, 'data' => $erp]);
    }

    public function destroy($id)
    {
        Log::info("Deletando conexao ERP ID {$id}");

        $erp = ErpConnection::findOrFail($id);
        $erp->delete();

        Log::info("Conexao ERP ID {$id} deletada");

        return response()->json(['success' => true]);
    }

    public function conectar(Request $request)
    {
        Log::info('Tentativa de conexão dinâmica iniciada');

        $validated = $request->validate([
            'connection_id' => 'required|integer|exists:erp_connections,id',
        ]);

        $result = ErpConnectionService::configurarConexao($validated['connection_id']);

        if (!$result['success']) {
            Log::error('Falha na configuração da conexão dinâmica: ' . ($result['message'] ?? 'Sem mensagem'));
            return response()->json($result, 500);
        }

        try {
            $tabelas = DB::connection('erp_dynamic')->select('SHOW TABLES');
            $listaTabelas = array_map(fn($item) => array_values((array)$item)[0], $tabelas);

            Log::info('Conexão dinâmica estabelecida com sucesso. Tabelas encontradas: ' . implode(', ', $listaTabelas));

            return response()->json([
                'success' => true,
                'message' => 'Conectado com sucesso.',
                'tabelas' => $listaTabelas,
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao conectar no banco dinâmico: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function gerarMigrations(Request $request)
    {
        Log::info('Iniciando geração automática de migrations');

        $validated = $request->validate([
            'connection_id' => 'required|integer|exists:erp_connections,id',
        ]);

        // Configure dinamicamente a conexão
        $result = ErpConnectionService::configurarConexao($validated['connection_id']);

        if (!$result['success']) {
            Log::error('Falha ao configurar conexão dinâmica: ' . ($result['message'] ?? 'Sem mensagem'));
            return response()->json($result, 500);
        }

        try {
            $resultadoGeracao = $this->gerarMigrationsAutomaticas();

            if (!$resultadoGeracao['success']) {
                Log::error('Erro ao gerar migrations: ' . ($resultadoGeracao['message'] ?? 'Mensagem não informada'));
                return response()->json([
                    'success' => false,
                    'message' => $resultadoGeracao['message'] ?? 'Erro ao gerar migrations.'
                ], 400);
            }

            $migrations = $resultadoGeracao['migrations'];

            Log::info('Migrations geradas, iniciando salvamento dos arquivos');

            $resultadoSalvamento = $this->salvarMigrationsEmArquivos($migrations);

            foreach ($resultadoSalvamento as $tabela => $resultado) {
                if ($resultado['success']) {
                    Log::info("Migration da tabela '{$tabela}' salva com sucesso.");
                } else {
                    Log::warning("Erro ao salvar migration da tabela '{$tabela}': " . $resultado['message']);
                }
            }

            return response()->json([
                'success' => true,
                'migrations' => array_keys($migrations),
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao gerar migrations: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function gerarMigrationsAutomaticas()
    {
        Log::info('Iniciando processo interno de geração das migrations');

        try {
            $connection = DB::connection('erp_dynamic');
            $database = $connection->getDatabaseName();

            $tabelasRaw = $connection->select('SHOW TABLES');

            if (empty($tabelasRaw)) {
                Log::warning('Nenhuma tabela encontrada no banco dinâmico.');
                return ['success' => false, 'message' => 'Nenhuma tabela encontrada.'];
            }

            $tabelaKey = array_key_first((array) $tabelasRaw[0]);
            $tabelas = array_map(fn($item) => $item->$tabelaKey, $tabelasRaw);

            Log::info('Tabelas encontradas para gerar migrations: ' . implode(', ', $tabelas));

            $migrations = [];

            foreach ($tabelas as $tabela) {
                $colunas = $connection->select("
                    SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_KEY, EXTRA, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE
                    FROM information_schema.columns 
                    WHERE table_schema = ? AND table_name = ?
                    ORDER BY ORDINAL_POSITION
                ", [$database, $tabela]);

                if (empty($colunas)) {
                    Log::warning("Tabela {$tabela} não possui colunas.");
                    continue;
                }

                $migration = "<?php\n\n";
                $migration .= "use Illuminate\\Database\\Migrations\\Migration;\n";
                $migration .= "use Illuminate\\Database\\Schema\\Blueprint;\n";
                $migration .= "use Illuminate\\Support\\Facades\\Schema;\n\n";
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

                    $linha = "            \$table->{$tipo}('{$col->COLUMN_NAME}'";

                    if (in_array($tipo, ['string', 'char']) && $col->CHARACTER_MAXIMUM_LENGTH) {
                        $linha .= ", {$col->CHARACTER_MAXIMUM_LENGTH}";
                    } elseif ($tipo === 'decimal' && $col->NUMERIC_PRECISION !== null && $col->NUMERIC_SCALE !== null) {
                        $linha .= ", {$col->NUMERIC_PRECISION}, {$col->NUMERIC_SCALE}";
                    }

                    $linha .= ")";

                    if ($primary) {
                        $linha .= "->primary()";
                    }

                    if ($autoIncrement) {
                        $linha .= "->autoIncrement()";
                    }

                    if ($nullable && !$primary) { // primary keys usually not nullable
                        $linha .= "->nullable()";
                    }

                    $linha .= ";";

                    $migration .= $linha . "\n";
                }

                $migration .= "        });\n";
                $migration .= "    }\n\n";
                $migration .= "    public function down()\n    {\n";
                $migration .= "        Schema::dropIfExists('{$tabela}');\n";
                $migration .= "    }\n";
                $migration .= "};\n";

                $migrations[$tabela] = $migration;
            }

            Log::info('Geração de migrations concluída com sucesso.');

            return ['success' => true, 'migrations' => $migrations];
        } catch (\Throwable $e) {
            Log::error('Erro ao gerar migrations: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function salvarMigrationsEmArquivos(array $migrations)
    {
        Log::info('Salvando arquivos de migrations');

        $resultado = [];

        $pathBase = database_path('migrations/auto_generated');

        if (!file_exists($pathBase)) {
            mkdir($pathBase, 0755, true);
            Log::info("Criado diretório para migrations em: {$pathBase}");
        }

        foreach ($migrations as $tabela => $conteudo) {
            $nomeArquivo = $pathBase . '/' . date('Y_m_d_His') . "_create_{$tabela}_table.php";

            try {
                file_put_contents($nomeArquivo, $conteudo);
                $resultado[$tabela] = ['success' => true, 'file' => $nomeArquivo];
            } catch (\Throwable $e) {
                $resultado[$tabela] = ['success' => false, 'error' => $e->getMessage()];
            }
        }

        Log::info('Salvamento dos arquivos finalizado');

        return $resultado;
    }
}
