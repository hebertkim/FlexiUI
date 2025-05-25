import axios from 'axios'; // Adicione o ponto e vírgula no final da linha de importação

const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    timeout: 5000,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content // Enviar token CSRF
    },
});

// Adicionar o token de autenticação nas requisições
api.interceptors.request.use((config) => {
    const token = localStorage.getItem("authToken"); // Obtém o token do localStorage
    if (token) {
        config.headers.Authorization = `Bearer ${token}`; // Envia o token no cabeçalho Authorization
    }
    return config;
}, (error) => {
    return Promise.reject(error);
});

// Resposta de erro global (caso precise tratar de erro)
api.interceptors.response.use(
    (response) => response,
    (error) => {
        // Se o token expirar ou for inválido, remover e redirecionar para login
        if (error.response && error.response.status === 401) {
            localStorage.removeItem("authToken");
            // Redirecionar para a página de login, ou outra ação
            window.location.href = "/login";
        }
        return Promise.reject(error);
    }
);

export default api;
