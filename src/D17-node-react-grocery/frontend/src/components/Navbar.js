import React from 'react';
import { Link, useNavigate } from 'react-router-dom';

export default function Navbar() {
  const navigate = useNavigate();
  const token = localStorage.getItem('token');
  const role  = localStorage.getItem('role');

  const handleLogout = () => {
    localStorage.clear();
    navigate('/');
  };

  return (
    <nav className="navbar navbar-expand-lg navbar-light bg-light">
      <div className="container">
        <Link className="navbar-brand" to="/">Grocery Shop</Link>
        <div className="collapse navbar-collapse">
          <ul className="navbar-nav ms-auto">
            {!token ? (
              <>
                <li className="nav-item"><Link className="nav-link" to="/login">Login</Link></li>
                <li className="nav-item"><Link className="nav-link" to="/register">Register</Link></li>
              </>
            ) : (
              <>
                <li className="nav-item"><Link className="nav-link" to="/catalogue">Catalogue</Link></li>
                {role === 'admin' && (
                  <li className="nav-item">
                    <Link className="nav-link" to="/catalogue">Admin Panel</Link>
                  </li>
                )}
                <li className="nav-item">
                  <button className="btn btn-link nav-link" onClick={handleLogout}>
                    Logout
                  </button>
                </li>
              </>
            )}
          </ul>
        </div>
      </div>
    </nav>
  );
}
