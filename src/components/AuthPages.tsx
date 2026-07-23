import React, { useState } from 'react';
import { Mail, Lock, User as UserIcon, Shield, Phone, FileText, ChevronRight } from 'lucide-react';

interface AuthPagesProps {
  mode: 'login' | 'register';
  onAuthSuccess: (user: any) => void;
  onToggleMode: (newMode: 'login' | 'register') => void;
  setErrorMsg: (msg: string) => void;
  setSuccessMsg: (msg: string) => void;
}

export default function AuthPages({ mode, onAuthSuccess, onToggleMode, setErrorMsg, setSuccessMsg }: AuthPagesProps) {
  // Login State
  const [loginEmail, setLoginEmail] = useState('');
  const [loginPassword, setLoginPassword] = useState('');

  // Register State
  const [regName, setRegName] = useState('');
  const [regUsername, setRegUsername] = useState('');
  const [regEmail, setRegEmail] = useState('');
  const [regNip, setRegNip] = useState('');
  const [regPhone, setRegPhone] = useState('');
  const [regPassword, setRegPassword] = useState('');

  const [isLoading, setIsLoading] = useState(false);

  const presets = [
    { name: 'Superadmin TIK', email: 'tik@ith.ac.id', pass: 'admin123', role: 'Admin' },
    { name: 'Admin UPT TIK', email: 'upttik26@gmail.com', pass: 'admin123', role: 'Admin' },
    { name: 'Operator Jaringan', email: 'operator@itsp.id', pass: 'operator123', role: 'Operator' },
    { name: 'Demo User (Mhs)', email: 'rakhmadi.rahman90@gmail.com', pass: 'user123', role: 'User' }
  ];

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!loginEmail || !loginPassword) {
      setErrorMsg('Harap isi semua kolom login.');
      return;
    }
    setIsLoading(true);
    try {
      const response = await fetch('/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: loginEmail, password: loginPassword }),
      });
      const data = await response.json();
      if (response.ok) {
        onAuthSuccess(data.user);
        setSuccessMsg(`Selamat datang kembali, ${data.user.name}!`);
      } else {
        setErrorMsg(data.message || 'Login gagal.');
      }
    } catch (err) {
      setErrorMsg('Terjadi kesalahan jaringan.');
    } finally {
      setIsLoading(false);
    }
  };

  const handleRegister = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!regName || !regUsername || !regEmail || !regNip || !regPassword) {
      setErrorMsg('Harap isi kolom bertanda bintang (*).');
      return;
    }
    setIsLoading(true);
    try {
      const response = await fetch('/api/auth/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          name: regName,
          username: regUsername,
          email: regEmail,
          nip: regNip,
          phone: regPhone,
          password: regPassword,
        }),
      });
      const data = await response.json();
      if (response.ok) {
        onAuthSuccess(data.user);
        setSuccessMsg(`Registrasi berhasil! Selamat datang, ${data.user.name}.`);
      } else {
        setErrorMsg(data.message || 'Registrasi gagal.');
      }
    } catch (err) {
      setErrorMsg('Terjadi kesalahan jaringan.');
    } finally {
      setIsLoading(false);
    }
  };

  const applyPreset = (preset: typeof presets[0]) => {
    setLoginEmail(preset.email);
    setLoginPassword(preset.pass);
    setSuccessMsg(`Preset ${preset.name} dipilih. Silakan tekan tombol Masuk.`);
  };

  return (
    <div className="max-w-md mx-auto my-12" id="auth-pages">
      <div className="bg-white border border-slate-200 rounded-3xl shadow-xl overflow-hidden p-8 space-y-8">
        {/* Auth Header */}
        <div className="text-center space-y-2">
          <div className="inline-flex w-12 h-12 bg-indigo-50 border border-indigo-100 rounded-2xl items-center justify-center text-indigo-600 font-bold mb-2">
            IT
          </div>
          <h2 className="text-2xl font-extrabold tracking-tight text-slate-900">
            {mode === 'login' ? 'Masuk ke Portal' : 'Daftar Akun Baru'}
          </h2>
          <p className="text-xs text-slate-500">
            {mode === 'login'
              ? 'Gunakan akun terdaftar Anda untuk mengakses seluruh layanan digital'
              : 'Daftarkan akun sivitas akademika resmi Anda untuk memulai permohonan'}
          </p>
        </div>

        {/* Action Form */}
        {mode === 'login' ? (
          <form onSubmit={handleLogin} className="space-y-4">
            <div className="space-y-1">
              <label className="text-xs font-semibold text-slate-700 block">Alamat Email Kampus</label>
              <div className="relative">
                <Mail className="absolute left-3 top-3 w-4 h-4 text-slate-400" />
                <input
                  type="email"
                  placeholder="name@ith.ac.id"
                  value={loginEmail}
                  onChange={(e) => setLoginEmail(e.target.value)}
                  className="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                />
              </div>
            </div>

            <div className="space-y-1">
              <label className="text-xs font-semibold text-slate-700 block">Kata Sandi</label>
              <div className="relative">
                <Lock className="absolute left-3 top-3 w-4 h-4 text-slate-400" />
                <input
                  type="password"
                  placeholder="Masukkan kata sandi"
                  value={loginPassword}
                  onChange={(e) => setLoginPassword(e.target.value)}
                  className="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                />
              </div>
            </div>

            <button
              type="submit"
              disabled={isLoading}
              className="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-100 transition-all flex items-center justify-center gap-2 disabled:opacity-50"
            >
              {isLoading ? 'Memproses...' : 'Masuk Portal'}
              <ChevronRight className="w-4 h-4" />
            </button>
          </form>
        ) : (
          <form onSubmit={handleRegister} className="space-y-4">
            <div className="space-y-1">
              <label className="text-xs font-semibold text-slate-700 block">Nama Lengkap *</label>
              <div className="relative">
                <UserIcon className="absolute left-3 top-3 w-4 h-4 text-slate-400" />
                <input
                  type="text"
                  placeholder="Contoh: Budi Santoso"
                  value={regName}
                  onChange={(e) => setRegName(e.target.value)}
                  className="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                />
              </div>
            </div>

            <div className="grid grid-cols-2 gap-4">
              <div className="space-y-1">
                <label className="text-xs font-semibold text-slate-700 block">NIP / NIM / NIK *</label>
                <div className="relative">
                  <FileText className="absolute left-3 top-3 w-4 h-4 text-slate-400" />
                  <input
                    type="text"
                    placeholder="Contoh: 101010"
                    value={regUsername}
                    onChange={(e) => setRegUsername(e.target.value)}
                    className="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                  />
                </div>
              </div>

              <div className="space-y-1">
                <label className="text-xs font-semibold text-slate-700 block">Nomor Telepon</label>
                <div className="relative">
                  <Phone className="absolute left-3 top-3 w-4 h-4 text-slate-400" />
                  <input
                    type="text"
                    placeholder="Contoh: 0812345"
                    value={regPhone}
                    onChange={(e) => setRegPhone(e.target.value)}
                    className="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                  />
                </div>
              </div>
            </div>

            <div className="space-y-1">
              <label className="text-xs font-semibold text-slate-700 block">Alamat Email Aktif *</label>
              <div className="relative">
                <Mail className="absolute left-3 top-3 w-4 h-4 text-slate-400" />
                <input
                  type="email"
                  placeholder="name@domain.com"
                  value={regEmail}
                  onChange={(e) => setRegEmail(e.target.value)}
                  className="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                />
              </div>
            </div>

            <div className="space-y-1">
              <label className="text-xs font-semibold text-slate-700 block">Kata Sandi Baru *</label>
              <div className="relative">
                <Lock className="absolute left-3 top-3 w-4 h-4 text-slate-400" />
                <input
                  type="password"
                  placeholder="Masukkan kata sandi baru"
                  value={regPassword}
                  onChange={(e) => setRegPassword(e.target.value)}
                  className="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                />
              </div>
            </div>

            <button
              type="submit"
              disabled={isLoading}
              className="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-100 transition-all flex items-center justify-center gap-2 disabled:opacity-50"
            >
              {isLoading ? 'Memproses...' : 'Daftar Akun'}
              <ChevronRight className="w-4 h-4" />
            </button>
          </form>
        )}

        {/* Footer Toggle */}
        <div className="text-center pt-2">
          {mode === 'login' ? (
            <p className="text-xs text-slate-500">
              Belum memiliki akun?{' '}
              <button onClick={() => onToggleMode('register')} className="font-bold text-indigo-600 hover:underline">
                Daftar Sekarang
              </button>
            </p>
          ) : (
            <p className="text-xs text-slate-500">
              Sudah memiliki akun?{' '}
              <button onClick={() => onToggleMode('login')} className="font-bold text-indigo-600 hover:underline">
                Masuk ke Portal
              </button>
            </p>
          )}
        </div>

        {/* Demo Presets Selector */}
        {mode === 'login' && (
          <div className="border-t border-slate-100 pt-6 space-y-3">
            <h3 className="text-xs font-bold text-slate-400 tracking-wider uppercase text-center">Akun Demo Cepat</h3>
            <div className="grid grid-cols-2 gap-2">
              {presets.map((p, idx) => (
                <button
                  key={idx}
                  onClick={() => applyPreset(p)}
                  type="button"
                  className="p-2 text-left bg-slate-50 hover:bg-slate-100 hover:border-indigo-300 border border-slate-200 rounded-lg text-2xs transition-colors flex flex-col"
                >
                  <span className="font-bold text-slate-800">{p.name}</span>
                  <span className="text-slate-500 font-medium">Role: {p.role}</span>
                </button>
              ))}
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
