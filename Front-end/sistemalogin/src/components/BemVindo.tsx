import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Logout from './Logout';
import './bemvindo.css';

const API = process.env.REACT_APP_API_URL;

const Welcome: React.FC = () => {
    const [connectedSince, setConnectedSince] = useState<string>('');  
    const [firstName, setFirstName] = useState<string>(''); 
    const navigate = useNavigate();

    useEffect(() => {
        const isAuthenticated = localStorage.getItem('isAuthenticated');
        const userEmail = localStorage.getItem('userEmail'); 

        if (!isAuthenticated) {
            navigate('/login');
        } else {
            if (userEmail) {
                const name = getFirstNameFromEmail(userEmail);
                setFirstName(name);
            }
            fetchSessionTime();
        }
    }, [navigate]);

    const getFirstNameFromEmail = (email: string) => {
        return email.split('@')[0]; 
    };

   
    const formatDate = (timestamp: number) => { // funcao para formatar o timestamp para dia/mês/ano às horas e minutos
        const date = new Date(timestamp * 1000);
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');

        return `${day}/${month}/${year} às ${hours}:${minutes}`;
    };

    const fetchSessionTime = async () => {
        try {
            const response = await fetch(`${API}/tempoSession.php`, {
                method: 'GET',
                credentials: 'include',
            });

            const data = await response.json();

            if (data.logado) {
                const formattedDate = formatDate(data.session_start_time);
                setConnectedSince(formattedDate); 
            } else {
                setConnectedSince(data.message);
            }
        } catch (error) {
            console.error('Erro ao buscar o tempo da sessão:', error);
        }
    };

    return (
        <div className="bemvindo-container">
            <h2 className="bemvindo-message">Bem-vindo, {firstName}!</h2>
            <p className="session-time">Você está conectado desde: {connectedSince}</p>
            <Logout />
        </div>
    );
};

export default Welcome;
