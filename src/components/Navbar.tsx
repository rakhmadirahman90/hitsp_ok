import React, { useState } from 'react';
import { User } from '../types';
import { Menu, X, Shield, LogOut, User as UserIcon, Home, Compass, Info, HelpCircle, Calendar, BookOpen, Wifi, ShieldAlert } from 'lucide-react';

interface NavbarProps {
  user: User | null;
  activeView: string;
  onNavigate: (view: string) => void;
  onLogout: () => void;
}

export default function Navbar({ user, activeView, onNavigate, onLogout }: NavbarProps) {
  const [isOpen, setIsOpen] = useState(false);

  const menuItems = [
    { id: 'home', label: 'Beranda', icon: Home },
    { id: 'visi-misi', label: 'Visi & Misi', icon: Compass },
    { id: 'sejarah', label: 'Sejarah', icon: BookOpen },
    { id: 'fasilitas', label: 'Fasilitas', icon: Info },
    { id: 'faq', label: 'FAQ', icon: HelpCircle },
  ];

  return (
    <nav className="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm" id="navbar">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16">
          {/* Logo and Branding */}
          <div className="flex items-center cursor-pointer" onClick={() => onNavigate('home')}>
            <div className="flex-shrink-0 flex items-center gap-3">
              <div className="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold shadow-md shadow-indigo-200">
                IT
              </div>
              <div>
                <span className="text-lg font-bold text-slate-900 tracking-tight block leading-none">HITSP PORTAL</span>
                <span className="text-xs text-slate-500 font-medium tracking-wide">UPT TIK ITH</span>
              </div>
            </div>
          </div>

          {/* Desktop Navigation Links */}
          <div className="hidden md:flex md:items-center md:space-x-1">
            {menuItems.map((item) => {
              const Icon = item.icon;
              return (
                <button
                  key={item.id}
                  onClick={() => onNavigate(item.id)}
                  className={`flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-colors ${
                    activeView === item.id
                      ? 'bg-indigo-50 text-indigo-700'
                      : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                  }`}
                >
                  <Icon className="w-4 h-4" />
                  {item.label}
                </button>
              );
            })}
          </div>

          {/* User Section (Auth Buttons / Profile Info) */}
          <div className="hidden md:flex md:items-center md:gap-3">
            {user ? (
              <div className="flex items-center gap-3">
                {/* Admin/Operator Quick Switch Indicator */}
                {(user.role === 'admin' || user.role === 'operator') && (
                  <button
                    onClick={() => onNavigate('admin-dashboard')}
                    className="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-md transition-all shadow-sm"
                  >
                    <Shield className="w-3.5 h-3.5" />
                    Panel {user.role === 'admin' ? 'Admin' : 'Operator'}
                  </button>
                )}

                {user.role === 'user' && (
                  <button
                    onClick={() => onNavigate('user-dashboard')}
                    className="flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-md transition-all"
                  >
                    Dashboard Saya
                  </button>
                )}

                {/* Profile Link */}
                <button
                  onClick={() => onNavigate('profile')}
                  className={`flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-sm font-medium transition-colors ${
                    activeView === 'profile' ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50'
                  }`}
                >
                  <UserIcon className="w-4 h-4" />
                  <span className="max-w-[120px] truncate">{user.name}</span>
                </button>

                {/* Logout Button */}
                <button
                  onClick={onLogout}
                  className="p-1.5 text-slate-400 hover:text-rose-600 rounded-md hover:bg-rose-50 transition-colors"
                  title="Keluar"
                >
                  <LogOut className="w-4 h-4" />
                </button>
              </div>
            ) : (
              <div className="flex items-center gap-2">
                <button
                  onClick={() => onNavigate('login')}
                  className="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-slate-900 transition-colors"
                >
                  Masuk
                </button>
                <button
                  onClick={() => onNavigate('register')}
                  className="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm transition-colors"
                >
                  Daftar
                </button>
              </div>
            )}
          </div>

          {/* Mobile Menu Button */}
          <div className="flex items-center md:hidden">
            <button
              onClick={() => setIsOpen(!isOpen)}
              className="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none"
            >
              {isOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile Menu dropdown */}
      {isOpen && (
        <div className="md:hidden border-t border-slate-200 bg-white shadow-lg">
          <div className="px-2 pt-2 pb-3 space-y-1">
            {menuItems.map((item) => {
              const Icon = item.icon;
              return (
                <button
                  key={item.id}
                  onClick={() => {
                    onNavigate(item.id);
                    setIsOpen(false);
                  }}
                  className={`flex items-center gap-2 w-full px-3 py-2.5 rounded-md text-base font-medium transition-colors ${
                    activeView === item.id
                      ? 'bg-indigo-50 text-indigo-700'
                      : 'text-slate-600 hover:bg-slate-50'
                  }`}
                >
                  <Icon className="w-5 h-5" />
                  {item.label}
                </button>
              );
            })}

            {user && (
              <>
                <div className="border-t border-slate-100 my-2"></div>
                {(user.role === 'admin' || user.role === 'operator') && (
                  <button
                    onClick={() => {
                      onNavigate('admin-dashboard');
                      setIsOpen(false);
                    }}
                    className="flex items-center gap-2 w-full px-3 py-2.5 rounded-md text-base font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors"
                  >
                    <Shield className="w-5 h-5" />
                    Panel {user.role === 'admin' ? 'Admin' : 'Operator'}
                  </button>
                )}
                {user.role === 'user' && (
                  <button
                    onClick={() => {
                      onNavigate('user-dashboard');
                      setIsOpen(false);
                    }}
                    className="flex items-center gap-2 w-full px-3 py-2.5 rounded-md text-base font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors"
                  >
                    <UserIcon className="w-5 h-5" />
                    Dashboard Saya
                  </button>
                )}
                <button
                  onClick={() => {
                    onNavigate('profile');
                    setIsOpen(false);
                  }}
                  className="flex items-center gap-2 w-full px-3 py-2.5 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50 transition-colors"
                >
                  <UserIcon className="w-5 h-5" />
                  Profil saya ({user.name})
                </button>
                <button
                  onClick={() => {
                    onLogout();
                    setIsOpen(false);
                  }}
                  className="flex items-center gap-2 w-full px-3 py-2.5 rounded-md text-base font-medium text-rose-600 hover:bg-rose-50 transition-colors animate-pulse"
                >
                  <LogOut className="w-5 h-5" />
                  Keluar
                </button>
              </>
            )}

            {!user && (
              <>
                <div className="border-t border-slate-100 my-2"></div>
                <div className="grid grid-cols-2 gap-2 px-3 py-2">
                  <button
                    onClick={() => {
                      onNavigate('login');
                      setIsOpen(false);
                    }}
                    className="w-full text-center py-2 text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-md transition-colors"
                  >
                    Masuk
                  </button>
                  <button
                    onClick={() => {
                      onNavigate('register');
                      setIsOpen(false);
                    }}
                    className="w-full text-center py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm transition-colors"
                  >
                    Daftar
                  </button>
                </div>
              </>
            )}
          </div>
        </div>
      )}
    </nav>
  );
}
