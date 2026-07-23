import React from 'react';
import { Announcement, Activity, User } from '../types';
import { Calendar, Mail, Globe, Wifi, ShieldAlert, Award, FileText, CheckCircle2, AlertCircle, ChevronRight, Clock } from 'lucide-react';

interface PortalHomeProps {
  user: User | null;
  announcements: Announcement[];
  activities: Activity[];
  onNavigate: (view: string) => void;
}

export default function PortalHome({ user, announcements, activities, onNavigate }: PortalHomeProps) {
  const services = [
    {
      id: 'zoom',
      title: 'Zoom Meeting',
      desc: 'Pengajuan lisensi Zoom Meeting Pro untuk perkuliahan, seminar, rapat organisasi, atau kegiatan institusi.',
      icon: Calendar,
      color: 'bg-blue-50 text-blue-600 border-blue-100',
    },
    {
      id: 'email-pribadi',
      title: 'Email Pribadi',
      desc: 'Pembuatan akun email civitas akademika dengan domain resmi @ith.ac.id untuk korespondensi resmi.',
      icon: Mail,
      color: 'bg-emerald-50 text-emerald-600 border-emerald-100',
    },
    {
      id: 'email-lembaga',
      title: 'Email Lembaga',
      desc: 'Pembuatan email resmi untuk unit kerja, program studi, divisi administrasi, atau lembaga mahasiswa.',
      icon: Award,
      color: 'bg-violet-50 text-violet-600 border-violet-100',
    },
    {
      id: 'subdomain',
      title: 'Subdomain & Hosting',
      desc: 'Registrasi nama subdomain (nama.ith.ac.id) beserta kapasitas web hosting untuk profil unit/organisasi.',
      icon: Globe,
      color: 'bg-indigo-50 text-indigo-600 border-indigo-100',
    },
    {
      id: 'hotspot',
      title: 'Akses Hotspot',
      desc: 'Pendaftaran alamat MAC fisik perangkat laptop atau smartphone untuk menikmati internet wifi kampus tanpa batasan.',
      icon: Wifi,
      color: 'bg-amber-50 text-amber-600 border-amber-100',
    },
    {
      id: 'laporan',
      title: 'Laporan Kerusakan',
      desc: 'Pengaduan keluhan, kerusakan jaringan internet, perangkat laboratorium, atau sistem informasi kampus.',
      icon: ShieldAlert,
      color: 'bg-rose-50 text-rose-600 border-rose-100',
    },
  ];

  return (
    <div className="space-y-12 pb-16" id="portal-home">
      {/* Hero Header Banner */}
      <section className="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-850 to-slate-900 rounded-3xl text-white px-6 sm:px-12 py-16 sm:py-20 shadow-2xl">
        <div className="absolute inset-0 opacity-10 bg-[radial-gradient(#4f46e5_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div className="relative max-w-3xl space-y-6">
          <span className="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-500/30 border border-indigo-400/30 text-indigo-200 text-xs font-semibold rounded-full uppercase tracking-wider">
            UPT TIK ITH Parepare
          </span>
          <h1 className="text-4xl sm:text-5xl font-extrabold tracking-tight leading-none text-white">
            Pusat Layanan & <br />
            <span className="text-indigo-400">IT Support Terintegrasi</span>
          </h1>
          <p className="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl">
            Ajukan permohonan lisensi Zoom, pembuatan email institusi, registrasi subdomain/hosting divisi, pendaftaran perangkat hotspot MAC, atau laporkan kendala teknis jaringan dengan mudah dan cepat.
          </p>
          <div className="flex flex-wrap gap-4 pt-2">
            {user ? (
              <button
                onClick={() => onNavigate('user-dashboard')}
                className="px-6 py-3 text-sm font-semibold bg-white text-indigo-900 hover:bg-slate-100 rounded-lg shadow-md transition-all flex items-center gap-2"
              >
                Masuk ke Dashboard
                <ChevronRight className="w-4 h-4" />
              </button>
            ) : (
              <>
                <button
                  onClick={() => onNavigate('login')}
                  className="px-6 py-3 text-sm font-semibold bg-white text-indigo-900 hover:bg-slate-100 rounded-lg shadow-md transition-all flex items-center gap-2"
                >
                  Ajukan Layanan Sekarang
                  <ChevronRight className="w-4 h-4" />
                </button>
                <button
                  onClick={() => onNavigate('faq')}
                  className="px-6 py-3 text-sm font-semibold bg-slate-800/60 text-slate-200 hover:bg-slate-800 border border-slate-700 rounded-lg transition-all"
                >
                  Panduan Penggunaan
                </button>
              </>
            )}
          </div>
        </div>
      </section>

      {/* Grid of 6 IT Services */}
      <section className="space-y-6">
        <div className="text-center max-w-2xl mx-auto space-y-2">
          <h2 className="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950">Layanan IT yang Tersedia</h2>
          <p className="text-sm text-slate-600">
            Berikut adalah katalog layanan digital yang dikelola langsung oleh UPT TIK. Silakan masuk atau mendaftar terlebih dahulu untuk melakukan pengajuan permohonan.
          </p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
          {services.map((service) => {
            const Icon = service.icon;
            return (
              <div
                key={service.id}
                onClick={() => {
                  if (user) {
                    onNavigate('user-dashboard');
                  } else {
                    onNavigate('login');
                  }
                }}
                className="group relative flex flex-col justify-between bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all cursor-pointer"
              >
                <div className="space-y-4">
                  <div className={`w-12 h-12 rounded-xl border flex items-center justify-center ${service.color}`}>
                    <Icon className="w-6 h-6" />
                  </div>
                  <h3 className="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                    {service.title}
                  </h3>
                  <p className="text-sm text-slate-600 leading-relaxed">
                    {service.desc}
                  </p>
                </div>
                <div className="flex items-center gap-1 text-xs font-semibold text-indigo-600 pt-4 opacity-0 group-hover:opacity-100 transition-all">
                  <span>Buat Pengajuan</span>
                  <ChevronRight className="w-3.5 h-3.5" />
                </div>
              </div>
            );
          })}
        </div>
      </section>

      {/* Two Columns: Recent Announcements & Recent Activities */}
      <section className="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4">
        {/* Left Column: Announcements */}
        <div className="space-y-5 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
          <div className="flex justify-between items-center border-b border-slate-100 pb-3">
            <h2 className="text-lg font-bold text-slate-950 flex items-center gap-2">
              <Clock className="w-5 h-5 text-indigo-600" />
              Pengumuman Terbaru
            </h2>
            <button onClick={() => onNavigate('faq')} className="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
              Lihat Semua
            </button>
          </div>

          <div className="space-y-4">
            {announcements.slice(0, 3).map((ann) => (
              <div key={ann.id} className="p-4 bg-slate-50 hover:bg-slate-100/80 rounded-xl border border-slate-150 transition-all">
                <div className="flex justify-between items-start gap-2 mb-1.5">
                  <span className={`px-2 py-0.5 text-2xs font-bold rounded-md ${
                    ann.category === 'Penting' ? 'bg-rose-50 text-rose-700' : 'bg-indigo-50 text-indigo-700'
                  }`}>
                    {ann.category}
                  </span>
                  <span className="text-xs text-slate-500 font-medium">{ann.date}</span>
                </div>
                <h3 className="text-sm font-bold text-slate-900 leading-tight mb-1">{ann.title}</h3>
                <p className="text-xs text-slate-600 line-clamp-2 leading-relaxed">{ann.content}</p>
              </div>
            ))}
            {announcements.length === 0 && (
              <p className="text-xs text-slate-500 text-center py-6">Belum ada pengumuman saat ini.</p>
            )}
          </div>
        </div>

        {/* Right Column: Activities / News */}
        <div className="space-y-5 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
          <div className="flex justify-between items-center border-b border-slate-100 pb-3">
            <h2 className="text-lg font-bold text-slate-950 flex items-center gap-2">
              <FileText className="w-5 h-5 text-indigo-600" />
              Kegiatan & Berita TIK
            </h2>
            <button onClick={() => onNavigate('sejarah')} className="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
              Tentang Kami
            </button>
          </div>

          <div className="space-y-4">
            {activities.slice(0, 2).map((act) => (
              <div key={act.id} className="flex gap-4 items-start p-3 hover:bg-slate-50 rounded-xl transition-all">
                <div className="w-20 h-20 bg-slate-100 border border-slate-200 rounded-lg overflow-hidden shrink-0">
                  <img
                    src={act.imageUrl}
                    referrerPolicy="no-referrer"
                    alt={act.title}
                    className="w-full h-full object-cover"
                    onError={(e) => {
                      (e.target as HTMLImageElement).src = 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=200&auto=format&fit=crop';
                    }}
                  />
                </div>
                <div className="space-y-1">
                  <span className="text-2xs text-slate-500 font-medium block">{act.date}</span>
                  <h3 className="text-sm font-bold text-slate-900 leading-tight">{act.title}</h3>
                  <p className="text-xs text-slate-600 line-clamp-2 leading-relaxed">{act.content}</p>
                </div>
              </div>
            ))}
            {activities.length === 0 && (
              <p className="text-xs text-slate-500 text-center py-6">Belum ada berita kegiatan saat ini.</p>
            )}
          </div>
        </div>
      </section>
    </div>
  );
}
