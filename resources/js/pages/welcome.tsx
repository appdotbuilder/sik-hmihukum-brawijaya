import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

export default function Welcome(): React.ReactElement {
    return (
        <div className="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50">
            <Head title="Sistem Informasi Kader HMI Hukum Brawijaya" />
            
            {/* Header */}
            <header className="bg-white shadow-sm border-b-2 border-green-600">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div className="text-center">
                        <h1 className="text-4xl font-bold text-green-800 mb-2">
                            🕌 HMI Hukum Brawijaya
                        </h1>
                        <p className="text-lg text-green-600 font-medium italic">
                            "Yakin Usaha Sampai"
                        </p>
                    </div>
                </div>
            </header>

            {/* Hero Section */}
            <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div className="text-center mb-16">
                    <h2 className="text-5xl font-bold text-gray-900 mb-6">
                        📚 Sistem Informasi Kader (SIK)
                    </h2>
                    <p className="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        Platform manajemen kader yang komprehensif untuk HMI Hukum Brawijaya. 
                        Mengelola data kader, perpustakaan komisariat, dan absensi digital dengan 
                        nuansa Islami yang elegan.
                    </p>
                </div>

                {/* Feature Cards */}
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    {/* Authentication & User Management */}
                    <div className="bg-white rounded-lg shadow-lg p-8 border-t-4 border-green-500 hover:shadow-xl transition-shadow">
                        <div className="text-4xl mb-4">👥</div>
                        <h3 className="text-xl font-bold text-gray-900 mb-3">Manajemen Kader</h3>
                        <ul className="text-gray-600 space-y-2">
                            <li>• Registrasi otomatis level "Kader"</li>
                            <li>• Verifikasi dengan Nomor Induk Kader</li>
                            <li>• Role-based access (Admin, Pengurus, Kader)</li>
                            <li>• Profil lengkap kader</li>
                        </ul>
                    </div>

                    {/* Library Management */}
                    <div className="bg-white rounded-lg shadow-lg p-8 border-t-4 border-blue-500 hover:shadow-xl transition-shadow">
                        <div className="text-4xl mb-4">📚</div>
                        <h3 className="text-xl font-bold text-gray-900 mb-3">Perpustakaan Komisariat</h3>
                        <ul className="text-gray-600 space-y-2">
                            <li>• Koleksi buku cetak & digital</li>
                            <li>• Karya kader (thesis, artikel)</li>
                            <li>• Sistem peminjaman online</li>
                            <li>• Akses baca digital langsung</li>
                        </ul>
                    </div>

                    {/* Digital Attendance */}
                    <div className="bg-white rounded-lg shadow-lg p-8 border-t-4 border-purple-500 hover:shadow-xl transition-shadow">
                        <div className="text-4xl mb-4">✅</div>
                        <h3 className="text-xl font-bold text-gray-900 mb-3">Absensi Digital</h3>
                        <ul className="text-gray-600 space-y-2">
                            <li>• Absensi per kegiatan</li>
                            <li>• Pemilihan peserta fleksibel</li>
                            <li>• Rekap absensi otomatis</li>
                            <li>• Cetak laporan kehadiran</li>
                        </ul>
                    </div>

                    {/* Dashboard & Statistics */}
                    <div className="bg-white rounded-lg shadow-lg p-8 border-t-4 border-orange-500 hover:shadow-xl transition-shadow">
                        <div className="text-4xl mb-4">📊</div>
                        <h3 className="text-xl font-bold text-gray-900 mb-3">Dashboard Statistik</h3>
                        <ul className="text-gray-600 space-y-2">
                            <li>• Statistik pengguna real-time</li>
                            <li>• Data perpustakaan lengkap</li>
                            <li>• Tracking peminjaman</li>
                            <li>• Analytics kegiatan</li>
                        </ul>
                    </div>

                    {/* Islamic Nuance */}
                    <div className="bg-white rounded-lg shadow-lg p-8 border-t-4 border-emerald-500 hover:shadow-xl transition-shadow">
                        <div className="text-4xl mb-4">🕌</div>
                        <h3 className="text-xl font-bold text-gray-900 mb-3">Nuansa Islami</h3>
                        <ul className="text-gray-600 space-y-2">
                            <li>• Desain dengan identitas HMI</li>
                            <li>• Koleksi buku Islami</li>
                            <li>• Interface yang elegan</li>
                            <li>• Nilai-nilai persatuan</li>
                        </ul>
                    </div>

                    {/* Role-Based Access */}
                    <div className="bg-white rounded-lg shadow-lg p-8 border-t-4 border-red-500 hover:shadow-xl transition-shadow">
                        <div className="text-4xl mb-4">🔐</div>
                        <h3 className="text-xl font-bold text-gray-900 mb-3">Akses Berlevel</h3>
                        <ul className="text-gray-600 space-y-2">
                            <li>• Administrator: Kontrol penuh</li>
                            <li>• Pengurus: Manajemen terbatas</li>
                            <li>• Kader: Akses sesuai kebutuhan</li>
                            <li>• Keamanan data terjamin</li>
                        </ul>
                    </div>
                </div>

                {/* Call to Action */}
                <div className="text-center bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl p-12 text-white">
                    <h3 className="text-3xl font-bold mb-4">
                        🚀 Siap Bergabung dengan SIK HMI?
                    </h3>
                    <p className="text-xl mb-8 opacity-90">
                        Mulai perjalanan digital Anda sebagai bagian dari keluarga besar HMI Hukum Brawijaya
                    </p>
                    <div className="space-x-4">
                        <Link href="/login">
                            <Button size="lg" variant="outline" className="bg-white text-green-600 hover:bg-gray-50 px-8 py-3 text-lg font-semibold">
                                🔐 Masuk
                            </Button>
                        </Link>
                        <Link href="/register">
                            <Button size="lg" className="bg-green-800 hover:bg-green-900 px-8 py-3 text-lg font-semibold">
                                📝 Daftar Sekarang
                            </Button>
                        </Link>
                    </div>
                    <p className="mt-6 text-sm opacity-75">
                        Akun baru otomatis berlevel "Kader" dan perlu verifikasi untuk akses penuh
                    </p>
                </div>

                {/* Demo Statistics */}
                <div className="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div className="text-center">
                        <div className="text-4xl font-bold text-green-600">500+</div>
                        <div className="text-gray-600">Kader Terdaftar</div>
                    </div>
                    <div className="text-center">
                        <div className="text-4xl font-bold text-blue-600">1,200+</div>
                        <div className="text-gray-600">Koleksi Buku</div>
                    </div>
                    <div className="text-center">
                        <div className="text-4xl font-bold text-purple-600">300+</div>
                        <div className="text-gray-600">Karya Kader</div>
                    </div>
                    <div className="text-center">
                        <div className="text-4xl font-bold text-orange-600">150+</div>
                        <div className="text-gray-600">Kegiatan</div>
                    </div>
                </div>
            </main>

            {/* Footer */}
            <footer className="bg-green-800 text-white py-12 mt-20">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <div className="mb-6">
                        <h4 className="text-2xl font-bold mb-2">🕌 HMI Hukum Brawijaya</h4>
                        <p className="text-green-200 italic">"Yakin Usaha Sampai"</p>
                    </div>
                    
                    <div className="border-t border-green-700 pt-6">
                        <p className="text-green-200 mb-2">
                            © 2025 Copyright HMI Hukum Brawijaya
                        </p>
                        <p className="text-sm text-green-300">
                            Pengembangan Web Didukung Oleh Bidang Penelitian dan Pengembangan HMI Hukum Brawijaya
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    );
}