import React, { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { loginUser } from '../services/api';

export default function Login() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const navigate = useNavigate();

  const handleSubmit = async e => {
    e.preventDefault();
    setError('');
    try {
      const { data } = await loginUser({ email, password });
      localStorage.setItem('token', data.token);
      localStorage.setItem('role', data.role);
      navigate('/catalogue');
    } catch (err) {
      setError(err.response?.data?.message || 'Login failed');
    }
  };

  return (
    <div className="row justify-content-center">
      <div className="col-md-6">
        <h2>Login</h2>
        {error && <div className="alert alert-danger">{error}</div>}
        <form onSubmit={handleSubmit}>
          {/* Email */}
          <div className="mb-3">
            <label htmlFor="loginEmail" className="form-label">Email</label>
            <input
              id="loginEmail"
              type="email"
              className="form-control"
              value={email}
              onChange={e => setEmail(e.target.value)}
              required
            />
          </div>

          {/* Password */}
          <div className="mb-3">
            <label htmlFor="loginPassword" className="form-label">Password</label>
            <input
              id="loginPassword"
              type="password"
              className="form-control"
              value={password}
              onChange={e => setPassword(e.target.value)}
              required
            />
          </div>

          <button className="btn btn-primary" type="submit">Login</button>
        </form>
        <p className="mt-3">
          Don't have an account? <Link to="/register">Register here</Link>
        </p>
      </div>
    </div>
  );
}
