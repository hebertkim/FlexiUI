<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50">
        <!-- Conectar ao ERP Card -->
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Conectar ao Banco ERP</h2>

            <form @submit.prevent="onSubmit">
                <div class="mb-6">
                    <label for="connection" class="block mb-1 text-sm font-medium text-gray-700">Selecione a
                        conexão</label>
                    <select id="connection" v-model="selectedConnection" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300">
                        <option value="" disabled>-- Escolha uma conexão --</option>
                        <option v-for="conn in connections" :key="conn.id" :value="conn.id">
                            {{ conn.nome_conexao }}
                        </option>
                    </select>
                </div>

                <button type="submit" :disabled="!selectedConnection || loading"
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 disabled:bg-blue-300 focus:outline-none focus:ring focus:ring-blue-300">
                    {{ loading ? 'Conectando...' : 'Conectar' }}
                </button>
                <button v-if="selectedConnection && !loading" @click="gerarMigrations"
                    class="w-full px-4 py-2 mt-4 text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-300">
                    Gerar Migrations
                </button>

                <p v-if="errorMessage" class="mt-4 text-sm text-red-600">{{ errorMessage }}</p>
                <p v-if="successMessage" class="mt-4 text-sm text-green-600">{{ successMessage }}</p>

                <div v-if="tables.length" class="mt-6">
                    <h3 class="mb-2 text-lg font-semibold text-gray-700">Tabelas encontradas:</h3>
                    <ul class="text-sm text-gray-600 list-disc list-inside">
                        <li v-for="(table, index) in tables" :key="index">{{ table }}</li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import api from '@/services/api'; // seu axios/serviço HTTP configurado

export default {
    name: 'ErpConnectionSelect',

    data() {
        return {
            connections: [],
            selectedConnection: '',
            loading: false,
            errorMessage: '',
            successMessage: '',
            tables: [],
        };
    },

    async created() {
        try {
            const response = await api.get('/erp-connections'); // endpoint para listar conexões
            this.connections = response.data;
        } catch (error) {
            this.errorMessage = 'Erro ao carregar conexões.';
            console.error(error);
        }
    },

    methods: {
        async onSubmit() {
            if (!this.selectedConnection) return;

            this.loading = true;
            this.errorMessage = '';
            this.successMessage = '';
            this.tables = [];

            try {
                const response = await api.post('/erp-connect', { connection_id: this.selectedConnection });
                if (response.data.success) {
                    this.successMessage = 'Conectado com sucesso ao banco ERP!';
                    this.tables = response.data.tabelas || [];
                } else {
                    this.errorMessage = response.data.message || 'Erro desconhecido.';
                }
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Falha ao conectar.';
            } finally {
                this.loading = false;
            }
        },

        async gerarMigrations() {
            try {
                const response = await api.post('/gerar-migrations', {
                    connection_id: this.selectedConnection
                });

                if (response.data.success) {
                    console.log('Migrations geradas:', response.data.migrations);
                    alert('Migrations geradas com sucesso!');
                    // Se quiser salvar no state:
                    // this.migrations = response.data.migrations;
                } else {
                    alert('Erro: ' + response.data.message);
                }
            } catch (error) {
                console.error('Erro ao chamar API:', error.response?.data || error.message);
                alert('Erro ao gerar migrations.');
            }
        }
    }
};
</script>

<style scoped>
/* Você pode adicionar estilos extras se quiser */
</style>
