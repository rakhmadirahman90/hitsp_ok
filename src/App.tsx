import React, { useState, useEffect } from 'react';
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import PortalHome from './components/PortalHome';
import AuthPages from './components/AuthPages';
import UserDashboard from './components/UserDashboard';
import AdminDashboard from './components/AdminDashboard';
import FaqView from './components/FaqView';
import FasilitasView from './components/FasilitasView';
import SejarahView from './components/SejarahView';
import { User, Announcement, Activity, Faq, Fasilitas } from './types';
import { CheckCircle2, AlertCircle, X } from 'lucide-react';

export default function App() {
  const [currentView, setCurrentView] = useState<string>('home');
  const [user, setUser] = useState<User | null>(null);

  // Lists loaded from backend for general display
  const [announcements, setAnnouncements] = useState<Announcement[]>([]);
  const [activities, setActivities] = useState<Activity[]>([]);
  const [faqs, setFaqs] = useState<Faq[]>([]);
  const [facilities, setFacilities] = useState<Fasilitas[]>([]);

  // Notification States
  const [successMsg, setSuccessMsg] = useState<string | null>(null);
  const [errorMsg, setErrorMsg] = useState<string | null>(null);

  // Fetch session & general items on mount
  const checkSession = async () => {
    try {
      const res = await fetch('/api/auth/me');
      if (res.ok) {
        const data = await res.json();
        setUser(data.user);
      }
    } catch (e) {
      // Not logged in or network issue
    }
  };

  const fetchPublicData = async () => {
    try {
      const [annRes, actRes, faqRes, fasRes] = await Promise.all([
        fetch('/api/announcements'),
        fetch('/api/activities'),
        fetch('/api/content/faqs'),
        fetch('/api/content/fasilitas'),
      ]);

      if (annRes.ok) setAnnouncements(await annRes.json());
      if (actRes.ok) setActivities(await actRes.json());
      if (faqRes.ok) setFaqs(await faqRes.json());
      if (fasRes.ok) setFacilities(await fasRes.json());
    } catch (e) {
      console.error('Failed to fetch public listings', e);
    }
  };

  useEffect(() => {
    checkSession();
    fetchPublicData();
  }, []);

  // Timer auto-dismiss for alerts
  useEffect(() => {
    if (successMsg) {
      const t = setTimeout(() => setSuccessMsg(null), 5000);
      return () => clearTimeout(t);
    }
  }, [successMsg]);

  useEffect(() => {
    if (errorMsg) {
      const t = setTimeout(() => setErrorMsg(null), 5000);
      return () => clearTimeout(t);
    }
  }, [errorMsg]);

  const handleLogout = async () => {
    try {
      await fetch('/api/auth/logout', { method: 'POST' });
      setUser(null);
      setSuccessMsg('Anda telah keluar dari sistem.');
      setCurrentView('home');
    } catch (e) {
      setErrorMsg('Gagal melakukan logout.');
    }
  };

  const handleAuthSuccess = (loggedUser: User) => {
    setUser(loggedUser);
    if (loggedUser.role === 'admin' || loggedUser.role === 'operator') {
      setCurrentView('admin-dashboard');
    } else {
      setCurrentView('user-dashboard');
    }
  };

  // Safe navigation guard
  const navigateTo = (view: string) => {
    if ((view === 'user-dashboard' || view === 'admin-dashboard') && !user) {
      setCurrentView('login');
      return;
    }
    setCurrentView(view);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <div className="min-h-screen bg-slate-50 flex flex-col justify-between selection:bg-indigo-500 selection:text-white antialiased text-slate-900">
      
      {/* Alert Banner Container */}
      <div className="fixed top-5 right-5 z-100 max-w-sm w-full space-y-3 pointer-events-none">
        {successMsg && (
          <div className="bg-emerald-600 text-white rounded-2xl p-4 shadow-xl flex items-start gap-3 border border-emerald-500 animate-in slide-in-from-top-4 duration-300 pointer-events-auto">
            <CheckCircle2 className="w-5 h-5 shrink-0 mt-0.5" />
            <div className="flex-1 text-xs font-semibold">
              {successMsg}
            </div>
            <button onClick={() => setSuccessMsg(null)} className="hover:bg-white/10 p-1 rounded-full">
              <X className="w-4 h-4" />
            </button>
          </div>
        )}

        {errorMsg && (
          <div className="bg-rose-600 text-white rounded-2xl p-4 shadow-xl flex items-start gap-3 border border-rose-500 animate-in slide-in-from-top-4 duration-300 pointer-events-auto">
            <AlertCircle className="w-5 h-5 shrink-0 mt-0.5" />
            <div className="flex-1 text-xs font-semibold">
              {errorMsg}
            </div>
            <button onClick={() => setErrorMsg(null)} className="hover:bg-white/10 p-1 rounded-full">
              <X className="w-4 h-4" />
            </button>
          </div>
        )}
      </div>

      {/* Header Navigation bar */}
      <Navbar
        user={user}
        currentView={currentView}
        onNavigate={navigateTo}
        onLogout={handleLogout}
      />

      {/* Main Content Render area */}
      <main className="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow">
        {currentView === 'home' && (
          <PortalHome
            user={user}
            announcements={announcements}
            activities={activities}
            onNavigate={navigateTo}
          />
        )}

        {(currentView === 'login' || currentView === 'register') && (
          <AuthPages
            mode={currentView as 'login' | 'register'}
            onAuthSuccess={handleAuthSuccess}
            onToggleMode={(mode) => setCurrentView(mode)}
            setErrorMsg={(msg) => setErrorMsg(msg)}
            setSuccessMsg={(msg) => setSuccessMsg(msg)}
          />
        )}

        {currentView === 'user-dashboard' && user && (
          <UserDashboard
            user={user}
            onShowSuccess={(msg) => setSuccessMsg(msg)}
            onShowError={(msg) => setErrorMsg(msg)}
          />
        )}

        {currentView === 'admin-dashboard' && user && (
          <AdminDashboard
            user={user}
            onShowSuccess={(msg) => setSuccessMsg(msg)}
            onShowError={(msg) => setErrorMsg(msg)}
          />
        )}

        {currentView === 'faq' && (
          <FaqView faqs={faqs} />
        )}

        {currentView === 'fasilitas' && (
          <FasilitasView facilities={facilities} />
        )}

        {currentView === 'sejarah' && (
          <SejarahView />
        )}
      </main>

      {/* Footer Branding Area */}
      <Footer onNavigate={navigateTo} />
    </div>
  );
}
