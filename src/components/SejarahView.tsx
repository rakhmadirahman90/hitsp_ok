import React from 'react';
import { Landmark, Compass, Target, Award, CheckCircle2 } from 'lucide-react';

export default function SejarahView() {
  const visi = 'Menjadi UPT Teknologi Informasi dan Komunikasi yang unggul dan andal dalam mendukung pelaksanaan Tridharma Perguruan Tinggi berbasis teknologi digital berstandar nasional pada tahun 2026.';
  
  const misi = [
    'Menyelenggarakan tata kelola teknologi informasi yang transparan, aman, akuntabel, dan terintegrasi.',
    'Menyediakan infrastruktur jaringan, pusat data, dan aplikasi sistem informasi kampus yang andal dan berkinerja tinggi.',
    'Memberikan layanan prima dalam asistensi teknis dan bimbingan digital bagi seluruh civitas akademika Institut Teknologi Bacharuddin Jusuf Habibie (ITH).',
    'Mendorong inovasi dan pengembangan sistem informasi berbasis kebutuhan institusi, riset, dan pengabdian masyarakat.'
  ];

  const milestones = [
    { year: '2022', title: 'Pendirian UPT TIK', desc: 'Inisiasi pembentukan Unit Pelaksana Teknis Teknologi Informasi dan Komunikasi sejalan dengan berdirinya kampus Institut Teknologi Bacharuddin Jusuf Habibie (ITH) di Parepare.' },
    { year: '2023', title: 'Pembangunan Core Network', desc: 'Penggelaran infrastruktur fiber optik utama yang menghubungkan seluruh gedung perkuliahan dan laboratorium komputer terpadu.' },
    { year: '2024', title: 'Peluncuran HITSP Portal', desc: 'Sistem permohonan lisensi akademik terpusat (Zoom, Email, Hosting, Wifi MAC bypass) diluncurkan untuk efisiensi birokrasi kampus.' },
  ];

  return (
    <div className="max-w-4xl mx-auto space-y-12 pb-16" id="sejarah-view">
      {/* Title */}
      <div className="text-center max-w-2xl mx-auto space-y-3">
        <h1 className="text-3xl font-extrabold tracking-tight text-slate-950">Sejarah, Visi & Misi</h1>
        <p className="text-sm text-slate-600 leading-relaxed">
          Mengenal perjalanan UPT Teknologi Informasi dan Komunikasi dalam memfasilitasi transformasi digital institusi secara andal dan berkelanjutan.
        </p>
      </div>

      {/* Sejarah Section */}
      <section className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
        <div className="flex items-center gap-3 border-b border-slate-100 pb-4">
          <div className="w-10 h-10 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
            <Landmark className="w-5 h-5" />
          </div>
          <div>
            <h2 className="text-lg font-bold text-slate-950">Sejarah Singkat UPT TIK</h2>
            <p className="text-2xs text-slate-500 font-medium">Melangkah maju bersama inovasi teknologi perguruan tinggi</p>
          </div>
        </div>

        <div className="space-y-4 text-sm text-slate-700 leading-relaxed">
          <p>
            Unit Pelaksana Teknis Teknologi Informasi dan Komunikasi (UPT TIK) didirikan sebagai tulang punggung pelayanan digital di lingkungan Institut Teknologi Bacharuddin Jusuf Habibie (ITH) Parepare. Seiring dengan pertumbuhan pesat jumlah mahasiswa dan tuntutan digitalisasi akademis, UPT TIK terus memperluas jangkauan layanannya.
          </p>
          <p>
            Kini, UPT TIK tidak hanya mengelola infrastruktur jaringan fisik dan ruang server lokal, melainkan juga menyediakan sistem penanganan permohonan terpadu (HITSP Portal) untuk melayani pengajuan akun e-learning, registrasi hosting organisasi, akses hotspot kampus, serta pusat pengaduan gangguan teknis yang terintegrasi secara real-time.
          </p>
        </div>
      </section>

      {/* Visi Misi Section */}
      <section className="grid grid-cols-1 md:grid-cols-2 gap-8">
        {/* Visi */}
        <div className="bg-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl flex flex-col justify-between space-y-6">
          <div className="space-y-4">
            <div className="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-indigo-300">
              <Compass className="w-5 h-5" />
            </div>
            <h3 className="text-lg font-bold text-white">Visi UPT TIK</h3>
            <p className="text-sm text-indigo-100/90 leading-relaxed font-medium italic">
              "{visi}"
            </p>
          </div>
          <span className="text-2xs text-indigo-300 font-bold uppercase tracking-wider block">Target Strategis 2026</span>
        </div>

        {/* Misi */}
        <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-4">
          <h3 className="text-lg font-bold text-slate-950 flex items-center gap-2">
            <Target className="w-5 h-5 text-indigo-600" />
            Misi UPT TIK
          </h3>
          <div className="space-y-3.5">
            {misi.map((m, idx) => (
              <div key={idx} className="flex gap-2.5 items-start text-xs sm:text-sm text-slate-700">
                <CheckCircle2 className="w-4.5 h-4.5 text-indigo-600 shrink-0 mt-0.5" />
                <p className="leading-relaxed">{m}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Milestones / Timeline */}
      <section className="space-y-6">
        <h3 className="text-lg font-bold text-slate-950 text-center flex items-center justify-center gap-2">
          <Award className="w-5 h-5 text-indigo-600" />
          Milestone Perjalanan Kami
        </h3>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
          {milestones.map((m, idx) => (
            <div key={idx} className="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs relative overflow-hidden group">
              <span className="absolute -right-4 -bottom-4 text-6xl font-extrabold text-slate-100/50 group-hover:text-indigo-100/40 transition-colors pointer-events-none">
                {m.year}
              </span>
              <div className="space-y-2 relative">
                <span className="text-xs font-extrabold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">{m.year}</span>
                <h4 className="text-sm font-bold text-slate-900">{m.title}</h4>
                <p className="text-xs text-slate-600 leading-relaxed">{m.desc}</p>
              </div>
            </div>
          ))}
        </div>
      </section>
    </div>
  );
}
