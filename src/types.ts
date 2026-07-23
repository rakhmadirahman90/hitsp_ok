export type UserRole = 'admin' | 'user' | 'operator';

export interface User {
  id: string;
  name: string;
  username: string;
  email: string;
  role: UserRole;
  status?: string; // e.g. 'pending' or 'active'
  nip?: string;
  phone?: string;
}

export interface Announcement {
  id: string;
  title: string;
  content: string;
  date: string;
  category: string;
}

export interface Activity {
  id: string;
  title: string;
  content: string;
  date: string;
  imageUrl: string;
}

export interface ZoomRequest {
  id: string;
  userId: string;
  userName: string;
  topic: string;
  date: string;
  startTime: string;
  endTime: string;
  participants: number;
  status: 'pending' | 'disetujui' | 'ditolak' | 'zoom_disabled';
  reason?: string;
  credentials?: {
    link: string;
    meetingId: string;
    passcode: string;
  };
  createdAt: string;
}

export interface EmailPribadiRequest {
  id: string;
  userId: string;
  userName: string;
  requestedEmail: string;
  alternateEmail: string;
  reason: string;
  status: 'pending' | 'disetujui' | 'ditolak';
  reasonAdmin?: string;
  credentials?: {
    email: string;
    passwordInitial: string;
  };
  createdAt: string;
}

export interface EmailLembagaRequest {
  id: string;
  userId: string;
  userName: string;
  institutionName: string;
  requestedEmail: string;
  alternateEmail: string;
  picName: string;
  picNip: string;
  status: 'pending' | 'disetujui' | 'ditolak';
  reasonAdmin?: string;
  credentials?: {
    email: string;
    passwordInitial: string;
  };
  createdAt: string;
}

export interface SubdomainRequest {
  id: string;
  userId: string;
  userName: string;
  desiredSubdomain: string;
  diskSpace: string; // e.g., '100MB', '500MB', '1GB'
  purpose: string;
  status: 'pending' | 'disetujui' | 'ditolak' | 'domain_disabled';
  reasonAdmin?: string;
  credentials?: {
    url: string;
    username: string;
    passwordInitial: string;
  };
  createdAt: string;
}

export interface HotspotRequest {
  id: string;
  userId: string;
  userName: string;
  deviceMac: string;
  username: string;
  purpose: string;
  status: 'pending' | 'disetujui' | 'ditolak';
  reasonAdmin?: string;
  credentials?: {
    wifiUsername: string;
    passwordInitial: string;
  };
  createdAt: string;
}

export interface LaporanRequest {
  id: string;
  userId: string;
  userName: string;
  ticketCode: string;
  title: string;
  category: string; // e.g., Network, Hardware, Software, Service
  description: string;
  imageUrl?: string;
  status: 'pending' | 'diproses' | 'selesai';
  notesAdmin?: string;
  createdAt: string;
}

export interface VisiMisi {
  visi: string;
  misi: string[];
}

export interface Faq {
  id: string;
  question: string;
  answer: string;
  category: string;
}

export interface Sejarah {
  content: string;
  images: string[];
}

export interface Fasilitas {
  id: string;
  name: string;
  description: string;
  condition: string;
  images: string[];
}
