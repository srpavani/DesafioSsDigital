import React from 'react';
import { BrowserRouter as Router, Route, Routes, Navigate } from 'react-router-dom';
import Login from './components/Login';
import Welcome from './components/BemVindo';
import Register from './components/Register';
import AtivarConta from './components/AtivarConta';
import PrivateRoute from './components/PrivateRoute'; 

const App: React.FC = () => {
    return (
        <Router>
            <Routes>
                <Route path="/login" element={<Login />} />
                <Route path="/register" element={<Register />} />
                <Route path="/ativar/:token" element={<AtivarConta />} /> 
                <Route path="/welcome" element={<PrivateRoute element={<Welcome />} />} />
                <Route path="*" element={<Navigate to="/login" />} />
            </Routes>
        </Router>
    );
};

export default App;
