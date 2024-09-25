import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom'; 
import { register } from '../services/authService';
import './register.css';  

const Register: React.FC = () => {
    const [email, setEmail] = useState<string>('');
    const [password, setPassword] = useState<string>('');
    const [message, setMessage] = useState<string>('');
    const navigate = useNavigate();

    const handleRegister = async (e: React.FormEvent) => {
        e.preventDefault();
        
        try {
            const response = await register(email, password);

            if (response?.status === 'success') {
                alert('Registro bem-sucedido! Verifique seu email para ativar sua conta.');
                navigate('/login'); 
            } else {
                setMessage(response?.message || 'Erro no registro.');
            }
        } catch (error) {
            console.error('Erro ao registrar:', error);
            setMessage('Erro no registro. Tente novamente.');
        }
    };

    return (
        <div className="register-container">
            <h2>Registrar</h2>
            <form onSubmit={handleRegister} className="register-form">
                <label>Email:</label>
                <input 
                    type="email" 
                    value={email} 
                    onChange={(e) => setEmail(e.target.value)} 
                    required 
                />
                <label>Senha:</label>
                <input 
                    type="password" 
                    value={password} 
                    onChange={(e) => setPassword(e.target.value)} 
                    required 
                />
                <button type="submit">Registrar</button>
            </form>
            <p className="message">{message}</p>
        </div>
    );
};

export default Register;
