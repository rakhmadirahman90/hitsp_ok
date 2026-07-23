import React, { useState } from 'react';
import { Faq } from '../types';
import { Search, ChevronDown, ChevronUp, HelpCircle } from 'lucide-react';

interface FaqViewProps {
  faqs: Faq[];
}

export default function FaqView({ faqs }: FaqViewProps) {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState<string>('Semua');
  const [expandedFaqId, setExpandedFaqId] = useState<string | null>(null);

  const categories = ['Semua', 'Layanan', 'Zoom', 'Hosting & Domain', 'Umum'];

  const filteredFaqs = faqs.filter(faq => {
    const matchesSearch = faq.question.toLowerCase().includes(searchTerm.toLowerCase()) || 
                          faq.answer.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesCategory = selectedCategory === 'Semua' || faq.category === selectedCategory;
    return matchesSearch && matchesCategory;
  });

  const toggleFaq = (id: string) => {
    if (expandedFaqId === id) {
      setExpandedFaqId(null);
    } else {
      setExpandedFaqId(id);
    }
  };

  return (
    <div className="max-w-4xl mx-auto space-y-8 pb-12" id="faq-view">
      {/* Header */}
      <div className="text-center max-w-2xl mx-auto space-y-3">
        <h1 className="text-3xl font-extrabold tracking-tight text-slate-950">Pusat Bantuan & FAQ</h1>
        <p className="text-sm text-slate-600 leading-relaxed">
          Temukan jawaban cepat atas pertanyaan seputar aktivasi akun, permohonan lisensi, konfigurasi wifi MAC address, dan layanan digital UPT TIK lainnya.
        </p>
      </div>

      {/* Filter and Search Bar */}
      <div className="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row gap-4 items-center">
        <div className="relative w-full md:flex-1">
          <Search className="absolute left-3.5 top-3.5 w-4.5 h-4.5 text-slate-400" />
          <input
            type="text"
            placeholder="Cari solusi atau panduan teknis..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            className="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-250 focus:border-indigo-500 focus:bg-white rounded-xl text-sm transition-colors focus:outline-none"
          />
        </div>

        <div className="flex flex-wrap gap-1.5 w-full md:w-auto">
          {categories.map(cat => (
            <button
              key={cat}
              onClick={() => setSelectedCategory(cat)}
              className={`px-3.5 py-2 text-xs font-semibold rounded-lg border transition-all ${
                selectedCategory === cat
                  ? 'bg-indigo-600 border-indigo-600 text-white shadow-md shadow-indigo-100'
                  : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'
              }`}
            >
              {cat}
            </button>
          ))}
        </div>
      </div>

      {/* FAQ Accordion List */}
      <div className="space-y-4">
        {filteredFaqs.map(faq => {
          const isExpanded = expandedFaqId === faq.id;
          return (
            <div
              key={faq.id}
              className="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-2xs hover:border-indigo-200 transition-all"
            >
              <button
                onClick={() => toggleFaq(faq.id)}
                className="w-full px-6 py-5 text-left flex justify-between items-center gap-4 hover:bg-slate-50/50 transition-colors"
              >
                <div className="flex items-start gap-3">
                  <HelpCircle className="w-5 h-5 text-indigo-500 shrink-0 mt-0.5" />
                  <div>
                    <span className="text-3xs font-extrabold text-indigo-600 uppercase tracking-wider block mb-1">
                      {faq.category}
                    </span>
                    <h3 className="text-sm sm:text-base font-bold text-slate-900">{faq.question}</h3>
                  </div>
                </div>
                {isExpanded ? (
                  <ChevronUp className="w-5 h-5 text-slate-400 shrink-0" />
                ) : (
                  <ChevronDown className="w-5 h-5 text-slate-400 shrink-0" />
                )}
              </button>

              {isExpanded && (
                <div className="px-6 pb-6 pt-2 border-t border-slate-100 bg-slate-50/30">
                  <p className="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                    {faq.answer}
                  </p>
                </div>
              )}
            </div>
          );
        })}

        {filteredFaqs.length === 0 && (
          <div className="text-center py-16 bg-white border border-slate-200 rounded-2xl">
            <p className="text-slate-400 text-sm">Tidak ditemukan jawaban untuk pencarian Anda.</p>
          </div>
        )}
      </div>
    </div>
  );
}
