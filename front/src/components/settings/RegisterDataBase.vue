<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50">
        <!-- Cadastro Conexão Card -->
        <div class="w-full max-w-4xl p-6 bg-white rounded-lg shadow-md">

            <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Cadastrar Conexão ERP</h2>

            <!-- Form -->
            <form @submit.prevent="onSubmit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="nome_conexao" class="block mb-1 text-sm font-medium text-gray-700">Nome da
                            Conexão</label>
                        <input id="nome_conexao" v-model="nome_conexao" type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                            placeholder="Ex: Conexão Cliente XYZ" required />
                    </div>

                    <div>
                        <label for="tipo_banco" class="block mb-1 text-sm font-medium text-gray-700">Tipo do
                            Banco</label>
                        <select id="tipo_banco" v-model="tipo_banco"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                            required>
                            <option disabled value="">Selecione o tipo do banco</option>
                            <option value="mysql">MySQL</option>
                            <option value="pgsql">PostgreSQL</option>
                            <option value="sqlsrv">SQL Server</option>
                        </select>
                    </div>

                    <div>
                        <label for="host" class="block mb-1 text-sm font-medium text-gray-700">Host</label>
                        <input id="host" v-model="host" type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                            placeholder="Ex: 192.168.0.100 ou localhost" required />
                    </div>

                    <div>
                        <label for="porta" class="block mb-1 text-sm font-medium text-gray-700">Porta</label>
                        <input id="porta" v-model="porta" type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                            placeholder="Ex: 3306" required />
                    </div>

                    <div>
                        <label for="database" class="block mb-1 text-sm font-medium text-gray-700">Nome do Banco</label>
                        <input id="database" v-model="database" type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                            placeholder="Nome do banco de dados ERP" required />
                    </div>

                    <div>
                        <label for="username" class="block mb-1 text-sm font-medium text-gray-700">Usuário</label>
                        <input id="username" v-model="username" type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                            placeholder="Usuário do banco de dados" required />
                    </div>

                    <div class="md:col-span-2">
                        <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Senha</label>
                        <input id="password" v-model="password" type="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                            placeholder="Senha do banco de dados" />
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full px-4 py-2 mb-4 text-white bg-gray-500 rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring focus:ring-red-300">
                    Salvar Conexão
                </button>
            </form>
        </div>
    </div>
</template>


<script>
import api from '@/services/api';

export default {
    name: 'ErpConnectionForm',

    data() {
        return {
            nome_conexao: '',
            tipo_banco: '',
            host: '',
            porta: '',
            database: '',
            username: '',
            password: '',
        };
    },

    methods: {
        async onSubmit() {
            const formData = {
                nome_conexao: this.nome_conexao,
                tipo_banco: this.tipo_banco,
                host: this.host,
                porta: this.porta,
                database: this.database,
                username: this.username,
                password: this.password.trim(),

            };

            try {
                const response = await api.post('/erp-connections', formData);
                if (response.status === 200 || response.status === 201) {
                    alert('Conexão salva com sucesso!');
                    this.resetForm();
                }
            } catch (error) {
                console.error('Erro ao salvar conexão:', error);
                alert('Erro ao salvar conexão. Verifique os dados e tente novamente.');
            }
        },

        resetForm() {
            this.nome_conexao = '';
            this.tipo_banco = '';
            this.host = '';
            this.porta = '';
            this.database = '';
            this.username = '';
            this.password = '';
        },
    },
};
</script>

<style scoped>
/* adicione estilos extras, se precisar */
</style>
