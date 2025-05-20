import React from 'react';
import { Link } from 'react-router-dom';

export default function Home() {
  return (
    <div className="text-center">
      <h1>Welcome to the Online Grocery Shop</h1>
      <p className="lead">Please <Link to="/login">Login</Link> or <Link to="/register">Register</Link> to continue.</p>
    </div>
  );
}
