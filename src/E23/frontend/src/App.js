import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import ResultForm from './components/ResultForm';
import ResultDisplay from './components/ResultDisplay';

function App() {
  return (
    <div className="container mt-5">
      <h2 className="mb-4">VIT Semester Result App</h2>
      <ResultForm />
      <hr />
      <ResultDisplay />
    </div>
  );
}

export default App;
