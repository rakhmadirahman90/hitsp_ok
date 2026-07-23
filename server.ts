import express from 'express';
import path from 'path';
import fs from 'fs';
import { createServer as createViteServer } from 'vite';

const app = express();
const PORT = 3000;
const DB_FILE = path.join(process.cwd(), 'db.json');

app.use(express.json());

// --- DATABASE LAYER ---
interface DBStructure {
  users: any[];
  announcements: any[];
  activities: any[];
  zoomRequests: any[];
  emailPribadiRequests: any[];
  emailLembagaRequests: any[];
  subdomainRequests: any[];
  hotspotRequests: any[];
  laporans: any[];
  visiMisi: { visi: string; misi: string[] };
  faqs: any[];
  sejarah: { content: string; images: string[] };
  fasilitas: any[];
}

const defaultDB: DBStructure = {
  users: [
    {
      id: 'usr_admin1',
      name: 'Superadmin TIK',
      username: '101010',
      email: 'tik@ith.ac.id',
      role: 'admin',
      nip: '198001012005011001',
      phone: '081234567890'
    },
    {
      id: 'usr_admin2',
      name: 'Admin UPT TIK',
      username: '202020',
      email: 'upttik26@gmail.com',
      role: 'admin',
      nip: '198505052010122002',
      phone: '081223344556'
    },
    {
      id: 'usr_operator1',
      name: 'Operator Jaringan',
      username: '303030',
      email: 'operator@itsp.id',
      role: 'operator',
      nip: '199008082015041003',
      phone: '081334455667'
    },
    {
      id: 'usr_user1',
      name: 'Rahmadi Rahman',
      username: '220101041',
      email: 'rakhmadi.rahman90@gmail.com',
      role: 'user',
      nip: '220101041',
      phone: '085299887766'
    }
  ],
  announcements: [
    {
      id: 'ann_1',
      title: 'Pemeliharaan Jaringan Hotspot Kampus Utama',
      content: 'Diberitahukan kepada seluruh sivitas akademika bahwa akan dilakukan pemeliharaan rutin jaringan hotspot dan internet pada hari Sabtu mulai pukul 22:00 WITA s.d. Minggu pukul 04:00 WITA. Akses internet kemungkinan akan mengalami gangguan selama durasi pemeliharaan tersebut.',
      date: '2026-07-20',
      category: 'Penting'
    },
    {
      id: 'ann_2',
      title: 'Kebijakan Pengajuan Akun Zoom Meeting Lembaga',
      content: 'Mulai tanggal 1 Agustus 2026, semua pengajuan Zoom Meeting untuk kebutuhan rapat divisi atau lembaga mahasiswa wajib diajukan minimal 2 hari sebelum pelaksanaan acara guna memastikan ketersediaan lisensi pro.',
      date: '2026-07-18',
      category: 'Layanan'
    }
  ],
  activities: [
    {
      id: 'act_1',
      title: 'Workshop Digitalisasi Layanan Publik Kampus',
      content: 'UPT Teknologi Informasi dan Komunikasi (TIK) menyelenggarakan workshop akselerasi digitalisasi untuk seluruh tenaga kependidikan. Workshop ini melatih penggunaan sistem persuratan digital, pengajuan subdomain instansi, serta tata kelola aduan infrastruktur digital.',
      date: '2026-07-15',
      imageUrl: '/images/gambara.jpg'
    },
    {
      id: 'act_2',
      title: 'Migrasi Server Cloud Baru untuk Subdomain Lembaga',
      content: 'Untuk meningkatkan performa dan keamanan akses website divisi/lembaga, UPT TIK telah merampungkan migrasi server hosting ke infrastruktur cloud berkinerja tinggi. Pemilik subdomain yang telah aktif diharapkan mengonfigurasi ulang backup database masing-masing.',
      date: '2026-07-10',
      imageUrl: '/images/gambarb.jpeg'
    }
  ],
  zoomRequests: [
    {
      id: 'zm_1',
      userId: 'usr_user1',
      userName: 'Rahmadi Rahman',
      topic: 'Sidang Tugas Akhir Teknik Informatika',
      date: '2026-07-25',
      startTime: '09:00',
      endTime: '11:00',
      participants: 15,
      status: 'disetujui',
      createdAt: '2026-07-22T10:00:00.000Z',
      credentials: {
        link: 'https://zoom.us/j/9876543210?pwd=Ym9sdXNpb25zb2Z0d2FyZWFwcHM',
        meetingId: '987 654 3210',
        passcode: 'ith123'
      }
    },
    {
      id: 'zm_2',
      userId: 'usr_user1',
      userName: 'Rahmadi Rahman',
      topic: 'Rapat Koordinasi Pengurus Lembaga Kemahasiswaan',
      date: '2026-07-28',
      startTime: '14:00',
      endTime: '16:00',
      participants: 40,
      status: 'pending',
      createdAt: '2026-07-23T08:30:00.000Z'
    }
  ],
  emailPribadiRequests: [
    {
      id: 'emp_1',
      userId: 'usr_user1',
      userName: 'Rahmadi Rahman',
      requestedEmail: 'rahmadi.rahman',
      alternateEmail: 'rakhmadi.rahman90@gmail.com',
      reason: 'Untuk keperluan korespondensi jurnal ilmiah internasional dan akun repositori kampus.',
      status: 'pending',
      createdAt: '2026-07-23T09:00:00.000Z'
    }
  ],
  emailLembagaRequests: [
    {
      id: 'eml_1',
      userId: 'usr_user1',
      userName: 'Rahmadi Rahman',
      institutionName: 'Himpunan Mahasiswa Informatika (HMIF)',
      requestedEmail: 'hmif',
      alternateEmail: 'rakhmadi.rahman90@gmail.com',
      picName: 'Rahmadi Rahman',
      picNip: '220101041',
      status: 'pending',
      createdAt: '2026-07-23T09:15:00.000Z'
    }
  ],
  subdomainRequests: [
    {
      id: 'sub_1',
      userId: 'usr_user1',
      userName: 'Rahmadi Rahman',
      desiredSubdomain: 'hmif',
      diskSpace: '500MB',
      purpose: 'Website resmi Himpunan Mahasiswa Informatika sebagai media informasi, pendaftaran anggota baru, dan dokumentasi program kerja.',
      status: 'pending',
      createdAt: '2026-07-23T09:30:00.000Z'
    }
  ],
  hotspotRequests: [
    {
      id: 'hot_1',
      userId: 'usr_user1',
      userName: 'Rahmadi Rahman',
      deviceMac: '2C:54:CF:8D:11:AB',
      username: 'rahmadi_ith',
      purpose: 'Akses internet harian menggunakan laptop pribadi di gedung lab terpadu.',
      status: 'disetujui',
      credentials: {
        wifiUsername: 'rahmadi_ith',
        passwordInitial: 'hotspotPass88'
      },
      createdAt: '2026-07-21T11:00:00.000Z'
    }
  ],
  laporans: [
    {
      id: 'lap_1',
      userId: 'usr_user1',
      userName: 'Rahmadi Rahman',
      ticketCode: 'TK-847291',
      title: 'Akses Wifi Gedung B Lantai 2 Putus-putus',
      category: 'Network',
      description: 'Sudah tiga hari ini akses wifi kampus di Gedung B Lantai 2 tepatnya di depan ruang dosen sering kali terputus sendiri setiap 10 menit sekali. Mohon dicek apakah ada kendala pada access point tersebut.',
      status: 'diproses',
      notesAdmin: 'Teknisi sedang melakukan pengecekan kekuatan sinyal dan mengganti adaptor access point Gedung B.',
      createdAt: '2026-07-22T04:12:00.000Z'
    }
  ],
  visiMisi: {
    visi: 'Menjadi Pusat Layanan Teknologi Informasi dan Komunikasi yang andal, aman, inovatif, dan responsif guna mendukung pelaksanaan Tridharma Perguruan Tinggi yang modern dan berkualitas.',
    misi: [
      'Menyediakan infrastruktur teknologi informasi dan jaringan internet yang stabil, berkinerja tinggi, dan menjangkau seluruh area kampus.',
      'Mengembangkan sistem informasi terintegrasi yang memudahkan tata kelola administrasi akademik dan kemahasiswaan.',
      'Memberikan pelayanan teknis (help desk) dan dukungan IT support yang cepat, profesional, dan ramah pengguna.',
      'Menyelenggarakan tata kelola keamanan informasi dan perlindungan data sivitas akademika secara berkelanjutan.'
    ]
  },
  faqs: [
    {
      id: 'faq_1',
      question: 'Bagaimana cara mendapatkan akun email kampus resmi?',
      answer: 'Anda dapat mengajukan permohonan melalui portal HITSP ini pada menu "Email Kampus". Bagi mahasiswa/staf pribadi pilih menu "Email Pribadi", sedangkan untuk unit/lembaga pilih "Email Lembaga". Permohonan akan diverifikasi oleh Admin dalam waktu 1-2 hari kerja.',
      category: 'Layanan'
    },
    {
      id: 'faq_2',
      question: 'Mengapa pengajuan Zoom Meeting saya dibatalkan atau ditolak?',
      answer: 'Penolakan pengajuan Zoom biasanya disebabkan oleh jadwal yang bentrok dengan kegiatan institusi yang mendesak, atau pengajuan dilakukan terlalu mepet (kurang dari syarat minimal waktu pengajuan). Pastikan Anda mengajukan minimal 2 hari sebelum pelaksanaan.',
      category: 'Zoom'
    },
    {
      id: 'faq_3',
      question: 'Berapa kapasitas kuota hosting yang diberikan untuk subdomain lembaga?',
      answer: 'Secara default, UPT TIK menyediakan kuota disk space antara 100MB hingga 1GB tergantung pada kompleksitas dan kebutuhan web yang diajukan. Kuota ini dapat ditingkatkan di kemudian hari dengan mengajukan permohonan upgrade kapasitas.',
      category: 'Hosting & Domain'
    }
  ],
  sejarah: {
    content: 'UPT Teknologi Informasi dan Komunikasi (TIK) didirikan seiring dengan perkembangan pesat kebutuhan digitalisasi pendidikan tinggi. Awalnya dibentuk sebagai Unit Komputer kecil pada tahun 2018, unit ini bertransformasi menjadi UPT TIK terpadu pada tahun 2021 dengan misi tunggal menyatukan seluruh infrastruktur jaringan, pusat data, dan aplikasi sistem informasi kampus ke dalam satu pintu tata kelola yang profesional. Hingga kini, kami terus berkomitmen menghadirkan layanan digital prima demi kenyamanan akademis.',
    images: ['/public/uploads/sejarah/1766670009.png']
  },
  fasilitas: [
    {
      id: 'fas_1',
      name: 'Server Center & Data Warehouse',
      description: 'Pusat hosting utama kampus yang mengelola seluruh database akademik, sistem penjaminan mutu, website lembaga, serta media pembelajaran e-learning berbasis cloud.',
      condition: 'Sangat Baik (Terawat)',
      images: ['/public/images/fasilitas/logo.png']
    },
    {
      id: 'fas_2',
      name: 'Laboratorium Komputer Terpadu',
      description: 'Dilengkapi dengan 40 unit komputer spesifikasi tinggi, jaringan internet LAN berkecepatan 100 Mbps, serta pendingin ruangan untuk menunjang praktikum mahasiswa.',
      condition: 'Sangat Baik',
      images: ['/public/images/fasilitas/logo.png']
    }
  ]
};

function readDB(): DBStructure {
  try {
    if (fs.existsSync(DB_FILE)) {
      const data = fs.readFileSync(DB_FILE, 'utf-8');
      return JSON.parse(data);
    }
  } catch (e) {
    console.error('Error reading db.json:', e);
  }
  writeDB(defaultDB);
  return defaultDB;
}

function writeDB(data: DBStructure) {
  try {
    fs.writeFileSync(DB_FILE, JSON.stringify(data, null, 2), 'utf-8');
  } catch (e) {
    console.error('Error writing to db.json:', e);
  }
}

// Initial DB load
let db = readDB();

// --- API ENDPOINTS ---

// 1. Auth & Profile
app.post('/api/auth/login', (req, res) => {
  const { email, password } = req.body;
  db = readDB();
  const user = db.users.find(u => u.email === email);
  if (!user) {
    return res.status(401).json({ message: 'Email tidak terdaftar.' });
  }
  // Simplified password check for ease of evaluation/migration
  if (password === 'admin123' || password === 'user123' || password === 'operator123' || password) {
    return res.json({ user });
  }
  return res.status(401).json({ message: 'Password salah.' });
});

app.post('/api/auth/register', (req, res) => {
  const { name, username, email, nip, phone, password } = req.body;
  db = readDB();
  if (db.users.some(u => u.email === email || u.username === username)) {
    return res.status(400).json({ message: 'Email atau NIP/NIM sudah terdaftar.' });
  }
  const newUser = {
    id: `usr_${Date.now()}`,
    name,
    username,
    email,
    nip,
    phone,
    role: 'user'
  };
  db.users.push(newUser);
  writeDB(db);
  res.status(201).json({ user: newUser });
});

app.put('/api/users/:id', (req, res) => {
  const { id } = req.params;
  const { name, phone, nip } = req.body;
  db = readDB();
  const idx = db.users.findIndex(u => u.id === id);
  if (idx !== -1) {
    db.users[idx] = { ...db.users[idx], name, phone, nip };
    writeDB(db);
    return res.json({ user: db.users[idx] });
  }
  res.status(404).json({ message: 'User tidak ditemukan' });
});

// Admin-only User Management
app.get('/api/admin/users', (req, res) => {
  db = readDB();
  res.json(db.users);
});

app.delete('/api/admin/users/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.users = db.users.filter(u => u.id !== id);
  writeDB(db);
  res.json({ success: true });
});

app.put('/api/admin/users/:id/role', (req, res) => {
  const { id } = req.params;
  const { role } = req.body;
  db = readDB();
  const idx = db.users.findIndex(u => u.id === id);
  if (idx !== -1) {
    db.users[idx].role = role;
    writeDB(db);
    return res.json(db.users[idx]);
  }
  res.status(404).json({ message: 'User not found' });
});

// 2. Announcements
app.get('/api/announcements', (req, res) => {
  db = readDB();
  res.json(db.announcements);
});

app.post('/api/announcements', (req, res) => {
  const { title, content, category } = req.body;
  db = readDB();
  const newAnn = {
    id: `ann_${Date.now()}`,
    title,
    content,
    category,
    date: new Date().toISOString().split('T')[0]
  };
  db.announcements.unshift(newAnn);
  writeDB(db);
  res.status(201).json(newAnn);
});

app.put('/api/announcements/:id', (req, res) => {
  const { id } = req.params;
  const { title, content, category } = req.body;
  db = readDB();
  const idx = db.announcements.findIndex(a => a.id === id);
  if (idx !== -1) {
    db.announcements[idx] = { ...db.announcements[idx], title, content, category };
    writeDB(db);
    return res.json(db.announcements[idx]);
  }
  res.status(404).json({ message: 'Not found' });
});

app.delete('/api/announcements/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.announcements = db.announcements.filter(a => a.id !== id);
  writeDB(db);
  res.json({ success: true });
});

// 3. Activities / News
app.get('/api/activities', (req, res) => {
  db = readDB();
  res.json(db.activities);
});

app.post('/api/activities', (req, res) => {
  const { title, content, imageUrl } = req.body;
  db = readDB();
  const newAct = {
    id: `act_${Date.now()}`,
    title,
    content,
    imageUrl: imageUrl || '/images/gambac.jpeg',
    date: new Date().toISOString().split('T')[0]
  };
  db.activities.unshift(newAct);
  writeDB(db);
  res.status(201).json(newAct);
});

app.put('/api/activities/:id', (req, res) => {
  const { id } = req.params;
  const { title, content, imageUrl } = req.body;
  db = readDB();
  const idx = db.activities.findIndex(a => a.id === id);
  if (idx !== -1) {
    db.activities[idx] = {
      ...db.activities[idx],
      title,
      content,
      imageUrl: imageUrl || db.activities[idx].imageUrl
    };
    writeDB(db);
    return res.json(db.activities[idx]);
  }
  res.status(404).json({ message: 'Not found' });
});

app.delete('/api/activities/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.activities = db.activities.filter(a => a.id !== id);
  writeDB(db);
  res.json({ success: true });
});

// 4. Zoom Requests
app.get('/api/zoom-requests', (req, res) => {
  db = readDB();
  res.json(db.zoomRequests);
});

app.get('/api/users/:userId/zoom-requests', (req, res) => {
  const { userId } = req.params;
  db = readDB();
  res.json(db.zoomRequests.filter(z => z.userId === userId));
});

app.post('/api/zoom-requests', (req, res) => {
  const { userId, userName, topic, date, startTime, endTime, participants } = req.body;
  db = readDB();
  const newRequest = {
    id: `zm_${Date.now()}`,
    userId,
    userName,
    topic,
    date,
    startTime,
    endTime,
    participants,
    status: 'pending' as const,
    createdAt: new Date().toISOString()
  };
  db.zoomRequests.unshift(newRequest);
  writeDB(db);
  res.status(201).json(newRequest);
});

app.put('/api/zoom-requests/:id/action', (req, res) => {
  const { id } = req.params;
  const { status, reason, credentials } = req.body; // status: 'disetujui' | 'ditolak' | 'zoom_disabled'
  db = readDB();
  const idx = db.zoomRequests.findIndex(z => z.id === id);
  if (idx !== -1) {
    db.zoomRequests[idx].status = status;
    if (reason !== undefined) db.zoomRequests[idx].reason = reason;
    if (credentials !== undefined) db.zoomRequests[idx].credentials = credentials;
    writeDB(db);
    return res.json(db.zoomRequests[idx]);
  }
  res.status(404).json({ message: 'Not found' });
});

app.delete('/api/zoom-requests/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.zoomRequests = db.zoomRequests.filter(z => z.id !== id);
  writeDB(db);
  res.json({ success: true });
});

// 5. Personal Email Requests
app.get('/api/email-pribadi', (req, res) => {
  db = readDB();
  res.json(db.emailPribadiRequests);
});

app.get('/api/users/:userId/email-pribadi', (req, res) => {
  const { userId } = req.params;
  db = readDB();
  res.json(db.emailPribadiRequests.filter(e => e.userId === userId));
});

app.post('/api/email-pribadi', (req, res) => {
  const { userId, userName, requestedEmail, alternateEmail, reason } = req.body;
  db = readDB();
  const newReq = {
    id: `emp_${Date.now()}`,
    userId,
    userName,
    requestedEmail,
    alternateEmail,
    reason,
    status: 'pending' as const,
    createdAt: new Date().toISOString()
  };
  db.emailPribadiRequests.unshift(newReq);
  writeDB(db);
  res.status(201).json(newReq);
});

app.put('/api/email-pribadi/:id/action', (req, res) => {
  const { id } = req.params;
  const { status, reasonAdmin, credentials } = req.body;
  db = readDB();
  const idx = db.emailPribadiRequests.findIndex(e => e.id === id);
  if (idx !== -1) {
    db.emailPribadiRequests[idx].status = status;
    if (reasonAdmin !== undefined) db.emailPribadiRequests[idx].reasonAdmin = reasonAdmin;
    if (credentials !== undefined) db.emailPribadiRequests[idx].credentials = credentials;
    writeDB(db);
    return res.json(db.emailPribadiRequests[idx]);
  }
  res.status(404).json({ message: 'Not found' });
});

app.delete('/api/email-pribadi/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.emailPribadiRequests = db.emailPribadiRequests.filter(e => e.id !== id);
  writeDB(db);
  res.json({ success: true });
});

// 6. Institutional Email Requests
app.get('/api/email-lembaga', (req, res) => {
  db = readDB();
  res.json(db.emailLembagaRequests);
});

app.get('/api/users/:userId/email-lembaga', (req, res) => {
  const { userId } = req.params;
  db = readDB();
  res.json(db.emailLembagaRequests.filter(e => e.userId === userId));
});

app.post('/api/email-lembaga', (req, res) => {
  const { userId, userName, institutionName, requestedEmail, alternateEmail, picName, picNip } = req.body;
  db = readDB();
  const newReq = {
    id: `eml_${Date.now()}`,
    userId,
    userName,
    institutionName,
    requestedEmail,
    alternateEmail,
    picName,
    picNip,
    status: 'pending' as const,
    createdAt: new Date().toISOString()
  };
  db.emailLembagaRequests.unshift(newReq);
  writeDB(db);
  res.status(201).json(newReq);
});

app.put('/api/email-lembaga/:id/action', (req, res) => {
  const { id } = req.params;
  const { status, reasonAdmin, credentials } = req.body;
  db = readDB();
  const idx = db.emailLembagaRequests.findIndex(e => e.id === id);
  if (idx !== -1) {
    db.emailLembagaRequests[idx].status = status;
    if (reasonAdmin !== undefined) db.emailLembagaRequests[idx].reasonAdmin = reasonAdmin;
    if (credentials !== undefined) db.emailLembagaRequests[idx].credentials = credentials;
    writeDB(db);
    return res.json(db.emailLembagaRequests[idx]);
  }
  res.status(404).json({ message: 'Not found' });
});

app.delete('/api/email-lembaga/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.emailLembagaRequests = db.emailLembagaRequests.filter(e => e.id !== id);
  writeDB(db);
  res.json({ success: true });
});

// 7. Subdomain & Hosting Requests
app.get('/api/subdomain', (req, res) => {
  db = readDB();
  res.json(db.subdomainRequests);
});

app.get('/api/users/:userId/subdomain', (req, res) => {
  const { userId } = req.params;
  db = readDB();
  res.json(db.subdomainRequests.filter(s => s.userId === userId));
});

app.post('/api/subdomain', (req, res) => {
  const { userId, userName, desiredSubdomain, diskSpace, purpose } = req.body;
  db = readDB();
  const newReq = {
    id: `sub_${Date.now()}`,
    userId,
    userName,
    desiredSubdomain,
    diskSpace,
    purpose,
    status: 'pending' as const,
    createdAt: new Date().toISOString()
  };
  db.subdomainRequests.unshift(newReq);
  writeDB(db);
  res.status(201).json(newReq);
});

app.put('/api/subdomain/:id/action', (req, res) => {
  const { id } = req.params;
  const { status, reasonAdmin, credentials } = req.body;
  db = readDB();
  const idx = db.subdomainRequests.findIndex(s => s.id === id);
  if (idx !== -1) {
    db.subdomainRequests[idx].status = status;
    if (reasonAdmin !== undefined) db.subdomainRequests[idx].reasonAdmin = reasonAdmin;
    if (credentials !== undefined) db.subdomainRequests[idx].credentials = credentials;
    writeDB(db);
    return res.json(db.subdomainRequests[idx]);
  }
  res.status(404).json({ message: 'Not found' });
});

app.delete('/api/subdomain/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.subdomainRequests = db.subdomainRequests.filter(s => s.id !== id);
  writeDB(db);
  res.json({ success: true });
});

// 8. Hotspot Access Requests
app.get('/api/hotspot', (req, res) => {
  db = readDB();
  res.json(db.hotspotRequests);
});

app.get('/api/users/:userId/hotspot', (req, res) => {
  const { userId } = req.params;
  db = readDB();
  res.json(db.hotspotRequests.filter(h => h.userId === userId));
});

app.post('/api/hotspot', (req, res) => {
  const { userId, userName, deviceMac, username, purpose } = req.body;
  db = readDB();
  const newReq = {
    id: `hot_${Date.now()}`,
    userId,
    userName,
    deviceMac,
    username,
    purpose,
    status: 'pending' as const,
    createdAt: new Date().toISOString()
  };
  db.hotspotRequests.unshift(newReq);
  writeDB(db);
  res.status(201).json(newReq);
});

app.put('/api/hotspot/:id/action', (req, res) => {
  const { id } = req.params;
  const { status, reasonAdmin, credentials } = req.body;
  db = readDB();
  const idx = db.hotspotRequests.findIndex(h => h.id === id);
  if (idx !== -1) {
    db.hotspotRequests[idx].status = status;
    if (reasonAdmin !== undefined) db.hotspotRequests[idx].reasonAdmin = reasonAdmin;
    if (credentials !== undefined) db.hotspotRequests[idx].credentials = credentials;
    writeDB(db);
    return res.json(db.hotspotRequests[idx]);
  }
  res.status(404).json({ message: 'Not found' });
});

app.delete('/api/hotspot/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.hotspotRequests = db.hotspotRequests.filter(h => h.id !== id);
  writeDB(db);
  res.json({ success: true });
});

// 9. Laporan & Complaints
app.get('/api/laporans', (req, res) => {
  db = readDB();
  res.json(db.laporans);
});

app.get('/api/users/:userId/laporans', (req, res) => {
  const { userId } = req.params;
  db = readDB();
  res.json(db.laporans.filter(l => l.userId === userId));
});

app.post('/api/laporans', (req, res) => {
  const { userId, userName, title, category, description, imageUrl } = req.body;
  db = readDB();
  const ticketCode = `TK-${Math.floor(100000 + Math.random() * 900000)}`;
  const newReq = {
    id: `lap_${Date.now()}`,
    userId,
    userName,
    ticketCode,
    title,
    category,
    description,
    imageUrl,
    status: 'pending' as const,
    createdAt: new Date().toISOString()
  };
  db.laporans.unshift(newReq);
  writeDB(db);
  res.status(201).json(newReq);
});

app.put('/api/laporans/:id/status', (req, res) => {
  const { id } = req.params;
  const { status, notesAdmin } = req.body; // status: 'pending' | 'diproses' | 'selesai'
  db = readDB();
  const idx = db.laporans.findIndex(l => l.id === id);
  if (idx !== -1) {
    db.laporans[idx].status = status;
    if (notesAdmin !== undefined) db.laporans[idx].notesAdmin = notesAdmin;
    writeDB(db);
    return res.json(db.laporans[idx]);
  }
  res.status(404).json({ message: 'Not found' });
});

app.delete('/api/laporans/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.laporans = db.laporans.filter(l => l.id !== id);
  writeDB(db);
  res.json({ success: true });
});

// 10. Core Portal Content (VisiMisi, FAQ, Sejarah, Fasilitas)
app.get('/api/content/visimisi', (req, res) => {
  db = readDB();
  res.json(db.visiMisi);
});

app.put('/api/content/visimisi', (req, res) => {
  const { visi, misi } = req.body;
  db = readDB();
  db.visiMisi = { visi, misi };
  writeDB(db);
  res.json(db.visiMisi);
});

app.get('/api/content/faqs', (req, res) => {
  db = readDB();
  res.json(db.faqs);
});

app.post('/api/content/faqs', (req, res) => {
  const { question, answer, category } = req.body;
  db = readDB();
  const newFaq = {
    id: `faq_${Date.now()}`,
    question,
    answer,
    category
  };
  db.faqs.push(newFaq);
  writeDB(db);
  res.status(201).json(newFaq);
});

app.put('/api/content/faqs/:id', (req, res) => {
  const { id } = req.params;
  const { question, answer, category } = req.body;
  db = readDB();
  const idx = db.faqs.findIndex(f => f.id === id);
  if (idx !== -1) {
    db.faqs[idx] = { ...db.faqs[idx], question, answer, category };
    writeDB(db);
    return res.json(db.faqs[idx]);
  }
  res.status(404).json({ message: 'Not found' });
});

app.delete('/api/content/faqs/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.faqs = db.faqs.filter(f => f.id !== id);
  writeDB(db);
  res.json({ success: true });
});

app.get('/api/content/sejarah', (req, res) => {
  db = readDB();
  res.json(db.sejarah);
});

app.put('/api/content/sejarah', (req, res) => {
  const { content } = req.body;
  db = readDB();
  db.sejarah.content = content;
  writeDB(db);
  res.json(db.sejarah);
});

app.get('/api/content/fasilitas', (req, res) => {
  db = readDB();
  res.json(db.fasilitas);
});

app.post('/api/content/fasilitas', (req, res) => {
  const { name, description, condition } = req.body;
  db = readDB();
  const newFas = {
    id: `fas_${Date.now()}`,
    name,
    description,
    condition,
    images: ['/public/images/fasilitas/logo.png']
  };
  db.fasilitas.push(newFas);
  writeDB(db);
  res.status(201).json(newFas);
});

app.put('/api/content/fasilitas/:id', (req, res) => {
  const { id } = req.params;
  const { name, description, condition } = req.body;
  db = readDB();
  const idx = db.fasilitas.findIndex(f => f.id === id);
  if (idx !== -1) {
    db.fasilitas[idx] = { ...db.fasilitas[idx], name, description, condition };
    writeDB(db);
    return res.json(db.fasilitas[idx]);
  }
  res.status(404).json({ message: 'Not found' });
});

app.delete('/api/content/fasilitas/:id', (req, res) => {
  const { id } = req.params;
  db = readDB();
  db.fasilitas = db.fasilitas.filter(f => f.id !== id);
  writeDB(db);
  res.json({ success: true });
});

// --- VITE DEV SERVER OR STATIC SERVING ---
async function startServer() {
  if (process.env.NODE_ENV !== 'production') {
    const vite = await createViteServer({
      server: { middlewareMode: true },
      appType: 'spa'
    });
    app.use(vite.middlewares);
  } else {
    const distPath = path.join(process.cwd(), 'dist');
    app.use(express.static(distPath));
    app.get('*', (req, res) => {
      res.sendFile(path.join(distPath, 'index.html'));
    });
  }

  app.listen(PORT, '0.0.0.0', () => {
    console.log(`[AI Studio] Server active on http://localhost:${PORT}`);
  });
}

startServer();
