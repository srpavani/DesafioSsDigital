import { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';

const API = process.env.REACT_APP_API_URL;

const AtivarConta = () => {
    const { token } = useParams();  
    const [message, setMessage] = useState('');
    const navigate = useNavigate();  

    useEffect(() => {
        const ativarConta = async () => {
            if (token) {
                try {
                    const response = await fetch(`${API}/ativar_conta.php?token=${token}`);
                    if (!response.ok) {
                        throw new Error('Erro ao ativar a conta');
                    }
                    const data = await response.json();
                    setMessage(data.message);

                    
                    if (data.status === 'success') {
                        alert("ATIVADO COM SUCESSO");
                        navigate('/login');  
                    }
                } catch (error) {
                    setMessage('Erro ao ativar a conta. Por favor, tente novamente.');
                }
            } else {
                setMessage('Token não encontrado.');
            }
        };

        ativarConta();
    }, [token, navigate]);

    return (
        <div>
            <h1>{message}</h1>
        </div>
    );
};

export default AtivarConta;
