import React from 'react';
import { Navigate } from 'react-router-dom';

const PrivateRoute = ({ element }: { element: JSX.Element }) => {
    const isAuthenticated = localStorage.getItem('isAuthenticated') === 'true';

    return isAuthenticated ? element : <Navigate to="/login" />;
};

export default PrivateRoute;