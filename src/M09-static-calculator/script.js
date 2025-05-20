// script.js

document.addEventListener('DOMContentLoaded', function() {
  const display = document.getElementById('display');
  let current = '';
  
  // Utility to update the display
  function updateDisplay(value) {
    display.value = value;
  }

  // Perform the calculation safely
  function calculate(expr) {
    try {
      // Replace the unicode × and ÷ with JS operators
      expr = expr.replace(/×/g, '*').replace(/÷/g, '/');
      // Evaluate
      let result = Function('"use strict"; return (' + expr + ')')();
      return result;
    } catch {
      return 'Error';
    }
  }

  // Button handler
  document.querySelectorAll('button').forEach(button => {
    button.addEventListener('click', () => {
      const value = button.getAttribute('data-value');
      const action = button.getAttribute('data-action');

      if (action === 'clear') {
        current = '';
        updateDisplay('');
      }
      else if (action === 'backspace') {
        current = current.slice(0, -1);
        updateDisplay(current);
      }
      else if (action === 'equals') {
        if (current) {
          let res = calculate(current);
          current = String(res);
          updateDisplay(current);
        }
      }
      else if (action === 'sqrt') {
        if (current) {
          let num = parseFloat(current);
          if (!isNaN(num)) {
            let res = Math.sqrt(num);
            current = String(res);
            updateDisplay(current);
          }
        }
      }
      else if (value) {
        // Prevent multiple decimals in a number segment
        if (value === '.' && /[+\-*/%]?$/.test(current) === false) {
          // only allow one decimal if last segment has no decimal
          const segments = current.split(/[+\-*/%]/);
          if (segments[segments.length - 1].includes('.')) {
            return;
          }
        }
        current += value;
        updateDisplay(current);
      }
    });
  });
});
