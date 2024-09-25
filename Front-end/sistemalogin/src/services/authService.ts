
const API = process.env.REACT_APP_API_URL 

export const login = async (email: string, password: string) => {
    try {
        const response = await fetch(`${API}/login.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'include',
            body: JSON.stringify({ email, password }),
        });

        if (!response.ok) {
            throw new Error('Erro ao fazer login.');
        }

        return await response.json();
    } catch (error) {
        console.error('Erro na requisição:', error);
        throw error;
    }
};


export const register = async (email: string, password: string) => {
    const response = await fetch(`${API}/registrar.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ email, password }),
    });

    if (!response.ok) {
        const errorDetail = await response.text();
        throw new Error(`Erro ao fazer registro: ${response.status} - ${errorDetail}`);
    }

    return await response.json();
};
