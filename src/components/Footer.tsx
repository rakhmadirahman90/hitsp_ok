import React from 'react';
import { Mail, Phone, MapPin, Globe, ArrowUpRight } from 'lucide-react';

export default function Footer() {
  return (
    <footer className="bg-slate-900 text-slate-400 border-t border-slate-800" id="footer">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {/* Col 1: About */}
          <div className="space-y-4">
            <div className="flex items-center gap-2">
              <div className="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold">
                IT
              </div>
              <span className="text-lg font-bold text-white tracking-tight">HITSP Portal</span>
            </div>
            <p className="text-sm text-slate-400 leading-relaxed">
              Help Desk & IT Support Portal (HITSP) dikelola oleh UPT Teknologi Informasi dan Komunikasi (TIK) Institut Teknologi BJ Habibie. Kami siap memberikan layanan infrastruktur digital terbaik.
            </p>
          </div>

          {/* Col 2: Quick Links */}
          <div>
            <h3 className="text-sm font-semibold text-white tracking-wider uppercase mb-4">Layanan IT Populer</h3>
            <ul className="space-y-2 text-sm">
              <li className="flex items-center gap-1 hover:text-white transition-colors cursor-pointer">
                <span>Pengajuan Ruang Zoom Meeting</span>
                <ArrowUpRight className="w-3.5 h-3.5 opacity-50" />
              </li>
              <li className="flex items-center gap-1 hover:text-white transition-colors cursor-pointer">
                <span>Pembuatan Email Kampus Resmi</span>
                <ArrowUpRight className="w-3.5 h-3.5 opacity-50" />
              </li>
              <li className="flex items-center gap-1 hover:text-white transition-colors cursor-pointer">
                <span>Registrasi Subdomain & Hosting</span>
                <ArrowUpRight className="w-3.5 h-3.5 opacity-50" />
              </li>
              <li className="flex items-center gap-1 hover:text-white transition-colors cursor-pointer">
                <span>Registrasi Akses Hotspot MAC</span>
                <ArrowUpRight className="w-3.5 h-3.5 opacity-50" />
              </li>
            </ul>
          </div>

          {/* Col 3: Contact */}
          <div>
            <h3 className="text-sm font-semibold text-white tracking-wider uppercase mb-4">Hubungi UPT TIK</h3>
            <ul className="space-y-3 text-sm text-slate-400">
              <li className="flex items-start gap-2.5">
                <MapPin className="w-5 h-5 text-indigo-500 shrink-0 mt-0.5" />
                <span>Gedung Lab Terpadu Lantai 1, Kampus ITH, Parepare, Sulawesi Selatan</span>
              </li>
              <li className="flex items-center gap-2.5">
                <Phone className="w-4 h-4 text-indigo-500" />
                <span>+62 (0421) 234567</span>
              </li>
              <li className="flex items-center gap-2.5">
                <Mail className="w-4 h-4 text-indigo-500" />
                <span>tik@ith.ac.id | upttik26@gmail.com</span>
              </li>
              <li className="flex items-center gap-2.5">
                <Globe className="w-4 h-4 text-indigo-500" />
                <a href="https://ith.ac.id" target="_blank" rel="noopener noreferrer" className="hover:text-white hover:underline transition-colors">
                  ith.ac.id
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div className="border-t border-slate-850 mt-12 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
          <p className="text-xs text-slate-500">
            &copy; {new Date().getFullYear()} UPT TIK Institut Teknologi BJ Habibie. All rights reserved.
          </p>
          <div className="flex gap-4 text-xs text-slate-500">
            <span className="hover:text-slate-300 cursor-pointer">Ketentuan Layanan</span>
            <span>&bull;</span>
            <span className="hover:text-slate-300 cursor-pointer">Kebijakan Privasi</span>
            <span>&bull;</span>
            <span className="hover:text-slate-300 cursor-pointer">IT Support Hub</span>
          </div>
        </div>
      </div>
    </footer>
  );
}
