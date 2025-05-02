import React, { useState } from 'react';
import axios from 'axios';

const ResultDisplay = () => {
  const [regNo, setRegNo] = useState('');
  const [result, setResult] = useState(null);

  const fetchResult = async () => {
    const res = await axios.get(`http://localhost:5000/api/students/${regNo}`);
    setResult(res.data);
  };

  return (
    <div className="p-4">
      <input type="text" placeholder="Enter Reg No" className="form-control mb-2" onChange={e => setRegNo(e.target.value)} />
      <button className="btn btn-success" onClick={fetchResult}>View Result</button>

      {result && (
        <div className="mt-4">
          <h5>{result.student.name}</h5>
          <table className="table">
            <thead>
              <tr>
                <th>Subject</th>
                <th>MSE</th>
                <th>ESE</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              {result.subjects.map((s, i) => (
                <tr key={i}>
                  <td>{s.subject}</td>
                  <td>{s.mse}</td>
                  <td>{s.ese}</td>
                  <td>{s.total}</td>
                </tr>
              ))}
            </tbody>
          </table>
          <strong>Overall: {result.overall}</strong>
        </div>
      )}
    </div>
  );
};

export default ResultDisplay;
