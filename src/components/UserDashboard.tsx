import React, { useState, useEffect } from 'react';
import { User, ZoomRequest, EmailPribadiRequest, EmailLembagaRequest, SubdomainRequest, HotspotRequest, LaporanRequest } from '../types';
import { LayoutGrid, FileText, Send, CheckCircle, AlertCircle, Clock, ExternalLink, Calendar, Mail, Globe, Wifi, ShieldAlert, Key, Trash, RefreshCw } from 'lucide-react';

interface UserDashboardProps {
  user: User;
  onShowSuccess: (msg: string) => void;
  onShowError: (msg: string) => void;
}

export default function UserDashboard({ user, onShowSuccess, onShowError }: UserDashboardProps) {
  const [activeTab, setActiveTab] = useState<'overview' | 'apply' | 'history'>('overview');
  const [applySubTab, setApplySubTab] = useState<'zoom' | 'email-pribadi' | 'email-lembaga' | 'subdomain' | 'hotspot' | 'laporan'>('zoom');

  // Requests lists
  const [zoomList, setZoomList] = useState<ZoomRequest[]>([]);
  const [emailPribadiList, setEmailPribadiList] = useState<EmailPribadiRequest[]>([]);
  const [emailLembagaList, setEmailLembagaList] = useState<EmailLembagaRequest[]>([]);
  const [subdomainList, setSubdomainList] = useState<SubdomainRequest[]>([]);
  const [hotspotList, setHotspotList] = useState<HotspotRequest[]>([]);
  const [laporanList, setLaporanList] = useState<LaporanRequest[]>([]);

  const [isLoading, setIsLoading] = useState(false);

  // Form States
  // 1. Zoom
  const [zoomTopic, setZoomTopic] = useState('');
  const [zoomDate, setZoomDate] = useState('');
  const [zoomStart, setZoomStart] = useState('');
  const [zoomEnd, setZoomEnd] = useState('');
  const [zoomParticipants, setZoomParticipants] = useState(10);

  // 2. Email Pribadi
  const [empRequest, setEmpRequest] = useState('');
  const [empAlternate, setEmpAlternate] = useState(user.email);
  const [empReason, setEmpReason] = useState('');

  // 3. Email Lembaga
  const [emlInstitution, setEmlInstitution] = useState('');
  const [emlRequest, setEmlRequest] = useState('');
  const [emlAlternate, setEmlAlternate] = useState(user.email);
  const [emlPic, setEmlPic] = useState(user.name);
  const [emlNip, setEmlNip] = useState(user.nip || '');

  // 4. Subdomain
  const [subDesired, setSubDesired] = useState('');
  const [subSpace, setSubSpace] = useState('500MB');
  const [subPurpose, setSubPurpose] = useState('');

  // 5. Hotspot
  const [hotMac, setHotMac] = useState('');
  const [hotUser, setHotUser] = useState(user.username);
  const [hotPurpose, setHotPurpose] = useState('Akses internet di area kampus');

  // 6. Laporan
  const [lapTitle, setLapTitle] = useState('');
  const [lapCategory, setLapCategory] = useState('Network');
  const [lapDesc, setLapDesc] = useState('');

  // Selected Detail Modal State
  const [selectedRequest, setSelectedRequest] = useState<any>(null);

  const fetchUserData = async () => {
    setIsLoading(true);
    try {
      const [zm, emp, eml, sub, hot, lap] = await Promise.all([
        fetch(`/api/users/${user.id}/zoom-requests`).then(r => r.json()),
        fetch(`/api/users/${user.id}/email-pribadi`).then(r => r.json()),
        fetch(`/api/users/${user.id}/email-lembaga`).then(r => r.json()),
        fetch(`/api/users/${user.id}/subdomain`).then(r => r.json()),
        fetch(`/api/users/${user.id}/hotspot`).then(r => r.json()),
        fetch(`/api/users/${user.id}/laporans`).then(r => r.json()),
      ]);

      setZoomList(zm || []);
      setEmailPribadiList(emp || []);
      setEmailLembagaList(eml || []);
      setSubdomainList(sub || []);
      setHotspotList(hot || []);
      setLaporanList(lap || []);
    } catch (e) {
      onShowError('Gagal memuat histori pengajuan Anda.');
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchUserData();
  }, [user.id]);

  // Combined tracking count
  const totalSubmitted = zoomList.length + emailPribadiList.length + emailLembagaList.length + subdomainList.length + hotspotList.length + laporanList.length;
  const pendingCount = 
    zoomList.filter(z => z.status === 'pending').length +
    emailPribadiList.filter(e => e.status === 'pending').length +
    emailLembagaList.filter(e => e.status === 'pending').length +
    subdomainList.filter(s => s.status === 'pending').length +
    hotspotList.filter(h => h.status === 'pending').length +
    laporanList.filter(l => l.status === 'pending').length;

  const approvedCount = 
    zoomList.filter(z => z.status === 'disetujui').length +
    emailPribadiList.filter(e => e.status === 'disetujui').length +
    emailLembagaList.filter(e => e.status === 'disetujui').length +
    subdomainList.filter(s => s.status === 'disetujui').length +
    hotspotList.filter(h => h.status === 'disetujui').length +
    laporanList.filter(l => l.status === 'selesai' || l.status === 'diproses').length;

  // Form Submissions
  const handleZoomSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!zoomTopic || !zoomDate || !zoomStart || !zoomEnd) {
      onShowError('Harap lengkapi formulir pengajuan Zoom.');
      return;
    }
    try {
      const res = await fetch('/api/zoom-requests', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          userId: user.id,
          userName: user.name,
          topic: zoomTopic,
          date: zoomDate,
          startTime: zoomStart,
          endTime: zoomEnd,
          participants: Number(zoomParticipants)
        })
      });
      if (res.ok) {
        onShowSuccess('Permintaan Zoom Meeting berhasil dikirim!');
        setZoomTopic('');
        setZoomDate('');
        setZoomStart('');
        setZoomEnd('');
        fetchUserData();
        setActiveTab('history');
      } else {
        onShowError('Gagal mengirim pengajuan.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  const handleEmailPribadiSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!empRequest || !empAlternate || !empReason) {
      onShowError('Harap lengkapi semua kolom.');
      return;
    }
    try {
      const res = await fetch('/api/email-pribadi', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          userId: user.id,
          userName: user.name,
          requestedEmail: empRequest,
          alternateEmail: empAlternate,
          reason: empReason
        })
      });
      if (res.ok) {
        onShowSuccess('Permohonan email pribadi berhasil dikirim!');
        setEmpRequest('');
        setEmpReason('');
        fetchUserData();
        setActiveTab('history');
      } else {
        onShowError('Gagal mengirim permohonan.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  const handleEmailLembagaSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!emlInstitution || !emlRequest || !emlAlternate || !emlPic || !emlNip) {
      onShowError('Harap lengkapi semua kolom formulir.');
      return;
    }
    try {
      const res = await fetch('/api/email-lembaga', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          userId: user.id,
          userName: user.name,
          institutionName: emlInstitution,
          requestedEmail: emlRequest,
          alternateEmail: emlAlternate,
          picName: emlPic,
          picNip: emlNip
        })
      });
      if (res.ok) {
        onShowSuccess('Permohonan email lembaga berhasil dikirim!');
        setEmlInstitution('');
        setEmlRequest('');
        fetchUserData();
        setActiveTab('history');
      } else {
        onShowError('Gagal mengirim permohonan.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  const handleSubdomainSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!subDesired || !subPurpose) {
      onShowError('Harap lengkapi nama subdomain dan tujuan.');
      return;
    }
    try {
      const res = await fetch('/api/subdomain', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          userId: user.id,
          userName: user.name,
          desiredSubdomain: subDesired,
          diskSpace: subSpace,
          purpose: subPurpose
        })
      });
      if (res.ok) {
        onShowSuccess('Permintaan Subdomain & Hosting berhasil dikirim!');
        setSubDesired('');
        setSubPurpose('');
        fetchUserData();
        setActiveTab('history');
      } else {
        onShowError('Gagal mengirim permohonan.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  const handleHotspotSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!hotMac || !hotUser || !hotPurpose) {
      onShowError('Harap lengkapi Alamat MAC dan tujuan.');
      return;
    }
    try {
      const res = await fetch('/api/hotspot', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          userId: user.id,
          userName: user.name,
          deviceMac: hotMac,
          username: hotUser,
          purpose: hotPurpose
        })
      });
      if (res.ok) {
        onShowSuccess('Permohonan akses hotspot berhasil dikirim!');
        setHotMac('');
        fetchUserData();
        setActiveTab('history');
      } else {
        onShowError('Gagal mengirim permohonan.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  const handleLaporanSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!lapTitle || !lapDesc) {
      onShowError('Harap isi judul dan deskripsi aduan.');
      return;
    }
    try {
      const res = await fetch('/api/laporans', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          userId: user.id,
          userName: user.name,
          title: lapTitle,
          category: lapCategory,
          description: lapDesc
        })
      });
      if (res.ok) {
        onShowSuccess('Laporan aduan kerusakan berhasil diajukan!');
        setLapTitle('');
        setLapDesc('');
        fetchUserData();
        setActiveTab('history');
      } else {
        onShowError('Gagal mengirim laporan.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  const handleDeleteRequest = async (type: string, id: string) => {
    if (!confirm('Apakah Anda yakin ingin membatalkan/menghapus pengajuan ini?')) return;
    try {
      let endpoint = '';
      if (type === 'zoom') endpoint = `/api/zoom-requests/${id}`;
      else if (type === 'email-pribadi') endpoint = `/api/email-pribadi/${id}`;
      else if (type === 'email-lembaga') endpoint = `/api/email-lembaga/${id}`;
      else if (type === 'subdomain') endpoint = `/api/subdomain/${id}`;
      else if (type === 'hotspot') endpoint = `/api/hotspot/${id}`;
      else if (type === 'laporan') endpoint = `/api/laporans/${id}`;

      const res = await fetch(endpoint, { method: 'DELETE' });
      if (res.ok) {
        onShowSuccess('Pengajuan berhasil dibatalkan.');
        fetchUserData();
        if (selectedRequest?.id === id) setSelectedRequest(null);
      } else {
        onShowError('Gagal menghapus pengajuan.');
      }
    } catch (e) {
      onShowError('Kesalahan jaringan.');
    }
  };

  // Compile unified list for historical review
  const allRequests = [
    ...zoomList.map(item => ({ ...item, type: 'zoom', typeLabel: 'Zoom Meeting', sortKey: item.createdAt })),
    ...emailPribadiList.map(item => ({ ...item, type: 'email-pribadi', typeLabel: 'Email Pribadi', sortKey: item.createdAt })),
    ...emailLembagaList.map(item => ({ ...item, type: 'email-lembaga', typeLabel: 'Email Lembaga', sortKey: item.createdAt })),
    ...subdomainList.map(item => ({ ...item, type: 'subdomain', typeLabel: 'Subdomain & Hosting', sortKey: item.createdAt })),
    ...hotspotList.map(item => ({ ...item, type: 'hotspot', typeLabel: 'Hotspot Kampus', sortKey: item.createdAt })),
    ...laporanList.map(item => ({ ...item, type: 'laporan', typeLabel: 'Aduan Kerusakan', sortKey: item.createdAt }))
  ].sort((a, b) => new Date(b.sortKey).getTime() - new Date(a.sortKey).getTime());

  return (
    <div className="space-y-8" id="user-dashboard">
      {/* Tab Navigation header */}
      <div className="flex border-b border-slate-200">
        <button
          onClick={() => setActiveTab('overview')}
          className={`px-4 py-2.5 text-sm font-semibold border-b-2 transition-all flex items-center gap-2 ${
            activeTab === 'overview'
              ? 'border-indigo-600 text-indigo-600'
              : 'border-transparent text-slate-500 hover:text-slate-950'
          }`}
        >
          <LayoutGrid className="w-4 h-4" />
          Ringkasan Layanan
        </button>
        <button
          onClick={() => setActiveTab('apply')}
          className={`px-4 py-2.5 text-sm font-semibold border-b-2 transition-all flex items-center gap-2 ${
            activeTab === 'apply'
              ? 'border-indigo-600 text-indigo-600'
              : 'border-transparent text-slate-500 hover:text-slate-950'
          }`}
        >
          <Send className="w-4 h-4" />
          Formulir Pengajuan Baru
        </button>
        <button
          onClick={() => setActiveTab('history')}
          className={`px-4 py-2.5 text-sm font-semibold border-b-2 transition-all flex items-center gap-2 ${
            activeTab === 'history'
              ? 'border-indigo-600 text-indigo-600'
              : 'border-transparent text-slate-500 hover:text-slate-950'
          }`}
        >
          <FileText className="w-4 h-4" />
          Histori & Tracking ({totalSubmitted})
        </button>
        <button
          onClick={fetchUserData}
          className="ml-auto p-2 text-slate-400 hover:text-indigo-600 transition-colors"
          title="Sinkronkan Data"
        >
          <RefreshCw className={`w-4 h-4 ${isLoading ? 'animate-spin' : ''}`} />
        </button>
      </div>

      {/* 1. OVERVIEW TAB */}
      {activeTab === 'overview' && (
        <div className="space-y-6">
          <div className="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
              <h2 className="text-xl font-extrabold text-slate-950">Selamat Datang, {user.name}</h2>
              <p className="text-xs text-slate-600 mt-1">
                Gunakan panel ini untuk mengelola permohonan, memantau status persetujuan, dan mengklaim kredensial akun Anda.
              </p>
            </div>
            <button
              onClick={() => setActiveTab('apply')}
              className="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-md shadow-indigo-100 transition-all text-center"
            >
              + Buat Pengajuan Layanan
            </button>
          </div>

          {/* Quick Metrics */}
          <div className="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div className="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
              <div className="w-10 h-10 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                <FileText className="w-5 h-5" />
              </div>
              <div>
                <span className="text-2xs text-slate-500 font-bold block uppercase tracking-wider">Total Pengajuan</span>
                <span className="text-2xl font-extrabold text-slate-950">{totalSubmitted}</span>
              </div>
            </div>

            <div className="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
              <div className="w-10 h-10 bg-amber-50 border border-amber-100 rounded-xl flex items-center justify-center text-amber-600 shrink-0 animate-pulse">
                <Clock className="w-5 h-5" />
              </div>
              <div>
                <span className="text-2xs text-slate-500 font-bold block uppercase tracking-wider">Sedang Diproses</span>
                <span className="text-2xl font-extrabold text-slate-950">{pendingCount}</span>
              </div>
            </div>

            <div className="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
              <div className="w-10 h-10 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                <CheckCircle className="w-5 h-5" />
              </div>
              <div>
                <span className="text-2xs text-slate-500 font-bold block uppercase tracking-wider">Aktif / Selesai</span>
                <span className="text-2xl font-extrabold text-slate-950">{approvedCount}</span>
              </div>
            </div>
          </div>

          {/* Service Quick-Guides */}
          <div className="bg-indigo-950 rounded-2xl p-6 text-white space-y-4">
            <h3 className="text-base font-bold">Langkah Cepat Penanganan Layanan</h3>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs text-indigo-200">
              <div className="space-y-1">
                <span className="font-bold text-white block">1. Kirim Formulir</span>
                <p className="leading-relaxed text-indigo-100/80">
                  Isi semua parameter yang dibutuhkan pada menu pengajuan baru secara lengkap dan benar.
                </p>
              </div>
              <div className="space-y-1">
                <span className="font-bold text-white block">2. Pantau Histori</span>
                <p className="leading-relaxed text-indigo-100/80">
                  Status permohonan Anda akan terus terupdate dalam waktu maksimal 1-2 hari kerja oleh Tim UPT TIK.
                </p>
              </div>
              <div className="space-y-1">
                <span className="font-bold text-white block">3. Ambil Kredensial</span>
                <p className="leading-relaxed text-indigo-100/80">
                  Setelah berstatus "Disetujui", tombol kredensial akan muncul di histori pengajuan Anda berisi tautan/password akun.
                </p>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* 2. APPLY FORM TAB */}
      {activeTab === 'apply' && (
        <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
          {/* Sub Tab left menu */}
          <div className="lg:col-span-1 flex flex-col gap-1">
            <h3 className="text-xs font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Pilih Layanan</h3>
            {[
              { id: 'zoom', label: 'Zoom Meeting', icon: Calendar },
              { id: 'email-pribadi', label: 'Email Pribadi', icon: Mail },
              { id: 'email-lembaga', label: 'Email Lembaga', icon: Award },
              { id: 'subdomain', label: 'Subdomain & Hosting', icon: Globe },
              { id: 'hotspot', label: 'Akses Hotspot', icon: Wifi },
              { id: 'laporan', label: 'Aduan Kerusakan', icon: ShieldAlert },
            ].map(tab => {
              const Icon = tab.icon;
              return (
                <button
                  key={tab.id}
                  onClick={() => setApplySubTab(tab.id as any)}
                  className={`flex items-center gap-2.5 px-3 py-2 text-left text-sm font-semibold rounded-xl transition-all ${
                    applySubTab === tab.id
                      ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100'
                      : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                  }`}
                >
                  <Icon className="w-4 h-4" />
                  {tab.label}
                </button>
              );
            })}
          </div>

          {/* Form Content area */}
          <div className="lg:col-span-3 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
            {/* Zoom Form */}
            {applySubTab === 'zoom' && (
              <form onSubmit={handleZoomSubmit} className="space-y-6">
                <div className="border-b border-slate-100 pb-3">
                  <h3 className="text-lg font-bold text-slate-950 flex items-center gap-2">
                    <Calendar className="w-5 h-5 text-indigo-600" />
                    Formulir Pengajuan Zoom Meeting Pro
                  </h3>
                  <p className="text-xs text-slate-500 mt-1">
                    Silakan lengkapi detail pertemuan di bawah ini. Harap diajukan maksimal 2 hari sebelum acara.
                  </p>
                </div>

                <div className="space-y-4">
                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Topik Pertemuan / Agenda *</label>
                    <input
                      type="text"
                      placeholder="Contoh: Rapat Koordinasi Kurikulum Informatika"
                      value={zoomTopic}
                      onChange={(e) => setZoomTopic(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                    />
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div className="space-y-1">
                      <label className="text-xs font-semibold text-slate-700">Tanggal Pelaksanaan *</label>
                      <input
                        type="date"
                        value={zoomDate}
                        onChange={(e) => setZoomDate(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      />
                    </div>

                    <div className="space-y-1">
                      <label className="text-xs font-semibold text-slate-700">Waktu Mulai *</label>
                      <input
                        type="time"
                        value={zoomStart}
                        onChange={(e) => setZoomStart(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      />
                    </div>

                    <div className="space-y-1">
                      <label className="text-xs font-semibold text-slate-700">Waktu Selesai *</label>
                      <input
                        type="time"
                        value={zoomEnd}
                        onChange={(e) => setZoomEnd(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      />
                    </div>
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Perkiraan Jumlah Peserta ({zoomParticipants} orang)</label>
                    <input
                      type="range"
                      min="5"
                      max="100"
                      step="5"
                      value={zoomParticipants}
                      onChange={(e) => setZoomParticipants(Number(e.target.value))}
                      className="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600"
                    />
                    <span className="text-2xs text-slate-400 block">Kapasitas lisensi pro standar adalah s.d. 100 peserta.</span>
                  </div>
                </div>

                <button
                  type="submit"
                  className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-indigo-100"
                >
                  Kirim Pengajuan Zoom
                </button>
              </form>
            )}

            {/* Email Pribadi Form */}
            {applySubTab === 'email-pribadi' && (
              <form onSubmit={handleEmailPribadiSubmit} className="space-y-6">
                <div className="border-b border-slate-100 pb-3">
                  <h3 className="text-lg font-bold text-slate-950 flex items-center gap-2">
                    <Mail className="w-5 h-5 text-indigo-600" />
                    Permohonan Pembuatan Akun Email Pribadi
                  </h3>
                  <p className="text-xs text-slate-500 mt-1">
                    Ajukan pembuatan alamat email kampus resmi mahasiswa/staf dengan domain @ith.ac.id.
                  </p>
                </div>

                <div className="space-y-4">
                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Alamat Email yang Diinginkan *</label>
                    <div className="flex items-center gap-2">
                      <input
                        type="text"
                        placeholder="Contoh: budi.santoso"
                        value={empRequest}
                        onChange={(e) => setEmpRequest(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      />
                      <span className="text-sm font-bold text-slate-700">@ith.ac.id</span>
                    </div>
                    <span className="text-2xs text-slate-400 block">Nama disarankan menggunakan nama asli atau inisial formal.</span>
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Alamat Email Alternatif / Aktif Saat Ini *</label>
                    <input
                      type="email"
                      value={empAlternate}
                      onChange={(e) => setEmpAlternate(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                    />
                    <span className="text-2xs text-slate-400 block">Digunakan untuk verifikasi pemulihan kata sandi pertama kali.</span>
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Tujuan Pembuatan Email *</label>
                    <textarea
                      placeholder="Jelaskan secara singkat alasan pembuatan email (misal: pendaftaran jurnal, akun pembelajaran, atau korespondensi akademis)"
                      rows={3}
                      value={empReason}
                      onChange={(e) => setEmpReason(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none resize-none"
                    ></textarea>
                  </div>
                </div>

                <button
                  type="submit"
                  className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-indigo-100"
                >
                  Kirim Permohonan Email Pribadi
                </button>
              </form>
            )}

            {/* Email Lembaga Form */}
            {applySubTab === 'email-lembaga' && (
              <form onSubmit={handleEmailLembagaSubmit} className="space-y-6">
                <div className="border-b border-slate-100 pb-3">
                  <h3 className="text-lg font-bold text-slate-950 flex items-center gap-2">
                    <Award className="w-5 h-5 text-indigo-600" />
                    Permohonan Akun Email Lembaga / Unit Kerja
                  </h3>
                  <p className="text-xs text-slate-500 mt-1">
                    Ajukan email resmi divisi, unit administrasi, prodi, atau organisasi mahasiswa berdomain @ith.ac.id.
                  </p>
                </div>

                <div className="space-y-4">
                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Nama Lembaga / Unit Kerja Resmi *</label>
                    <input
                      type="text"
                      placeholder="Contoh: Himpunan Mahasiswa Informatika (HMIF)"
                      value={emlInstitution}
                      onChange={(e) => setEmlInstitution(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                    />
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Alamat Email Lembaga yang Diinginkan *</label>
                    <div className="flex items-center gap-2">
                      <input
                        type="text"
                        placeholder="Contoh: hmif"
                        value={emlRequest}
                        onChange={(e) => setEmlRequest(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      />
                      <span className="text-sm font-bold text-slate-700">@ith.ac.id</span>
                    </div>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="space-y-1">
                      <label className="text-xs font-semibold text-slate-700">Nama Penanggung Jawab (PIC) *</label>
                      <input
                        type="text"
                        value={emlPic}
                        onChange={(e) => setEmlPic(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      />
                    </div>

                    <div className="space-y-1">
                      <label className="text-xs font-semibold text-slate-700">NIP / NIM / NIK PIC *</label>
                      <input
                        type="text"
                        value={emlNip}
                        onChange={(e) => setEmlNip(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      />
                    </div>
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Alamat Email Penanggung Jawab *</label>
                    <input
                      type="email"
                      value={emlAlternate}
                      onChange={(e) => setEmlAlternate(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                    />
                  </div>
                </div>

                <button
                  type="submit"
                  className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-indigo-100"
                >
                  Kirim Permohonan Email Lembaga
                </button>
              </form>
            )}

            {/* Subdomain Form */}
            {applySubTab === 'subdomain' && (
              <form onSubmit={handleSubdomainSubmit} className="space-y-6">
                <div className="border-b border-slate-100 pb-3">
                  <h3 className="text-lg font-bold text-slate-950 flex items-center gap-2">
                    <Globe className="w-5 h-5 text-indigo-600" />
                    Pengajuan Subdomain & Web Hosting Kampus
                  </h3>
                  <p className="text-xs text-slate-500 mt-1">
                    Dapatkan ruang hosting cloud beserta alamat subdomain (.ith.ac.id) untuk meluncurkan situs web organisasi Anda.
                  </p>
                </div>

                <div className="space-y-4">
                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Alamat Subdomain yang Diinginkan *</label>
                    <div className="flex items-center gap-2">
                      <input
                        type="text"
                        placeholder="Contoh: hmif"
                        value={subDesired}
                        onChange={(e) => setSubDesired(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      />
                      <span className="text-sm font-bold text-slate-700">.ith.ac.id</span>
                    </div>
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Estimasi Kapasitas Disk Space *</label>
                    <select
                      value={subSpace}
                      onChange={(e) => setSubSpace(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                    >
                      <option value="100MB">100 Megabyte (Web Statis Sederhana)</option>
                      <option value="500MB">500 Megabyte (Organisasi Standar)</option>
                      <option value="1GB">1 Gigabyte (Aplikasi / Portal Menengah)</option>
                    </select>
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Deskripsi / Tujuan Situs Web *</label>
                    <textarea
                      placeholder="Jelaskan fungsionalitas dan jenis konten yang akan diunggah pada situs web ini..."
                      rows={4}
                      value={subPurpose}
                      onChange={(e) => setSubPurpose(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none resize-none"
                    ></textarea>
                  </div>
                </div>

                <button
                  type="submit"
                  className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-indigo-100"
                >
                  Kirim Pengajuan Subdomain
                </button>
              </form>
            )}

            {/* Hotspot Form */}
            {applySubTab === 'hotspot' && (
              <form onSubmit={handleHotspotSubmit} className="space-y-6">
                <div className="border-b border-slate-100 pb-3">
                  <h3 className="text-lg font-bold text-slate-950 flex items-center gap-2">
                    <Wifi className="w-5 h-5 text-indigo-600" />
                    Pendaftaran Alamat MAC Hotspot Kampus
                  </h3>
                  <p className="text-xs text-slate-500 mt-1">
                    Daftarkan alamat MAC fisik laptop atau HP Anda untuk mendapatkan kredensial bypass login portal wifi kampus.
                  </p>
                </div>

                <div className="space-y-4">
                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Alamat MAC Fisik Perangkat *</label>
                    <input
                      type="text"
                      placeholder="Format: 00:1A:2B:3C:4D:5E atau 00-1A-2B-3C-4D-5E"
                      value={hotMac}
                      onChange={(e) => setHotMac(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                    />
                    <span className="text-2xs text-slate-400 block">Dapat dilihat di pengaturan Wi-Fi Status atau Properties pada perangkat Anda.</span>
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Username Wifi yang Diinginkan *</label>
                    <input
                      type="text"
                      value={hotUser}
                      onChange={(e) => setHotUser(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                    />
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Tujuan Pendaftaran *</label>
                    <input
                      type="text"
                      value={hotPurpose}
                      onChange={(e) => setHotPurpose(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                    />
                  </div>
                </div>

                <button
                  type="submit"
                  className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-indigo-100"
                >
                  Kirim Permohonan Hotspot
                </button>
              </form>
            )}

            {/* Laporan / Complaint Form */}
            {applySubTab === 'laporan' && (
              <form onSubmit={handleLaporanSubmit} className="space-y-6">
                <div className="border-b border-slate-100 pb-3">
                  <h3 className="text-lg font-bold text-slate-950 flex items-center gap-2">
                    <ShieldAlert className="w-5 h-5 text-indigo-600" />
                    Pengaduan Gangguan / Kerusakan Layanan IT
                  </h3>
                  <p className="text-xs text-slate-500 mt-1">
                    Kirimkan aduan kerusakan wifi, jaringan internet, access point lab komputer, atau sistem portal yang error.
                  </p>
                </div>

                <div className="space-y-4">
                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Judul Laporan Kendala *</label>
                    <input
                      type="text"
                      placeholder="Contoh: Lampu indikator Wifi Lab Komputer II padam"
                      value={lapTitle}
                      onChange={(e) => setLapTitle(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                    />
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Kategori Gangguan *</label>
                    <select
                      value={lapCategory}
                      onChange={(e) => setLapCategory(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                    >
                      <option value="Network">Network / Akses Internet Wifi</option>
                      <option value="Hardware">Hardware / Perangkat Komputer Lab</option>
                      <option value="Software">Software / Aplikasi Portal Akademik</option>
                      <option value="Service">Pelayanan Teknis / Lain-Lain</option>
                    </select>
                  </div>

                  <div className="space-y-1">
                    <label className="text-xs font-semibold text-slate-700">Kronologi / Deskripsi Masalah Lengkap *</label>
                    <textarea
                      placeholder="Tuliskan sedetail mungkin letak gedung, ruangan, nama perangkat, serta gejala kendala yang dialami agar mempercepat tim teknisi melakukan investigasi..."
                      rows={5}
                      value={lapDesc}
                      onChange={(e) => setLapDesc(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none resize-none"
                    ></textarea>
                  </div>
                </div>

                <button
                  type="submit"
                  className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-indigo-100"
                >
                  Kirim Pengaduan Gangguan
                </button>
              </form>
            )}
          </div>
        </div>
      )}

      {/* 3. HISTORI TAB */}
      {activeTab === 'history' && (
        <div className="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
          <div className="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
              <h3 className="text-base font-bold text-slate-950">Histori Pengajuan Layanan Anda</h3>
              <p className="text-xs text-slate-500 mt-1">
                Lacak perkembangan tiket aduan dan klaim kredensial untuk permohonan yang telah disetujui.
              </p>
            </div>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left border-collapse text-sm">
              <thead>
                <tr className="bg-slate-50 text-slate-500 text-xs font-bold border-b border-slate-150">
                  <th className="px-6 py-4">ID & Tanggal</th>
                  <th className="px-6 py-4">Layanan</th>
                  <th className="px-6 py-4">Subjek / Detail</th>
                  <th className="px-6 py-4">Status</th>
                  <th className="px-6 py-4 text-center">Tindakan</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100">
                {allRequests.map((req: any, idx) => {
                  let statusBadgeColor = 'bg-amber-50 text-amber-700 border-amber-100';
                  let statusText = 'Pending';
                  if (req.status === 'disetujui' || req.status === 'selesai') {
                    statusBadgeColor = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                    statusText = 'Disetujui';
                  } else if (req.status === 'ditolak') {
                    statusBadgeColor = 'bg-rose-50 text-rose-700 border-rose-100';
                    statusText = 'Ditolak';
                  } else if (req.status === 'diproses') {
                    statusBadgeColor = 'bg-blue-50 text-blue-700 border-blue-100';
                    statusText = 'Diproses';
                  } else if (req.status === 'zoom_disabled' || req.status === 'domain_disabled') {
                    statusBadgeColor = 'bg-slate-50 text-slate-500 border-slate-150';
                    statusText = 'Nonaktif';
                  }

                  return (
                    <tr key={idx} className="hover:bg-slate-50/50 transition-all">
                      <td className="px-6 py-4">
                        <span className="font-bold text-slate-900 block">{req.id.toUpperCase()}</span>
                        <span className="text-2xs text-slate-400 font-medium block">
                          {new Date(req.createdAt).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                          })}
                        </span>
                      </td>
                      <td className="px-6 py-4">
                        <span className="font-semibold text-indigo-700 text-xs bg-indigo-50/50 px-2 py-1 rounded-md border border-indigo-100">
                          {req.typeLabel}
                        </span>
                      </td>
                      <td className="px-6 py-4 max-w-[280px]">
                        <span className="font-bold text-slate-900 line-clamp-1">
                          {req.topic || req.requestedEmail || req.desiredSubdomain || req.deviceMac || req.title}
                        </span>
                        <span className="text-2xs text-slate-500 font-medium line-clamp-1 mt-0.5">
                          {req.reason || req.purpose || req.category || 'Akses Portal'}
                        </span>
                      </td>
                      <td className="px-6 py-4">
                        <span className={`inline-flex px-2 py-0.5 text-2xs font-bold rounded-md border ${statusBadgeColor}`}>
                          {statusText}
                        </span>
                      </td>
                      <td className="px-6 py-4 text-center">
                        <div className="flex justify-center items-center gap-2">
                          <button
                            onClick={() => setSelectedRequest(req)}
                            className="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-all"
                          >
                            Detail
                          </button>
                          {req.status === 'pending' && (
                            <button
                              onClick={() => handleDeleteRequest(req.type, req.id)}
                              className="p-1 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all"
                              title="Batalkan Pengajuan"
                            >
                              <Trash className="w-4 h-4" />
                            </button>
                          )}
                        </div>
                      </td>
                    </tr>
                  );
                })}
                {allRequests.length === 0 && (
                  <tr>
                    <td colSpan={5} className="text-center py-12 text-slate-400 text-xs">
                      Belum ada histori pengajuan yang dikirimkan.
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Detail Modal Overlay */}
      {selectedRequest && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
          <div className="bg-white border border-slate-200 rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl animate-in fade-in zoom-in-95 duration-200">
            <div className="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
              <div>
                <span className="text-2xs font-bold text-indigo-600 uppercase tracking-wide">
                  Detail {selectedRequest.typeLabel}
                </span>
                <h3 className="text-base font-extrabold text-slate-950 mt-0.5">{selectedRequest.id.toUpperCase()}</h3>
              </div>
              <button
                onClick={() => setSelectedRequest(null)}
                className="w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-200 text-slate-500 font-bold transition-all"
              >
                &times;
              </button>
            </div>

            <div className="px-6 py-6 space-y-4 max-h-[420px] overflow-y-auto">
              {/* General details based on types */}
              {selectedRequest.type === 'zoom' && (
                <>
                  <div className="grid grid-cols-2 gap-4 text-xs">
                    <div>
                      <span className="text-slate-400 font-semibold block">Topik Agenda</span>
                      <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.topic}</span>
                    </div>
                    <div>
                      <span className="text-slate-400 font-semibold block">Tanggal</span>
                      <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.date}</span>
                    </div>
                    <div>
                      <span className="text-slate-400 font-semibold block">Waktu</span>
                      <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.startTime} s.d. {selectedRequest.endTime}</span>
                    </div>
                    <div>
                      <span className="text-slate-400 font-semibold block">Peserta</span>
                      <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.participants} Orang</span>
                    </div>
                  </div>
                </>
              )}

              {selectedRequest.type === 'email-pribadi' && (
                <>
                  <div className="space-y-3 text-xs">
                    <div>
                      <span className="text-slate-400 font-semibold block">Email yang Dimohon</span>
                      <span className="text-slate-900 font-bold mt-0.5 block text-sm">{selectedRequest.requestedEmail}@ith.ac.id</span>
                    </div>
                    <div>
                      <span className="text-slate-400 font-semibold block">Email Alternatif</span>
                      <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.alternateEmail}</span>
                    </div>
                    <div>
                      <span className="text-slate-400 font-semibold block">Alasan Pengajuan</span>
                      <p className="text-slate-600 bg-slate-50 border border-slate-100 p-2 rounded-xl leading-relaxed mt-1">
                        {selectedRequest.reason}
                      </p>
                    </div>
                  </div>
                </>
              )}

              {selectedRequest.type === 'email-lembaga' && (
                <>
                  <div className="space-y-3 text-xs">
                    <div>
                      <span className="text-slate-400 font-semibold block">Nama Unit / Lembaga</span>
                      <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.institutionName}</span>
                    </div>
                    <div>
                      <span className="text-slate-400 font-semibold block">Email Lembaga</span>
                      <span className="text-slate-900 font-bold mt-0.5 block text-sm">{selectedRequest.requestedEmail}@ith.ac.id</span>
                    </div>
                    <div className="grid grid-cols-2 gap-3">
                      <div>
                        <span className="text-slate-400 font-semibold block">Nama PIC</span>
                        <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.picName}</span>
                      </div>
                      <div>
                        <span className="text-slate-400 font-semibold block">NIP PIC</span>
                        <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.picNip}</span>
                      </div>
                    </div>
                  </div>
                </>
              )}

              {selectedRequest.type === 'subdomain' && (
                <>
                  <div className="space-y-3 text-xs">
                    <div className="grid grid-cols-2 gap-3">
                      <div>
                        <span className="text-slate-400 font-semibold block">Subdomain</span>
                        <span className="text-slate-900 font-bold mt-0.5 block text-sm">{selectedRequest.desiredSubdomain}.ith.ac.id</span>
                      </div>
                      <div>
                        <span className="text-slate-400 font-semibold block">Disk Space</span>
                        <span className="text-indigo-600 font-bold mt-0.5 block text-sm">{selectedRequest.diskSpace}</span>
                      </div>
                    </div>
                    <div>
                      <span className="text-slate-400 font-semibold block">Tujuan & Fungsi Website</span>
                      <p className="text-slate-600 bg-slate-50 border border-slate-100 p-2 rounded-xl leading-relaxed mt-1">
                        {selectedRequest.purpose}
                      </p>
                    </div>
                  </div>
                </>
              )}

              {selectedRequest.type === 'hotspot' && (
                <>
                  <div className="grid grid-cols-2 gap-4 text-xs">
                    <div>
                      <span className="text-slate-400 font-semibold block">MAC Address Perangkat</span>
                      <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.deviceMac}</span>
                    </div>
                    <div>
                      <span className="text-slate-400 font-semibold block">Wifi Username</span>
                      <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.username}</span>
                    </div>
                  </div>
                </>
              )}

              {selectedRequest.type === 'laporan' && (
                <>
                  <div className="space-y-3 text-xs">
                    <div className="grid grid-cols-2 gap-3">
                      <div>
                        <span className="text-slate-400 font-semibold block">Kode Tiket</span>
                        <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.ticketCode}</span>
                      </div>
                      <div>
                        <span className="text-slate-400 font-semibold block">Kategori</span>
                        <span className="text-indigo-600 font-bold mt-0.5 block">{selectedRequest.category}</span>
                      </div>
                    </div>
                    <div>
                      <span className="text-slate-400 font-semibold block">Judul Masalah</span>
                      <span className="text-slate-900 font-bold mt-0.5 block">{selectedRequest.title}</span>
                    </div>
                    <div>
                      <span className="text-slate-400 font-semibold block">Kronologi Kejadian</span>
                      <p className="text-slate-600 bg-slate-50 border border-slate-100 p-2 rounded-xl leading-relaxed mt-1 max-h-[120px] overflow-y-auto">
                        {selectedRequest.description}
                      </p>
                    </div>
                  </div>
                </>
              )}

              {/* Action/Credential status layout */}
              <div className="border-t border-slate-100 pt-4">
                {selectedRequest.status === 'pending' && (
                  <div className="p-3 bg-amber-50 border border-amber-100 rounded-xl flex items-center gap-2.5 text-xs text-amber-800">
                    <Clock className="w-4 h-4 text-amber-600" />
                    <span>Permohonan sedang antre menunggu persetujuan verifikasi oleh Administrator.</span>
                  </div>
                )}

                {selectedRequest.status === 'ditolak' && (
                  <div className="p-3 bg-rose-50 border border-rose-100 rounded-xl text-xs text-rose-800 space-y-1">
                    <span className="font-bold block">Alasan Penolakan Admin:</span>
                    <p className="leading-relaxed">{selectedRequest.reasonAdmin || selectedRequest.reason || 'Tidak memenuhi kualifikasi data.'}</p>
                  </div>
                )}

                {(selectedRequest.status === 'disetujui' || selectedRequest.status === 'selesai' || selectedRequest.status === 'diproses') && (
                  <div className="bg-emerald-50 border border-emerald-100 rounded-xl p-4 text-xs text-emerald-800 space-y-3">
                    <div className="flex items-center gap-2 font-bold text-emerald-950">
                      <Key className="w-4 h-4 text-emerald-600" />
                      <span>{selectedRequest.type === 'laporan' ? 'Tanggapan / Catatan Penyelesaian:' : 'Kredensial & Tautan Akses:'}</span>
                    </div>

                    {selectedRequest.type === 'laporan' && (
                      <p className="leading-relaxed bg-white border border-emerald-100 p-2.5 rounded-lg text-slate-700">
                        {selectedRequest.notesAdmin || 'Aduan dalam penanganan divisi teknisi jaringan.'}
                      </p>
                    )}

                    {selectedRequest.type === 'zoom' && selectedRequest.credentials && (
                      <div className="space-y-1.5 bg-white border border-emerald-100 p-2.5 rounded-lg text-slate-700 font-medium">
                        <span className="text-slate-400 text-2xs block">Link Rapat Zoom</span>
                        <a href={selectedRequest.credentials.link} target="_blank" rel="noopener noreferrer" className="text-indigo-600 hover:underline flex items-center gap-1 mb-1">
                          Masuk Pertemuan Zoom <ExternalLink className="w-3.5 h-3.5" />
                        </a>
                        <span className="text-slate-400 text-2xs block">Meeting ID</span>
                        <span className="font-bold text-slate-900 block">{selectedRequest.credentials.meetingId}</span>
                        <span className="text-slate-400 text-2xs block">Passcode</span>
                        <span className="font-bold text-slate-900 block">{selectedRequest.credentials.passcode}</span>
                      </div>
                    )}

                    {(selectedRequest.type === 'email-pribadi' || selectedRequest.type === 'email-lembaga') && selectedRequest.credentials && (
                      <div className="space-y-1.5 bg-white border border-emerald-100 p-2.5 rounded-lg text-slate-700 font-medium">
                        <span className="text-slate-400 text-2xs block">Email Kampus Baru</span>
                        <span className="font-bold text-indigo-700 block">{selectedRequest.credentials.email}@ith.ac.id</span>
                        <span className="text-slate-400 text-2xs block">Password Sementara</span>
                        <span className="font-bold text-slate-900 block">{selectedRequest.credentials.passwordInitial}</span>
                      </div>
                    )}

                    {selectedRequest.type === 'subdomain' && selectedRequest.credentials && (
                      <div className="space-y-1.5 bg-white border border-emerald-100 p-2.5 rounded-lg text-slate-700 font-medium">
                        <span className="text-slate-400 text-2xs block">Alamat Website Subdomain</span>
                        <a href={selectedRequest.credentials.url} target="_blank" rel="noopener noreferrer" className="text-indigo-600 hover:underline flex items-center gap-1 mb-1">
                          {selectedRequest.credentials.url} <ExternalLink className="w-3.5 h-3.5" />
                        </a>
                        <span className="text-slate-400 text-2xs block">Kredensial Panel Hosting (Username)</span>
                        <span className="font-bold text-slate-900 block">{selectedRequest.credentials.username}</span>
                        <span className="text-slate-400 text-2xs block">Password Sementara</span>
                        <span className="font-bold text-slate-900 block">{selectedRequest.credentials.passwordInitial}</span>
                      </div>
                    )}

                    {selectedRequest.type === 'hotspot' && selectedRequest.credentials && (
                      <div className="space-y-1.5 bg-white border border-emerald-100 p-2.5 rounded-lg text-slate-700 font-medium">
                        <span className="text-slate-400 text-2xs block">Hotspot Wifi Username</span>
                        <span className="font-bold text-indigo-600 block">{selectedRequest.credentials.wifiUsername}</span>
                        <span className="text-slate-400 text-2xs block">Password</span>
                        <span className="font-bold text-slate-900 block">{selectedRequest.credentials.passwordInitial}</span>
                      </div>
                    )}
                  </div>
                )}
              </div>
            </div>

            <div className="px-6 py-4 bg-slate-50 border-t border-slate-100 text-right">
              <button
                onClick={() => setSelectedRequest(null)}
                className="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition-all"
              >
                Tutup Detail
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
