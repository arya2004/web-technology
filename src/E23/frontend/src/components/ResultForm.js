import React, { useState } from 'react';
import axios from 'axios';

const ResultForm = () => {
  const [formData, setFormData] = useState({
    name: '',
    reg_no: '',
    subjects: [
      { subject: '', mse: '', ese: '' },
      { subject: '', mse: '', ese: '' },
      { subject: '', mse: '', ese: '' },
      { subject: '', mse: '', ese: '' }
    ]
  });

  const handleChange = (index, field, value) => {
    const newSubjects = [...formData.subjects];
    newSubjects[index][field] = value;
    setFormData({ ...formData, subjects: newSubjects });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    await axios.post('http://localhost:5000/api/students', formData);
    alert('Result saved');
  };

  return (
    <form onSubmit={handleSubmit} className="p-4">
      <div className="mb-3">
        <input
          type="text"
          placeholder="Name"
          className="form-control"
          onChange={(e) => setFormData({ ...formData, name: e.target.value })}
        />
        <input
          type="text"
          placeholder="Reg No"
          className="form-control mt-2"
          onChange={(e) => setFormData({ ...formData, reg_no: e.target.value })}
        />
      </div>

      {formData.subjects.map((subj, index) => (
        <div key={index} className="mb-3 border p-3 rounded">
          <h6>Subject {index + 1}</h6>
          <input
            type="text"
            placeholder="Subject Name"
            className="form-control"
            onChange={(e) => handleChange(index, 'subject', e.target.value)}
          />
          <input
            type="number"
            placeholder="MSE Marks"
            className="form-control mt-2"
            onChange={(e) => handleChange(index, 'mse', e.target.value)}
          />
          <input
            type="number"
            placeholder="ESE Marks"
            className="form-control mt-2"
            onChange={(e) => handleChange(index, 'ese', e.target.value)}
          />
        </div>
      ))}

      <button className="btn btn-primary mt-3" type="submit">
        Submit
      </button>
    </form>
  );
};

export default ResultForm;
