import axios from 'axios';

const API = axios.create({
  baseURL: 'http://localhost:5000/api',
});

API.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});

// Admin CRUD
export const createItem   = (item) => API.post('/items', item);
export const updateItem   = (id, item) => API.put(`/items/${id}`, item);
export const deleteItem   = (id) => API.delete(`/items/${id}`);

// Public / authenticated fetch
export const fetchItems   = () => API.get('/items');

// Auth
export const loginUser    = (creds) => API.post('/auth/login', creds);
export const registerUser = (data)  => API.post('/auth/register', data);

export default API;
