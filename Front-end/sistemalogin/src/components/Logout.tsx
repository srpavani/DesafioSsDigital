import React from 'react';
import { useNavigate } from 'react-router-dom';
import './logout.css'

const API = process.env.REACT_APP_API_URL; 
const Logout: React.FC = () => {
    const navigate = useNavigate();

    const handleLogout = async () => {
        try {
            
            const response = await fetch(`${API}/logout.php`, {
                method: 'GET',
                credentials: 'include', 
            });

            const data = await response.json();

            if (data.success) {
            
                localStorage.removeItem('isAuthenticated');
                localStorage.removeItem('userEmail');

                navigate('/login');
            } else {
                console.error('Erro ao efetuar logout:', data.message);
            }
        } catch (error) {
            console.error('Erro na requisição de logout:', error);
        }
    };

    return (
        <button className="logout-button" onClick={handleLogout}>Logout</button>
    );
};

export default Logout;
