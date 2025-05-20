import React, { useEffect, useState } from 'react';
import { fetchItems, createItem, updateItem, deleteItem } from '../services/api';
import { useNavigate } from 'react-router-dom';

export default function Catalogue() {
  const [items, setItems] = useState([]);
  const [error, setError] = useState('');
  const [form, setForm]   = useState({ name:'', description:'', price:'', imageUrl:'' });
  const [editingId, setEditingId] = useState(null);
  const role = localStorage.getItem('role');
  const navigate = useNavigate();

  const load = async () => {
    try {
      const { data } = await fetchItems();
      setItems(data);
    } catch (err) {
      if (err.response?.status === 401) return navigate('/login');
      setError('Failed to load catalogue');
    }
  };

  useEffect(() => { load(); }, []);

  const handleChange = e => {
    setForm(f => ({ ...f, [e.target.name]: e.target.value }));
  };

  const handleSubmit = async e => {
    e.preventDefault();
    try {
      if (editingId) {
        await updateItem(editingId, form);
      } else {
        await createItem(form);
      }
      setForm({ name:'', description:'', price:'', imageUrl:'' });
      setEditingId(null);
      await load();
    } catch {
      setError('Operation failed');
    }
  };

  const startEdit = item => {
    setEditingId(item.id);
    setForm({
      name: item.name,
      description: item.description || '',
      price: item.price,
      imageUrl: item.imageUrl || ''
    });
  };

  const handleDelete = async id => {
    if (!window.confirm('Delete this item?')) return;
    await deleteItem(id);
    load();
  };

  return (
    <div>
      <h2>Catalogue</h2>
      {error && <div className="alert alert-danger">{error}</div>}

      {role === 'ADMIN' && (
        <form className="mb-4" onSubmit={handleSubmit}>
          <h4>{editingId ? 'Edit Item' : 'Add New Item'}</h4>
          {['name','description','price','imageUrl'].map(field => (
            <div className="mb-2" key={field}>
              <input
                name={field}
                className="form-control"
                placeholder={field.charAt(0).toUpperCase()+field.slice(1)}
                value={form[field]}
                onChange={handleChange}
                required={field==='name' || field==='price'}
              />
            </div>
          ))}
          <button className="btn btn-primary" type="submit">
            {editingId ? 'Update' : 'Create'}
          </button>
          {editingId && (
            <button
              type="button"
              className="btn btn-secondary ms-2"
              onClick={() => {
                setEditingId(null);
                setForm({ name:'', description:'', price:'', imageUrl:'' });
              }}
            >
              Cancel
            </button>
          )}
        </form>
      )}

      <div className="row">
        {items.map(item => (
          <div className="col-md-4 mb-4" key={item.id}>
            <div className="card h-100">
              {item.imageUrl && (
                <img src={item.imageUrl} className="card-img-top" alt={item.name} />
              )}
              <div className="card-body">
                <h5 className="card-title">{item.name}</h5>
                <p className="card-text">{item.description}</p>
              </div>
              <div className="card-footer d-flex justify-content-between align-items-center">
                <strong>₹{item.price}</strong>
                {role === 'ADMIN' && (
                  <div>
                    <button
                      className="btn btn-sm btn-outline-secondary me-2"
                      onClick={() => startEdit(item)}
                    >
                      Edit
                    </button>
                    <button
                      className="btn btn-sm btn-outline-danger"
                      onClick={() => handleDelete(item.id)}
                    >
                      Delete
                    </button>
                  </div>
                )}
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}
