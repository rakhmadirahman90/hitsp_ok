import React from 'react';
import { Fasilitas } from '../types';
import { ShieldCheck, AlertCircle, Wrench, Server } from 'lucide-react';

interface FasilitasViewProps {
  facilities: Fasilitas[];
}

export default function FasilitasView({ facilities }: FasilitasViewProps) {
  return (
    <div className="max-w-5xl mx-auto space-y-8 pb-12" id="fasilitas-view">
      {/* Header */}
      <div className="text-center max-w-2xl mx-auto space-y-3">
        <h1 className="text-3xl font-extrabold tracking-tight text-slate-950">Inventaris & Fasilitas TIK</h1>
        <p className="text-sm text-slate-600 leading-relaxed">
          UPT TIK ITH mengelola infrastruktur pusat data, jaringan serat optik, serta laboratorium komputer untuk memfasilitasi kegiatan belajar mengajar secara optimal.
        </p>
      </div>

      {/* Facilities Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
        {facilities.map(facility => {
          let statusColor = 'bg-emerald-50 text-emerald-700 border-emerald-100';
          let StatusIcon = ShieldCheck;

          if (facility.condition === 'Dalam Pemeliharaan') {
            statusColor = 'bg-amber-50 text-amber-700 border-amber-100 animate-pulse';
            StatusIcon = Wrench;
          } else if (facility.condition === 'Rusak') {
            statusColor = 'bg-rose-50 text-rose-700 border-rose-100';
            StatusIcon = AlertCircle;
          }

          return (
            <div
              key={facility.id}
              className="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between"
            >
              <div className="space-y-4">
                <div className="flex justify-between items-start gap-4">
                  <div className="w-10 h-10 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                    <Server className="w-5 h-5" />
                  </div>
                  <span className={`inline-flex items-center gap-1 px-2.5 py-0.5 text-2xs font-bold rounded-md border ${statusColor}`}>
                    <StatusIcon className="w-3 h-3" />
                    {facility.condition}
                  </span>
                </div>

                <div className="space-y-1.5">
                  <h3 className="text-base font-bold text-slate-900">{facility.name}</h3>
                  <p className="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    {facility.description}
                  </p>
                </div>
              </div>
            </div>
          );
        })}

        {facilities.length === 0 && (
          <div className="col-span-full text-center py-16 bg-white border border-slate-200 rounded-2xl">
            <p className="text-slate-400 text-sm">Belum ada inventaris fasilitas terdaftar.</p>
          </div>
        )}
      </div>
    </div>
  );
}
