import React, { useState, useEffect } from 'react';

function App() {
  // Hard-coded exchange rates relative to USD
  const RATES = {
    USD: 1,
    INR: 80,
    EUR: 0.92,
    GBP: 0.78,
    JPY: 150,
  };

  const currencyOptions = Object.keys(RATES);

  const [amount, setAmount] = useState('');
  const [fromCurr, setFromCurr] = useState('USD');
  const [toCurr, setToCurr] = useState('INR');
  const [result, setResult] = useState('');

  useEffect(() => {
    // Recalculate whenever amount, fromCurr or toCurr changes
    const num = parseFloat(amount);
    if (!isNaN(num)) {
      const usdValue = num / RATES[fromCurr];           // convert “from” → USD
      const converted = usdValue * RATES[toCurr];       // USD → “to”
      setResult(converted.toFixed(2));
    } else {
      setResult('');
    }
  }, [amount, fromCurr, toCurr]);

  return (
    <div className="container py-5">
      <h1 className="mb-4 text-center">Currency Converter</h1>
      <div className="row justify-content-center">
        <div className="col-md-6">

          {/* Amount Input */}
          <div className="mb-3">
            <label htmlFor="amount" className="form-label">
              Amount
            </label>
            <input
              type="number"
              step="any"
              className="form-control"
              id="amount"
              placeholder="Enter amount"
              value={amount}
              onChange={e => setAmount(e.target.value)}
            />
          </div>

          <div className="row">
            {/* From Currency */}
            <div className="col-6 mb-3">
              <label htmlFor="fromCurr" className="form-label">
                From
              </label>
              <select
                id="fromCurr"
                className="form-select"
                value={fromCurr}
                onChange={e => setFromCurr(e.target.value)}
              >
                {currencyOptions.map(cur => (
                  <option key={cur} value={cur}>
                    {cur}
                  </option>
                ))}
              </select>
            </div>

            {/* To Currency */}
            <div className="col-6 mb-3">
              <label htmlFor="toCurr" className="form-label">
                To
              </label>
              <select
                id="toCurr"
                className="form-select"
                value={toCurr}
                onChange={e => setToCurr(e.target.value)}
              >
                {currencyOptions.map(cur => (
                  <option key={cur} value={cur}>
                    {cur}
                  </option>
                ))}
              </select>
            </div>
          </div>

          {/* Result */}
          <div className="alert alert-info">
            {amount && !isNaN(parseFloat(amount)) ? (
              <>
                {amount} <strong>{fromCurr}</strong> ={' '}
                <strong>{result}</strong> <strong>{toCurr}</strong>
              </>
            ) : (
              'Enter a valid amount'
            )}
          </div>
        </div>
      </div>
    </div>
  );
}

export default App;
