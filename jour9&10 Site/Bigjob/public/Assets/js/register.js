import React, { useState } from 'react';
import { useRouter } from 'next/router';
import { registerUser } from '../../utils/auth';

export default function Register() {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const router = useRouter();

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await registerUser({ name, email, password });
      router.push('/auth/login');
    } catch (error) {
        console.error("Erreur d'inscription:", error);
        alert(error.message);
    }
  };

  return (
    <main className="container mt-4">
      <h1>Inscription</h1>
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label htmlFor="name" className="form-label">Nom complet</label>
          <input 
            type="text" 
            className="form-control" 
            id="name" 
            value={name}
            onChange={(e) => setName(e.target.value)}
            required 
          />
        </div>
        <div className="mb-3">
          <label htmlFor="email" className="form-label">Adresse e-mail</label>
          <input 
            type="email" 
            className="form-control" 
            id="email" 
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required 
          />
        </div>
        <div className="mb-3">
          <label htmlFor="password" className="form-label">Mot de passe</label>
          <input 
            type="password" 
            className="form-control" 
            id="password" 
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required 
          />
        </div>
        <button type="submit" className="btn btn-primary">S'inscrire</button>
      </form>
    </main>
  );
}