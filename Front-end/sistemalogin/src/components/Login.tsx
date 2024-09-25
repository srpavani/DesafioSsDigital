import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { login } from '../services/authService'; 
import './Login.css';

const Login: React.FC = () => {
    const [email, setEmail] = useState<string>('');
    const [password, setPassword] = useState<string>('');
    const [errorMessage, setErrorMessage] = useState<string>('');
    const navigate = useNavigate(); 

    
    const handleLogin = async (e: React.FormEvent) => {
        e.preventDefault();

        try {
        
            const response = await login(email, password);

            if (response.logado) {
                localStorage.setItem('isAuthenticated', 'true');
                localStorage.setItem('userEmail', response.user.email);
                navigate('/welcome');
            } else {
                setErrorMessage('Email ou senha incorretos.');
            }
        } catch (error) {
            setErrorMessage('Erro ao fazer login. Tente novamente mais tarde.');
        }
    };

    return (
        <div className="login-container">
            <h2>Login</h2>
            {errorMessage && <p className="error-message">{errorMessage}</p>}

            <form className="login-form" onSubmit={handleLogin}>
                <div>
                    <label>Email:</label>
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)} 
                        required
                    />
                </div>
                <div>
                    <label>Senha:</label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        required
                    />
                </div>
                <button type="submit">Entrar</button>
            </form>
        </div>
    );
};

export default Login;
