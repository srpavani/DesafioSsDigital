document.addEventListener('DOMContentLoaded', function () {
    const API_URL = 'http://localhost:8080/ProjetoSSdigital/DesafioSsDigital/Back-end';


    function loadSessionInfo() {
        fetch(`${API_URL}/tempoSession.php`, {
            method: 'GET',
            credentials: 'include'
        })
        .then(response => response.json())
        .then(data => {
            if (data.logado) {
                const connectedSince = new Date(data.session_start_time * 1000).toLocaleString();
                document.getElementById('welcomeMessage').innerText = `Você está conectado desde: ${connectedSince}`;
            } else {
                window.location.href = 'index.html';  // Redirecionar se não estiver logado
            }
        })
        .catch(error => {
            console.error('Erro ao buscar o tempo de sessão:', error);
            window.location.href = 'index.html'; // Redirecionar em caso de erro
        });
    }

    // Funcao para registrar um usuário
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch(`${API_URL}/registrar.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password }),
            });

            const data = await response.json();
            document.getElementById('registerMessage').innerText = data.message;
        });
    }

    // Funcao para fazer login
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch(`${API_URL}/login.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password }),
            });

            const data = await response.json();
            if (data.logado) {
                window.location.href = 'welcome.html';
            } else {
                document.getElementById('loginMessage').innerText = data.message;
            }
        });
    }

    // Funcao para ativa conta automaticamente usando token da URL email
    function activateAccount() {
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token'); 

        if (token) {
            fetch(`${API_URL}/ativar_conta.php?token=${token}`, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('activationMessage').innerText = data.message;
                if (data.status === 'success') {
                    setTimeout(() => {
                        window.location.href = 'index.html';  
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Erro ao ativar a conta:', error);
                document.getElementById('activationMessage').innerText = 'Erro ao ativar a conta. Tente novamente mais tarde.';
            });
        } else {
            document.getElementById('activationMessage').innerText = 'Token de ativação não encontrado.';
        }
    }

    // Funcao para fazer logout
    const logoutButton = document.getElementById('logoutButton');
    if (logoutButton) {
        logoutButton.addEventListener('click', async function() {
            try {
                const response = await fetch(`${API_URL}/logout.php`, {
                    method: 'GET',
                    credentials: 'include',
                });

                const data = await response.json();
                if (data.success) {
                    window.location.href = 'index.html';
                } else {
                    console.error('Erro ao fazer logout:', data.message);
                }
            } catch (error) {
                console.error('Erro na requisição de logout:', error);
            }
        });
    }

    if (document.getElementById('welcomeMessage')) {
        loadSessionInfo();
    }

    
    if (document.getElementById('activationMessage')) {
        activateAccount();// Se estiver na pagina de ativação, ativar conta automaticamente
    }
});
