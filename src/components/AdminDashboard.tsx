import React, { useState, useEffect } from 'react';
import { User, Announcement, Activity, ZoomRequest, EmailPribadiRequest, EmailLembagaRequest, SubdomainRequest, HotspotRequest, LaporanRequest, Faq, Fasilitas } from '../types';
import { Check, X, Shield, Users, Radio, MessageSquare, Plus, Trash, Edit, RefreshCw, Key, ArrowRight, Settings, FileText } from 'lucide-react';

interface AdminDashboardProps {
  user: User;
  onShowSuccess: (msg: string) => void;
  onShowError: (msg: string) => void;
}

export default function AdminDashboard({ user, onShowSuccess, onShowError }: AdminDashboardProps) {
  const [activeTab, setActiveTab] = useState<'requests' | 'users' | 'content'>('requests');
  const [requestSubTab, setRequestSubTab] = useState<'zoom' | 'emails' | 'subdomain' | 'hotspot' | 'laporan'>('zoom');
  const [contentSubTab, setContentSubTab] = useState<'announcements' | 'activities' | 'faqs' | 'facilities'>('announcements');

  const [isLoading, setIsLoading] = useState(false);

  // Loaded database items
  const [users, setUsers] = useState<User[]>([]);
  const [zoomList, setZoomList] = useState<ZoomRequest[]>([]);
  const [emailPribadiList, setEmailPribadiList] = useState<EmailPribadiRequest[]>([]);
  const [emailLembagaList, setEmailLembagaList] = useState<EmailLembagaRequest[]>([]);
  const [subdomainList, setSubdomainList] = useState<SubdomainRequest[]>([]);
  const [hotspotList, setHotspotList] = useState<HotspotRequest[]>([]);
  const [laporanList, setLaporanList] = useState<LaporanRequest[]>([]);
  const [announcements, setAnnouncements] = useState<Announcement[]>([]);
  const [activities, setActivities] = useState<Activity[]>([]);
  const [faqs, setFaqs] = useState<Faq[]>([]);
  const [facilities, setFacilities] = useState<Fasilitas[]>([]);

  // Modals for approval/rejection/action
  const [activeActionReq, setActiveActionReq] = useState<{ type: string; req: any; action: 'approve' | 'reject' | 'update_laporan' } | null>(null);

  // Inputs for action modals
  const [actionReason, setActionReason] = useState('');
  const [actionZoomLink, setActionZoomLink] = useState('https://zoom.us/j/1234567890');
  const [actionZoomId, setActionZoomId] = useState('123 456 7890');
  const [actionZoomPass, setActionZoomPass] = useState('pass123');
  const [actionEmailResult, setActionEmailResult] = useState('');
  const [actionEmailPass, setActionEmailPass] = useState('p@ssword99');
  const [actionSubdomainUrl, setActionSubdomainUrl] = useState('');
  const [actionSubdomainUser, setActionSubdomainUser] = useState('');
  const [actionSubdomainPass, setActionSubdomainPass] = useState('hostPass77');
  const [actionHotspotUser, setActionHotspotUser] = useState('');
  const [actionHotspotPass, setActionHotspotPass] = useState('wifiPass123');
  const [actionLaporanStatus, setActionLaporanStatus] = useState<'pending' | 'diproses' | 'selesai'>('diproses');
  const [actionLaporanNotes, setActionLaporanNotes] = useState('');

  // Creation panel state for Content
  const [showCreateContentModal, setShowCreateContentModal] = useState<string | null>(null); // 'ann' | 'act' | 'faq' | 'fas'
  const [contentTitle, setContentTitle] = useState('');
  const [contentBody, setContentBody] = useState('');
  const [contentCategory, setContentCategory] = useState('Penting');
  const [contentExtra, setContentExtra] = useState(''); // Image Url or Condition or FAQ Answer

  const fetchAdminData = async () => {
    setIsLoading(true);
    try {
      const [usr, zm, emp, eml, sub, hot, lap, ann, act, fq, fas] = await Promise.all([
        fetch('/api/admin/users').then(r => r.json()),
        fetch('/api/zoom-requests').then(r => r.json()),
        fetch('/api/email-pribadi').then(r => r.json()),
        fetch('/api/email-lembaga').then(r => r.json()),
        fetch('/api/subdomain').then(r => r.json()),
        fetch('/api/hotspot').then(r => r.json()),
        fetch('/api/laporans').then(r => r.json()),
        fetch('/api/announcements').then(r => r.json()),
        fetch('/api/activities').then(r => r.json()),
        fetch('/api/content/faqs').then(r => r.json()),
        fetch('/api/content/fasilitas').then(r => r.json()),
      ]);

      setUsers(usr || []);
      setZoomList(zm || []);
      setEmailPribadiList(emp || []);
      setEmailLembagaList(eml || []);
      setSubdomainList(sub || []);
      setHotspotList(hot || []);
      setLaporanList(lap || []);
      setAnnouncements(ann || []);
      setActivities(act || []);
      setFaqs(fq || []);
      setFacilities(fas || []);
    } catch (e) {
      onShowError('Gagal memuat panel administrasi.');
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchAdminData();
  }, []);

  // Global counts for badges
  const totalPending = 
    zoomList.filter(z => z.status === 'pending').length +
    emailPribadiList.filter(e => e.status === 'pending').length +
    emailLembagaList.filter(e => e.status === 'pending').length +
    subdomainList.filter(s => s.status === 'pending').length +
    hotspotList.filter(h => h.status === 'pending').length +
    laporanList.filter(l => l.status === 'pending').length;

  const totalUsersCount = users.length;

  // Initialize Modal Inputs based on request
  const openActionModal = (type: string, req: any, action: 'approve' | 'reject' | 'update_laporan') => {
    setActionReason('');
    if (type === 'zoom') {
      setActionZoomLink(`https://zoom.us/j/${Math.floor(100000000 + Math.random() * 900000000)}?pwd=ith`);
      setActionZoomId(`${Math.floor(100 + Math.random() * 900)} ${Math.floor(100 + Math.random() * 900)} ${Math.floor(1000 + Math.random() * 9000)}`);
      setActionZoomPass(`ith${Math.floor(100 + Math.random() * 900)}`);
    } else if (type === 'email-pribadi') {
      setActionEmailResult(`${req.requestedEmail}`);
      setActionEmailPass(`itsp${Math.floor(1000 + Math.random() * 9000)}`);
    } else if (type === 'email-lembaga') {
      setActionEmailResult(`${req.requestedEmail}`);
      setActionEmailPass(`lembaga${Math.floor(1000 + Math.random() * 9000)}`);
    } else if (type === 'subdomain') {
      setActionSubdomainUrl(`https://${req.desiredSubdomain}.ith.ac.id`);
      setActionSubdomainUser(`admin_${req.desiredSubdomain}`);
      setActionSubdomainPass(`host${Math.floor(10000 + Math.random() * 90000)}`);
    } else if (type === 'hotspot') {
      setActionHotspotUser(req.username);
      setActionHotspotPass(`wifi${Math.floor(10000 + Math.random() * 90000)}`);
    } else if (type === 'laporan') {
      setActionLaporanStatus(req.status);
      setActionLaporanNotes(req.notesAdmin || '');
    }

    setActiveActionReq({ type, req, action });
  };

  // Submit approvals / rejections
  const handleRequestAction = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!activeActionReq) return;

    const { type, req, action } = activeActionReq;
    let endpoint = '';
    let body: any = {};

    if (type === 'zoom') {
      endpoint = `/api/zoom-requests/${req.id}/action`;
      body = {
        status: action === 'approve' ? 'disetujui' : 'ditolak',
        reason: action === 'reject' ? actionReason : '',
        credentials: action === 'approve' ? {
          link: actionZoomLink,
          meetingId: actionZoomId,
          passcode: actionZoomPass
        } : undefined
      };
    } else if (type === 'email-pribadi') {
      endpoint = `/api/email-pribadi/${req.id}/action`;
      body = {
        status: action === 'approve' ? 'disetujui' : 'ditolak',
        reasonAdmin: action === 'reject' ? actionReason : '',
        credentials: action === 'approve' ? {
          email: actionEmailResult,
          passwordInitial: actionEmailPass
        } : undefined
      };
    } else if (type === 'email-lembaga') {
      endpoint = `/api/email-lembaga/${req.id}/action`;
      body = {
        status: action === 'approve' ? 'disetujui' : 'ditolak',
        reasonAdmin: action === 'reject' ? actionReason : '',
        credentials: action === 'approve' ? {
          email: actionEmailResult,
          passwordInitial: actionEmailPass
        } : undefined
      };
    } else if (type === 'subdomain') {
      endpoint = `/api/subdomain/${req.id}/action`;
      body = {
        status: action === 'approve' ? 'disetujui' : 'ditolak',
        reasonAdmin: action === 'reject' ? actionReason : '',
        credentials: action === 'approve' ? {
          url: actionSubdomainUrl,
          username: actionSubdomainUser,
          passwordInitial: actionSubdomainPass
        } : undefined
      };
    } else if (type === 'hotspot') {
      endpoint = `/api/hotspot/${req.id}/action`;
      body = {
        status: action === 'approve' ? 'disetujui' : 'ditolak',
        reasonAdmin: action === 'reject' ? actionReason : '',
        credentials: action === 'approve' ? {
          wifiUsername: actionHotspotUser,
          passwordInitial: actionHotspotPass
        } : undefined
      };
    } else if (type === 'laporan') {
      endpoint = `/api/laporans/${req.id}/status`;
      body = {
        status: actionLaporanStatus,
        notesAdmin: actionLaporanNotes
      };
    }

    try {
      const res = await fetch(endpoint, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
      });
      if (res.ok) {
        onShowSuccess(`Permohonan berhasil di${action === 'approve' ? 'setujui' : 'proses'}.`);
        setActiveActionReq(null);
        fetchAdminData();
      } else {
        onShowError('Gagal memproses keputusan.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  // Delete requests (Admin-override)
  const handleDeleteRequest = async (type: string, id: string) => {
    if (!confirm('Apakah Anda yakin ingin menghapus arsip pengajuan ini permanen dari sistem?')) return;
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
        onShowSuccess('Pengajuan berhasil dihapus.');
        fetchAdminData();
      } else {
        onShowError('Gagal menghapus arsip.');
      }
    } catch (e) {
      onShowError('Kesalahan jaringan.');
    }
  };

  // User deletion / Role change
  const handleDeleteUser = async (userId: string) => {
    if (!confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?')) return;
    try {
      const res = await fetch(`/api/admin/users/${userId}`, { method: 'DELETE' });
      if (res.ok) {
        onShowSuccess('Pengguna berhasil dihapus.');
        fetchAdminData();
      } else {
        onShowError('Gagal menghapus pengguna.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  const handleChangeUserRole = async (userId: string, newRole: 'user' | 'operator' | 'admin') => {
    try {
      const res = await fetch(`/api/admin/users/${userId}/role`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ role: newRole })
      });
      if (res.ok) {
        onShowSuccess('Hak akses pengguna berhasil diperbarui!');
        fetchAdminData();
      } else {
        onShowError('Gagal mengubah hak akses.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  // Content Publication
  const handleCreateContent = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!contentTitle || !contentBody) {
      onShowError('Harap lengkapi judul dan konten.');
      return;
    }

    let endpoint = '';
    let body: any = {};

    if (showCreateContentModal === 'ann') {
      endpoint = '/api/announcements';
      body = { title: contentTitle, content: contentBody, category: contentCategory };
    } else if (showCreateContentModal === 'act') {
      endpoint = '/api/activities';
      body = { title: contentTitle, content: contentBody, imageUrl: contentExtra };
    } else if (showCreateContentModal === 'faq') {
      endpoint = '/api/content/faqs';
      body = { question: contentTitle, answer: contentBody, category: contentCategory };
    } else if (showCreateContentModal === 'fas') {
      endpoint = '/api/content/fasilitas';
      body = { name: contentTitle, description: contentBody, condition: contentCategory };
    }

    try {
      const res = await fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
      });
      if (res.ok) {
        onShowSuccess('Item konten berhasil dipublikasikan!');
        setShowCreateContentModal(null);
        setContentTitle('');
        setContentBody('');
        setContentExtra('');
        fetchAdminData();
      } else {
        onShowError('Gagal mempublikasikan konten.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  const handleDeleteContent = async (type: string, id: string) => {
    if (!confirm('Yakin ingin menghapus item konten ini?')) return;
    try {
      let endpoint = '';
      if (type === 'ann') endpoint = `/api/announcements/${id}`;
      else if (type === 'act') endpoint = `/api/activities/${id}`;
      else if (type === 'faq') endpoint = `/api/content/faqs/${id}`;
      else if (type === 'fas') endpoint = `/api/content/fasilitas/${id}`;

      const res = await fetch(endpoint, { method: 'DELETE' });
      if (res.ok) {
        onShowSuccess('Konten berhasil dihapus.');
        fetchAdminData();
      } else {
        onShowError('Gagal menghapus konten.');
      }
    } catch (err) {
      onShowError('Kesalahan jaringan.');
    }
  };

  return (
    <div className="space-y-8" id="admin-dashboard">
      {/* Top Banner Status */}
      <div className="bg-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <span className="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-indigo-500/30 border border-indigo-400/30 text-indigo-200 text-xs font-semibold rounded-full uppercase tracking-wider mb-2">
            Panel Administrator TIK
          </span>
          <h2 className="text-xl sm:text-2xl font-extrabold tracking-tight">Konsol Manajemen HITSP Portal</h2>
          <p className="text-xs text-indigo-200/80 mt-1 max-w-xl">
            Tinjau seluruh pengajuan lisensi Zoom, alamat IP/subdomain, email resmi sivitas, pendaftaran MAC perangkat wifi, aduan kerusakan, serta sunting pengumuman publik.
          </p>
        </div>

        <div className="flex gap-4 shrink-0">
          <div className="px-4 py-3 bg-white/10 rounded-xl text-center min-w-[80px]">
            <span className="text-2xs text-indigo-200 font-bold block">Antrean Pending</span>
            <span className="text-xl font-bold text-amber-300">{totalPending}</span>
          </div>
          <div className="px-4 py-3 bg-white/10 rounded-xl text-center min-w-[80px]">
            <span className="text-2xs text-indigo-200 font-bold block">Pengguna Aktif</span>
            <span className="text-xl font-bold text-white">{totalUsersCount}</span>
          </div>
          <button
            onClick={fetchAdminData}
            className="p-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all self-center"
            title="Refresh Data"
          >
            <RefreshCw className={`w-5 h-5 ${isLoading ? 'animate-spin' : ''}`} />
          </button>
        </div>
      </div>

      {/* Primary Section tab navigation */}
      <div className="flex border-b border-slate-200">
        <button
          onClick={() => setActiveTab('requests')}
          className={`px-4 py-3 text-sm font-semibold border-b-2 transition-all flex items-center gap-2 ${
            activeTab === 'requests' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-950'
          }`}
        >
          <Radio className="w-4 h-4" />
          Antrean Pengajuan ({totalPending})
        </button>

        {user.role === 'admin' && (
          <>
            <button
              onClick={() => setActiveTab('users')}
              className={`px-4 py-3 text-sm font-semibold border-b-2 transition-all flex items-center gap-2 ${
                activeTab === 'users' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-950'
              }`}
            >
              <Users className="w-4 h-4" />
              Kelola Pengguna ({totalUsersCount})
            </button>

            <button
              onClick={() => setActiveTab('content')}
              className={`px-4 py-3 text-sm font-semibold border-b-2 transition-all flex items-center gap-2 ${
                activeTab === 'content' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-950'
              }`}
            >
              <Settings className="w-4 h-4" />
              Manajemen Konten Portal
            </button>
          </>
        )}
      </div>

      {/* ==================== 1. REQUESTS PIPELINE TAB ==================== */}
      {activeTab === 'requests' && (
        <div className="space-y-6">
          {/* Sub menu tabs for specific services */}
          <div className="flex flex-wrap gap-2 border-b border-slate-100 pb-3">
            {[
              { id: 'zoom', label: 'Zoom Meeting', count: zoomList.filter(z => z.status === 'pending').length },
              { id: 'emails', label: 'Permohonan Email', count: emailPribadiList.filter(e => e.status === 'pending').length + emailLembagaList.filter(e => e.status === 'pending').length },
              { id: 'subdomain', label: 'Subdomain & Hosting', count: subdomainList.filter(s => s.status === 'pending').length },
              { id: 'hotspot', label: 'Akses Hotspot MAC', count: hotspotList.filter(h => h.status === 'pending').length },
              { id: 'laporan', label: 'Aduan Kerusakan', count: laporanList.filter(l => l.status === 'pending').length },
            ].map(tab => (
              <button
                key={tab.id}
                onClick={() => setRequestSubTab(tab.id as any)}
                className={`px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all flex items-center gap-1.5 ${
                  requestSubTab === tab.id
                    ? 'bg-indigo-50 border-indigo-200 text-indigo-700 font-bold'
                    : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'
                }`}
              >
                {tab.label}
                {tab.count > 0 && (
                  <span className="w-4.5 h-4.5 bg-rose-500 text-white text-3xs font-extrabold rounded-full flex items-center justify-center animate-pulse">
                    {tab.count}
                  </span>
                )}
              </button>
            ))}
          </div>

          {/* Sub-pipelines listings */}
          <div className="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
            {/* ZOOM MEETING LIST */}
            {requestSubTab === 'zoom' && (
              <div className="overflow-x-auto">
                <table className="w-full text-left text-sm">
                  <thead className="bg-slate-50 text-xs text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                      <th className="px-6 py-4">Pemohon</th>
                      <th className="px-6 py-4">Agenda / Topik</th>
                      <th className="px-6 py-4">Pelaksanaan</th>
                      <th className="px-6 py-4">Status</th>
                      <th className="px-6 py-4 text-center">Keputusan</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-slate-100">
                    {zoomList.map((z) => (
                      <tr key={z.id} className="hover:bg-slate-50/50">
                        <td className="px-6 py-4">
                          <span className="font-bold text-slate-900 block">{z.userName}</span>
                          <span className="text-2xs text-slate-400 font-medium">ID: {z.userId}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="font-semibold text-slate-800 block">{z.topic}</span>
                          <span className="text-2xs text-slate-400 font-semibold">{z.participants} Peserta</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="font-bold text-slate-900 block">{z.date}</span>
                          <span className="text-2xs text-slate-500 font-medium">{z.startTime} s.d. {z.endTime}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className={`inline-flex px-2 py-0.5 text-3xs font-bold rounded-md uppercase ${
                            z.status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                          }`}>
                            {z.status}
                          </span>
                        </td>
                        <td className="px-6 py-4">
                          <div className="flex items-center justify-center gap-2">
                            {z.status === 'pending' ? (
                              <>
                                <button
                                  onClick={() => openActionModal('zoom', z, 'approve')}
                                  className="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all"
                                >
                                  Approve
                                </button>
                                <button
                                  onClick={() => openActionModal('zoom', z, 'reject')}
                                  className="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-lg border border-rose-200 transition-all"
                                >
                                  Tolak
                                </button>
                              </>
                            ) : (
                              <button
                                onClick={() => handleDeleteRequest('zoom', z.id)}
                                className="p-1 text-slate-400 hover:text-rose-600 rounded-lg transition-all"
                                title="Hapus Arsip"
                              >
                                <Trash className="w-4 h-4" />
                              </button>
                            )}
                          </div>
                        </td>
                      </tr>
                    ))}
                    {zoomList.length === 0 && (
                      <tr>
                        <td colSpan={5} className="text-center py-12 text-slate-400 text-xs">Belum ada permohonan Zoom Meeting.</td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>
            )}

            {/* EMAILS LIST (BOTH PERSONAL & INSTITUTIONAL) */}
            {requestSubTab === 'emails' && (
              <div className="overflow-x-auto">
                <table className="w-full text-left text-sm">
                  <thead className="bg-slate-50 text-xs text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                      <th className="px-6 py-4">Pemohon / Lembaga</th>
                      <th className="px-6 py-4">Alamat Dimohon</th>
                      <th className="px-6 py-4">Jenis</th>
                      <th className="px-6 py-4">Status</th>
                      <th className="px-6 py-4 text-center">Keputusan</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-slate-100">
                    {/* Personal */}
                    {emailPribadiList.map((emp) => (
                      <tr key={emp.id} className="hover:bg-slate-50/50">
                        <td className="px-6 py-4">
                          <span className="font-bold text-slate-900 block">{emp.userName}</span>
                          <span className="text-2xs text-slate-400">Alternatif: {emp.alternateEmail}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="font-bold text-indigo-700 text-xs block">{emp.requestedEmail}@ith.ac.id</span>
                          <span className="text-2xs text-slate-500 font-medium line-clamp-1 mt-0.5">{emp.reason}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="text-2xs font-semibold px-2 py-0.5 bg-slate-100 text-slate-700 rounded-full">Pribadi</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className={`inline-flex px-2 py-0.5 text-3xs font-bold rounded-md uppercase ${
                            emp.status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                          }`}>
                            {emp.status}
                          </span>
                        </td>
                        <td className="px-6 py-4">
                          <div className="flex items-center justify-center gap-2">
                            {emp.status === 'pending' ? (
                              <>
                                <button
                                  onClick={() => openActionModal('email-pribadi', emp, 'approve')}
                                  className="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all"
                                >
                                  Setujui
                                </button>
                                <button
                                  onClick={() => openActionModal('email-pribadi', emp, 'reject')}
                                  className="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-lg border border-rose-200 transition-all"
                                >
                                  Tolak
                                </button>
                              </>
                            ) : (
                              <button
                                onClick={() => handleDeleteRequest('email-pribadi', emp.id)}
                                className="p-1 text-slate-400 hover:text-rose-600 rounded-lg transition-all"
                              >
                                <Trash className="w-4 h-4" />
                              </button>
                            )}
                          </div>
                        </td>
                      </tr>
                    ))}

                    {/* Institutional */}
                    {emailLembagaList.map((eml) => (
                      <tr key={eml.id} className="hover:bg-slate-50/50 border-t border-slate-100">
                        <td className="px-6 py-4">
                          <span className="font-bold text-slate-900 block">{eml.institutionName}</span>
                          <span className="text-2xs text-slate-400">PIC: {eml.picName} ({eml.picNip})</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="font-bold text-indigo-700 text-xs block">{eml.requestedEmail}@ith.ac.id</span>
                          <span className="text-2xs text-slate-400 font-medium">Alternatif: {eml.alternateEmail}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="text-2xs font-semibold px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded-full">Lembaga</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className={`inline-flex px-2 py-0.5 text-3xs font-bold rounded-md uppercase ${
                            eml.status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                          }`}>
                            {eml.status}
                          </span>
                        </td>
                        <td className="px-6 py-4">
                          <div className="flex items-center justify-center gap-2">
                            {eml.status === 'pending' ? (
                              <>
                                <button
                                  onClick={() => openActionModal('email-lembaga', eml, 'approve')}
                                  className="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all"
                                >
                                  Setujui
                                </button>
                                <button
                                  onClick={() => openActionModal('email-lembaga', eml, 'reject')}
                                  className="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-lg border border-rose-200 transition-all"
                                >
                                  Tolak
                                </button>
                              </>
                            ) : (
                              <button
                                onClick={() => handleDeleteRequest('email-lembaga', eml.id)}
                                className="p-1 text-slate-400 hover:text-rose-600 rounded-lg transition-all"
                              >
                                <Trash className="w-4 h-4" />
                              </button>
                            )}
                          </div>
                        </td>
                      </tr>
                    ))}

                    {emailPribadiList.length === 0 && emailLembagaList.length === 0 && (
                      <tr>
                        <td colSpan={5} className="text-center py-12 text-slate-400 text-xs">Belum ada permohonan pembuatan email resmi.</td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>
            )}

            {/* SUBDOMAIN LIST */}
            {requestSubTab === 'subdomain' && (
              <div className="overflow-x-auto">
                <table className="w-full text-left text-sm">
                  <thead className="bg-slate-50 text-xs text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                      <th className="px-6 py-4">Pemohon</th>
                      <th className="px-6 py-4">Subdomain yang Diinginkan</th>
                      <th className="px-6 py-4">Kapasitas</th>
                      <th className="px-6 py-4">Status</th>
                      <th className="px-6 py-4 text-center">Keputusan</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-slate-100">
                    {subdomainList.map((sub) => (
                      <tr key={sub.id} className="hover:bg-slate-50/50">
                        <td className="px-6 py-4">
                          <span className="font-bold text-slate-900 block">{sub.userName}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="font-bold text-indigo-700 text-xs block">{sub.desiredSubdomain}.ith.ac.id</span>
                          <span className="text-2xs text-slate-500 line-clamp-1 mt-0.5">{sub.purpose}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="text-xs font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded-md">{sub.diskSpace}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className={`inline-flex px-2 py-0.5 text-3xs font-bold rounded-md uppercase ${
                            sub.status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                          }`}>
                            {sub.status}
                          </span>
                        </td>
                        <td className="px-6 py-4">
                          <div className="flex items-center justify-center gap-2">
                            {sub.status === 'pending' ? (
                              <>
                                <button
                                  onClick={() => openActionModal('subdomain', sub, 'approve')}
                                  className="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all"
                                >
                                  Setup
                                </button>
                                <button
                                  onClick={() => openActionModal('subdomain', sub, 'reject')}
                                  className="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-lg border border-rose-200 transition-all"
                                >
                                  Tolak
                                </button>
                              </>
                            ) : (
                              <button
                                onClick={() => handleDeleteRequest('subdomain', sub.id)}
                                className="p-1 text-slate-400 hover:text-rose-600 rounded-lg transition-all"
                              >
                                <Trash className="w-4 h-4" />
                              </button>
                            )}
                          </div>
                        </td>
                      </tr>
                    ))}
                    {subdomainList.length === 0 && (
                      <tr>
                        <td colSpan={5} className="text-center py-12 text-slate-400 text-xs">Belum ada pengajuan subdomain & hosting.</td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>
            )}

            {/* HOTSPOT ACCESS LIST */}
            {requestSubTab === 'hotspot' && (
              <div className="overflow-x-auto">
                <table className="w-full text-left text-sm">
                  <thead className="bg-slate-50 text-xs text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                      <th className="px-6 py-4">Pemohon</th>
                      <th className="px-6 py-4">MAC Address</th>
                      <th className="px-6 py-4">Saran Username</th>
                      <th className="px-6 py-4">Status</th>
                      <th className="px-6 py-4 text-center">Keputusan</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-slate-100">
                    {hotspotList.map((hot) => (
                      <tr key={hot.id} className="hover:bg-slate-50/50">
                        <td className="px-6 py-4">
                          <span className="font-bold text-slate-900 block">{hot.userName}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="font-mono text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-100 px-2 py-1 rounded-md">{hot.deviceMac}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="text-slate-800 font-medium">{hot.username}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className={`inline-flex px-2 py-0.5 text-3xs font-bold rounded-md uppercase ${
                            hot.status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                          }`}>
                            {hot.status}
                          </span>
                        </td>
                        <td className="px-6 py-4">
                          <div className="flex items-center justify-center gap-2">
                            {hot.status === 'pending' ? (
                              <>
                                <button
                                  onClick={() => openActionModal('hotspot', hot, 'approve')}
                                  className="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all"
                                >
                                  Daftarkan
                                </button>
                                <button
                                  onClick={() => openActionModal('hotspot', hot, 'reject')}
                                  className="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-lg border border-rose-200 transition-all"
                                >
                                  Tolak
                                </button>
                              </>
                            ) : (
                              <button
                                onClick={() => handleDeleteRequest('hotspot', hot.id)}
                                className="p-1 text-slate-400 hover:text-rose-600 rounded-lg transition-all"
                              >
                                <Trash className="w-4 h-4" />
                              </button>
                            )}
                          </div>
                        </td>
                      </tr>
                    ))}
                    {hotspotList.length === 0 && (
                      <tr>
                        <td colSpan={5} className="text-center py-12 text-slate-400 text-xs">Belum ada permohonan pendaftaran MAC Address hotspot.</td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>
            )}

            {/* ADUAN / COMPLAINTS LIST */}
            {requestSubTab === 'laporan' && (
              <div className="overflow-x-auto">
                <table className="w-full text-left text-sm">
                  <thead className="bg-slate-50 text-xs text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                      <th className="px-6 py-4">Kode / Pelapor</th>
                      <th className="px-6 py-4">Detail Kerusakan</th>
                      <th className="px-6 py-4">Kategori</th>
                      <th className="px-6 py-4">Status</th>
                      <th className="px-6 py-4 text-center">Keputusan</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-slate-100">
                    {laporanList.map((lap) => (
                      <tr key={lap.id} className="hover:bg-slate-50/50">
                        <td className="px-6 py-4">
                          <span className="font-bold text-slate-900 block">{lap.ticketCode}</span>
                          <span className="text-2xs text-slate-400">Oleh: {lap.userName}</span>
                        </td>
                        <td className="px-6 py-4 max-w-[320px]">
                          <span className="font-bold text-slate-800 block line-clamp-1">{lap.title}</span>
                          <span className="text-2xs text-slate-500 line-clamp-1 mt-0.5">{lap.description}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="text-2xs font-bold px-2 py-0.5 bg-rose-50 border border-rose-100 text-rose-700 rounded-md">{lap.category}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className={`inline-flex px-2 py-0.5 text-3xs font-bold rounded-md uppercase ${
                            lap.status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' :
                            lap.status === 'diproses' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                          }`}>
                            {lap.status}
                          </span>
                        </td>
                        <td className="px-6 py-4">
                          <div className="flex items-center justify-center gap-2">
                            <button
                              onClick={() => openActionModal('laporan', lap, 'update_laporan')}
                              className="px-2.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all"
                            >
                              Pembaruan
                            </button>
                            <button
                              onClick={() => handleDeleteRequest('laporan', lap.id)}
                              className="p-1 text-slate-400 hover:text-rose-600 rounded-lg transition-all"
                            >
                              <Trash className="w-4 h-4" />
                            </button>
                          </div>
                        </td>
                      </tr>
                    ))}
                    {laporanList.length === 0 && (
                      <tr>
                        <td colSpan={5} className="text-center py-12 text-slate-400 text-xs">Belum ada aduan masuk.</td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>
            )}
          </div>
        </div>
      )}

      {/* ==================== 2. USERS ADMINISTRATION TAB ==================== */}
      {activeTab === 'users' && (
        <div className="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
          <div className="px-6 py-5 border-b border-slate-100">
            <h3 className="text-base font-bold text-slate-950">Daftar Pengguna Portal</h3>
            <p className="text-xs text-slate-500 mt-1">Ubah hak akses pengguna antara Admin, Operator, dan User Mahasiswa.</p>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left text-sm">
              <thead className="bg-slate-50 text-xs text-slate-500 font-bold border-b border-slate-100">
                <tr>
                  <th className="px-6 py-4">Nama Lengkap</th>
                  <th className="px-6 py-4">Username / NIP / NIM</th>
                  <th className="px-6 py-4">Email</th>
                  <th className="px-6 py-4">Role Hak Akses</th>
                  <th className="px-6 py-4 text-center">Tindakan</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100">
                {users.map(u => (
                  <tr key={u.id} className="hover:bg-slate-50/50">
                    <td className="px-6 py-4">
                      <span className="font-bold text-slate-900 block">{u.name}</span>
                      <span className="text-2xs text-slate-400">{u.phone || 'No Phone'}</span>
                    </td>
                    <td className="px-6 py-4 font-mono text-xs">{u.username}</td>
                    <td className="px-6 py-4 text-slate-600 text-xs">{u.email}</td>
                    <td className="px-6 py-4">
                      <select
                        value={u.role}
                        onChange={(e) => handleChangeUserRole(u.id, e.target.value as any)}
                        className="px-2 py-1 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none focus:border-indigo-500"
                      >
                        <option value="user">User Mahasiswa</option>
                        <option value="operator">Operator Jaringan</option>
                        <option value="admin">Administrator</option>
                      </select>
                    </td>
                    <td className="px-6 py-4 text-center">
                      <button
                        onClick={() => handleDeleteUser(u.id)}
                        disabled={u.id === user.id}
                        className="p-1 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all disabled:opacity-30"
                        title="Hapus Akun"
                      >
                        <Trash className="w-4 h-4" />
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* ==================== 3. CONTENT MANAGEMENT TAB ==================== */}
      {activeTab === 'content' && (
        <div className="space-y-6">
          <div className="flex border-b border-slate-100 pb-3 gap-3">
            {[
              { id: 'announcements', label: 'Pengumuman TIK', count: announcements.length },
              { id: 'activities', label: 'Kegiatan & Berita', count: activities.length },
              { id: 'faqs', label: 'FAQ', count: faqs.length },
              { id: 'facilities', label: 'Fasilitas Kampus', count: facilities.length },
            ].map(tab => (
              <button
                key={tab.id}
                onClick={() => setContentSubTab(tab.id as any)}
                className={`px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all ${
                  contentSubTab === tab.id ? 'bg-indigo-600 border-indigo-600 text-white shadow-md shadow-indigo-100' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'
                }`}
              >
                {tab.label} ({tab.count})
              </button>
            ))}

            <button
              onClick={() => {
                const sub = contentSubTab;
                if (sub === 'announcements') setShowCreateContentModal('ann');
                else if (sub === 'activities') setShowCreateContentModal('act');
                else if (sub === 'faqs') setShowCreateContentModal('faq');
                else if (sub === 'facilities') setShowCreateContentModal('fas');
                setContentTitle('');
                setContentBody('');
                setContentExtra('');
                setContentCategory('Penting');
              }}
              className="ml-auto flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 border border-indigo-100 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-lg transition-all"
            >
              <Plus className="w-3.5 h-3.5" />
              Publish Konten Baru
            </button>
          </div>

          <div className="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
            {/* ANNOUNCEMENTS PANEL */}
            {contentSubTab === 'announcements' && (
              <div className="divide-y divide-slate-100">
                {announcements.map((ann) => (
                  <div key={ann.id} className="p-6 flex justify-between items-start gap-6 hover:bg-slate-50/50">
                    <div className="space-y-1.5">
                      <div className="flex items-center gap-2">
                        <span className={`px-2 py-0.5 text-3xs font-bold rounded-md ${ann.category === 'Penting' ? 'bg-rose-50 text-rose-700' : 'bg-indigo-50 text-indigo-700'}`}>
                          {ann.category}
                        </span>
                        <span className="text-2xs text-slate-400 font-medium">{ann.date}</span>
                      </div>
                      <h4 className="text-sm font-bold text-slate-900">{ann.title}</h4>
                      <p className="text-xs text-slate-600 leading-relaxed max-w-2xl">{ann.content}</p>
                    </div>
                    <button onClick={() => handleDeleteContent('ann', ann.id)} className="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg">
                      <Trash className="w-4 h-4" />
                    </button>
                  </div>
                ))}
              </div>
            )}

            {/* ACTIVITIES PANEL */}
            {contentSubTab === 'activities' && (
              <div className="divide-y divide-slate-100">
                {activities.map((act) => (
                  <div key={act.id} className="p-6 flex justify-between items-start gap-6 hover:bg-slate-50/50">
                    <div className="flex gap-4">
                      <div className="w-16 h-16 bg-slate-100 border border-slate-200 rounded-lg overflow-hidden shrink-0">
                        <img src={act.imageUrl} alt={act.title} className="w-full h-full object-cover" />
                      </div>
                      <div className="space-y-1">
                        <span className="text-2xs text-slate-400 block">{act.date}</span>
                        <h4 className="text-sm font-bold text-slate-900">{act.title}</h4>
                        <p className="text-xs text-slate-600 leading-relaxed line-clamp-2 max-w-xl">{act.content}</p>
                      </div>
                    </div>
                    <button onClick={() => handleDeleteContent('act', act.id)} className="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg">
                      <Trash className="w-4 h-4" />
                    </button>
                  </div>
                ))}
              </div>
            )}

            {/* FAQS PANEL */}
            {contentSubTab === 'faqs' && (
              <div className="divide-y divide-slate-100">
                {faqs.map((f) => (
                  <div key={f.id} className="p-6 flex justify-between items-start gap-6 hover:bg-slate-50/50">
                    <div className="space-y-1.5">
                      <span className="text-3xs font-bold px-1.5 py-0.5 bg-slate-100 text-slate-700 rounded-md">{f.category}</span>
                      <h4 className="text-sm font-bold text-slate-900">Q: {f.question}</h4>
                      <p className="text-xs text-slate-600 leading-relaxed">A: {f.answer}</p>
                    </div>
                    <button onClick={() => handleDeleteContent('faq', f.id)} className="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg">
                      <Trash className="w-4 h-4" />
                    </button>
                  </div>
                ))}
              </div>
            )}

            {/* FACILITIES PANEL */}
            {contentSubTab === 'facilities' && (
              <div className="divide-y divide-slate-100">
                {facilities.map((fas) => (
                  <div key={fas.id} className="p-6 flex justify-between items-start gap-6 hover:bg-slate-50/50">
                    <div className="space-y-1">
                      <h4 className="text-sm font-bold text-slate-900">{fas.name}</h4>
                      <span className="text-2xs font-bold text-emerald-700 block">Kondisi: {fas.condition}</span>
                      <p className="text-xs text-slate-600 leading-relaxed max-w-xl mt-1">{fas.description}</p>
                    </div>
                    <button onClick={() => handleDeleteContent('fas', fas.id)} className="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg">
                      <Trash className="w-4 h-4" />
                    </button>
                  </div>
                ))}
              </div>
            )}
          </div>
        </div>
      )}

      {/* ==================== REQUEST ACTION MODALS OVERLAYS ==================== */}
      {activeActionReq && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
          <div className="bg-white border border-slate-200 rounded-3xl max-w-md w-full overflow-hidden shadow-2xl animate-in fade-in zoom-in-95 duration-150">
            <div className="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
              <h3 className="text-base font-extrabold text-slate-950">
                {activeActionReq.action === 'approve' ? 'Form Persetujuan Kredensial' :
                 activeActionReq.action === 'reject' ? 'Formulir Penolakan Pengajuan' : 'Pembaruan Aduan Kerusakan'}
              </h3>
              <button onClick={() => setActiveActionReq(null)} className="w-8 h-8 font-bold hover:bg-slate-200 rounded-full flex items-center justify-center">&times;</button>
            </div>

            <form onSubmit={handleRequestAction} className="p-6 space-y-4">
              {/* REJECTION FORM */}
              {activeActionReq.action === 'reject' && (
                <div className="space-y-1.5 text-xs">
                  <label className="text-slate-700 font-bold block">Alasan Penolakan Permohonan *</label>
                  <textarea
                    placeholder="Tuliskan alasan penolakan agar pemohon dapat mengetahuinya secara jelas..."
                    rows={4}
                    value={actionReason}
                    onChange={(e) => setActionReason(e.target.value)}
                    className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none resize-none"
                    required
                  ></textarea>
                </div>
              )}

              {/* APPROVAL ZOOM FORM */}
              {activeActionReq.action === 'approve' && activeActionReq.type === 'zoom' && (
                <div className="space-y-3 text-xs">
                  <div className="space-y-1">
                    <label className="text-slate-700 font-bold">Link Tautan Pertemuan Zoom Pro *</label>
                    <input
                      type="text"
                      value={actionZoomLink}
                      onChange={(e) => setActionZoomLink(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      required
                    />
                  </div>
                  <div className="grid grid-cols-2 gap-3">
                    <div className="space-y-1">
                      <label className="text-slate-700 font-bold">Meeting ID *</label>
                      <input
                        type="text"
                        value={actionZoomId}
                        onChange={(e) => setActionZoomId(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                        required
                      />
                    </div>
                    <div className="space-y-1">
                      <label className="text-slate-700 font-bold">Passcode *</label>
                      <input
                        type="text"
                        value={actionZoomPass}
                        onChange={(e) => setActionZoomPass(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                        required
                      />
                    </div>
                  </div>
                </div>
              )}

              {/* APPROVAL EMAILS FORM */}
              {activeActionReq.action === 'approve' && (activeActionReq.type === 'email-pribadi' || activeActionReq.type === 'email-lembaga') && (
                <div className="space-y-3 text-xs">
                  <div className="space-y-1">
                    <label className="text-slate-700 font-bold">Nama Alamat Email Kampus Disetujui *</label>
                    <div className="flex items-center gap-2">
                      <input
                        type="text"
                        value={actionEmailResult}
                        onChange={(e) => setActionEmailResult(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                        required
                      />
                      <span className="text-sm font-bold text-slate-800 shrink-0">@ith.ac.id</span>
                    </div>
                  </div>
                  <div className="space-y-1">
                    <label className="text-slate-700 font-bold">Kata Sandi Pertama Kali / Sementara *</label>
                    <input
                      type="text"
                      value={actionEmailPass}
                      onChange={(e) => setActionEmailPass(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      required
                    />
                  </div>
                </div>
              )}

              {/* APPROVAL SUBDOMAIN FORM */}
              {activeActionReq.action === 'approve' && activeActionReq.type === 'subdomain' && (
                <div className="space-y-3 text-xs">
                  <div className="space-y-1">
                    <label className="text-slate-700 font-bold">Tautan URL Subdomain Aktif *</label>
                    <input
                      type="text"
                      value={actionSubdomainUrl}
                      onChange={(e) => setActionSubdomainUrl(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      required
                    />
                  </div>
                  <div className="grid grid-cols-2 gap-3">
                    <div className="space-y-1">
                      <label className="text-slate-700 font-bold">Username Hosting *</label>
                      <input
                        type="text"
                        value={actionSubdomainUser}
                        onChange={(e) => setActionSubdomainUser(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                        required
                      />
                    </div>
                    <div className="space-y-1">
                      <label className="text-slate-700 font-bold">Password Hosting *</label>
                      <input
                        type="text"
                        value={actionSubdomainPass}
                        onChange={(e) => setActionSubdomainPass(e.target.value)}
                        className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                        required
                      />
                    </div>
                  </div>
                </div>
              )}

              {/* APPROVAL HOTSPOT MAC FORM */}
              {activeActionReq.action === 'approve' && activeActionReq.type === 'hotspot' && (
                <div className="space-y-3 text-xs">
                  <div className="space-y-1">
                    <label className="text-slate-700 font-bold">Username Wifi bypass disetujui *</label>
                    <input
                      type="text"
                      value={actionHotspotUser}
                      onChange={(e) => setActionHotspotUser(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      required
                    />
                  </div>
                  <div className="space-y-1">
                    <label className="text-slate-700 font-bold">Password bypass disetujui *</label>
                    <input
                      type="text"
                      value={actionHotspotPass}
                      onChange={(e) => setActionHotspotPass(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                      required
                    />
                  </div>
                </div>
              )}

              {/* UPDATE STATUS LAPORAN / COMPLAINT */}
              {activeActionReq.action === 'update_laporan' && (
                <div className="space-y-3 text-xs">
                  <div className="space-y-1">
                    <label className="text-slate-700 font-bold">Status Penanganan Aduan *</label>
                    <select
                      value={actionLaporanStatus}
                      onChange={(e: any) => setActionLaporanStatus(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none font-semibold"
                    >
                      <option value="pending">Belum Diproses (Pending)</option>
                      <option value="diproses">Sedang Diproses Teknisi</option>
                      <option value="selesai">Selesai Ditangani</option>
                    </select>
                  </div>
                  <div className="space-y-1">
                    <label className="text-slate-700 font-bold">Catatan Penyelesaian / Progress Teknis *</label>
                    <textarea
                      placeholder="Masukkan tanggapan atau kronologi perbaikan yang telah dilakukan divisi IT support..."
                      rows={4}
                      value={actionLaporanNotes}
                      onChange={(e) => setActionLaporanNotes(e.target.value)}
                      className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none resize-none"
                      required
                    ></textarea>
                  </div>
                </div>
              )}

              <button
                type="submit"
                className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-100 transition-all flex items-center justify-center gap-2"
              >
                <span>Simpan Keputusan</span>
                <ArrowRight className="w-4 h-4" />
              </button>
            </form>
          </div>
        </div>
      )}

      {/* ==================== CREATE CONTENT MODALS OVERLAYS ==================== */}
      {showCreateContentModal && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
          <div className="bg-white border border-slate-200 rounded-3xl max-w-md w-full overflow-hidden shadow-2xl animate-in fade-in zoom-in-95 duration-150">
            <div className="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
              <h3 className="text-base font-extrabold text-slate-950">
                {showCreateContentModal === 'ann' ? 'Publish Pengumuman Baru' :
                 showCreateContentModal === 'act' ? 'Publish Kegiatan & Berita Baru' :
                 showCreateContentModal === 'faq' ? 'Publish FAQ Baru' : 'Publish Fasilitas Kampus Baru'}
              </h3>
              <button onClick={() => setShowCreateContentModal(null)} className="w-8 h-8 font-bold hover:bg-slate-200 rounded-full flex items-center justify-center">&times;</button>
            </div>

            <form onSubmit={handleCreateContent} className="p-6 space-y-4 text-xs">
              <div className="space-y-1">
                <label className="text-slate-700 font-bold">
                  {showCreateContentModal === 'ann' ? 'Judul Pengumuman *' :
                   showCreateContentModal === 'act' ? 'Judul Berita/Kegiatan *' :
                   showCreateContentModal === 'faq' ? 'Pertanyaan FAQ *' : 'Nama Fasilitas Kampus *'}
                </label>
                <input
                  type="text"
                  placeholder="Ketik judul di sini..."
                  value={contentTitle}
                  onChange={(e) => setContentTitle(e.target.value)}
                  className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                  required
                />
              </div>

              {showCreateContentModal === 'ann' && (
                <div className="space-y-1">
                  <label className="text-slate-700 font-bold">Kategori Urgensi *</label>
                  <select
                    value={contentCategory}
                    onChange={(e) => setContentCategory(e.target.value)}
                    className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                  >
                    <option value="Penting">Penting / Darurat</option>
                    <option value="Layanan">Info Layanan IT</option>
                    <option value="Umum">Umum / Akademis</option>
                  </select>
                </div>
              )}

              {showCreateContentModal === 'faq' && (
                <div className="space-y-1">
                  <label className="text-slate-700 font-bold">Kategori FAQ *</label>
                  <select
                    value={contentCategory}
                    onChange={(e) => setContentCategory(e.target.value)}
                    className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                  >
                    <option value="Layanan">Email & Layanan Kampus</option>
                    <option value="Zoom">Zoom & Pembelajaran</option>
                    <option value="Hosting & Domain">Hosting & Subdomain</option>
                    <option value="Umum">Umum</option>
                  </select>
                </div>
              )}

              {showCreateContentModal === 'fas' && (
                <div className="space-y-1">
                  <label className="text-slate-700 font-bold">Kondisi Fisik Fasilitas *</label>
                  <select
                    value={contentCategory}
                    onChange={(e) => setContentCategory(e.target.value)}
                    className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                  >
                    <option value="Sangat Baik">Sangat Baik (Optimal)</option>
                    <option value="Baik">Baik (Berfungsi)</option>
                    <option value="Dalam Pemeliharaan">Dalam Pemeliharaan (Maintenance)</option>
                  </select>
                </div>
              )}

              {showCreateContentModal === 'act' && (
                <div className="space-y-1">
                  <label className="text-slate-700 font-bold">URL Tautan Gambar Kegiatan</label>
                  <input
                    type="text"
                    placeholder="Contoh: /images/gambac.jpeg"
                    value={contentExtra}
                    onChange={(e) => setContentExtra(e.target.value)}
                    className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
                  />
                </div>
              )}

              <div className="space-y-1">
                <label className="text-slate-700 font-bold">
                  {showCreateContentModal === 'faq' ? 'Jawaban FAQ *' : 'Deskripsi Konten Lengkap *'}
                </label>
                <textarea
                  placeholder="Ketik konten detail di sini..."
                  rows={5}
                  value={contentBody}
                  onChange={(e) => setContentBody(e.target.value)}
                  className="w-full px-4 py-2.5 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none resize-none"
                  required
                ></textarea>
              </div>

              <button
                type="submit"
                className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-100 transition-all"
              >
                Kirim Publikasi
              </button>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}
