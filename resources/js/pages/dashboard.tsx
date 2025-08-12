import React from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import type { BreadcrumbItem } from '@/types';

interface Props {
    stats: {
        total_users: number;
        total_books: number;
        total_digital_books: number;
        total_physical_books: number;
        total_karya_kaders: number;
        total_digital_karya: number;
        total_physical_karya: number;
        total_activities: number;
        upcoming_activities: number;
        active_borrowings: number;
        overdue_borrowings: number;
    };
    roleData: {
        pending_users?: number;
        recent_activities?: Array<{
            id: number;
            name: string;
            creator: {
                id: number;
                name: string;
            };
        }>;
        recent_borrowings?: Array<{
            id: number;
            user: {
                id: number;
                name: string;
            };
            borrowable: {
                id: number;
                title: string;
            };
        }>;
        user_distribution?: {
            administrator: number;
            pengurus: number;
            kader: number;
        };
        my_borrowings?: Array<{
            id: number;
            due_date: string;
            borrowable: {
                id: number;
                title: string;
            };
        }>;
        my_activities?: Array<{
            id: number;
            activity: {
                id: number;
                name: string;
                date: string;
            };
        }>;
    };
    user: {
        id: number;
        name: string;
        email: string;
        role: string;
        status: string;
        profile_completed: boolean;
        nomor_induk_kader?: string;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ stats, roleData, user }: Props) {
    const getGreeting = () => {
        const hour = new Date().getHours();
        if (hour < 12) return 'Selamat Pagi';
        if (hour < 15) return 'Selamat Siang'; 
        if (hour < 18) return 'Selamat Sore';
        return 'Selamat Malam';
    };

    const getRoleDisplay = (role: string) => {
        switch (role) {
            case 'administrator': return 'Administrator';
            case 'pengurus': return 'Pengurus';
            case 'kader': return 'Kader';
            default: return role;
        }
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'verified': return 'text-green-600 bg-green-100';
            case 'pending': return 'text-yellow-600 bg-yellow-100';
            case 'inactive': return 'text-red-600 bg-red-100';
            default: return 'text-gray-600 bg-gray-100';
        }
    };

    return (
        <AppShell breadcrumbs={breadcrumbs}>
            <Head title="Dashboard - SIK HMI Hukum Brawijaya" />
            
            <div className="space-y-6">
                {/* Header with Islamic Greeting */}
                <div className="bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg p-6 text-white">
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-2xl font-bold mb-2">
                                🕌 {getGreeting()}, {user.name}
                            </h1>
                            <p className="opacity-90 mb-2">
                                Barakallahu fiika - Semoga Allah memberkahi aktivitas Anda hari ini
                            </p>
                            <div className="flex items-center space-x-4">
                                <span className="text-sm bg-white/20 px-3 py-1 rounded-full">
                                    {getRoleDisplay(user.role)}
                                </span>
                                <span className={`text-sm px-3 py-1 rounded-full ${getStatusColor(user.status)}`}>
                                    {user.status === 'verified' ? 'Terverifikasi' : 
                                     user.status === 'pending' ? 'Menunggu Verifikasi' : 'Tidak Aktif'}
                                </span>
                                {user.nomor_induk_kader && (
                                    <span className="text-sm bg-white/20 px-3 py-1 rounded-full">
                                        NIK: {user.nomor_induk_kader}
                                    </span>
                                )}
                            </div>
                        </div>
                        <div className="text-6xl opacity-20">
                            📚
                        </div>
                    </div>
                </div>

                {/* Profile Completion Alert */}
                {!user.profile_completed && (
                    <div className="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div className="flex items-center">
                            <div className="text-yellow-400 text-xl mr-3">⚠️</div>
                            <div>
                                <p className="text-yellow-800 font-medium">Profil Belum Lengkap</p>
                                <p className="text-yellow-700 text-sm">
                                    Silakan lengkapi profil Anda untuk mendapatkan akses penuh ke fitur aplikasi.
                                </p>
                            </div>
                        </div>
                    </div>
                )}

                {/* Main Statistics */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {/* Total Users */}
                    <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600">Total Kader</p>
                                <p className="text-3xl font-bold text-gray-900">{stats.total_users}</p>
                            </div>
                            <div className="text-4xl text-green-500">👥</div>
                        </div>
                    </div>

                    {/* Total Books */}
                    <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600">Total Buku</p>
                                <p className="text-3xl font-bold text-gray-900">{stats.total_books}</p>
                                <p className="text-xs text-gray-500">
                                    Digital: {stats.total_digital_books} | Cetak: {stats.total_physical_books}
                                </p>
                            </div>
                            <div className="text-4xl text-blue-500">📚</div>
                        </div>
                    </div>

                    {/* Total Karya Kader */}
                    <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600">Karya Kader</p>
                                <p className="text-3xl font-bold text-gray-900">{stats.total_karya_kaders}</p>
                                <p className="text-xs text-gray-500">
                                    Digital: {stats.total_digital_karya} | Cetak: {stats.total_physical_karya}
                                </p>
                            </div>
                            <div className="text-4xl text-purple-500">📝</div>
                        </div>
                    </div>

                    {/* Activities */}
                    <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600">Kegiatan</p>
                                <p className="text-3xl font-bold text-gray-900">{stats.total_activities}</p>
                                <p className="text-xs text-gray-500">
                                    Mendatang: {stats.upcoming_activities}
                                </p>
                            </div>
                            <div className="text-4xl text-orange-500">📅</div>
                        </div>
                    </div>
                </div>

                {/* Additional Statistics */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {/* Library Statistics */}
                    <div className="bg-white rounded-lg shadow-md p-6">
                        <h3 className="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            📖 Status Perpustakaan
                        </h3>
                        <div className="space-y-3">
                            <div className="flex justify-between items-center">
                                <span className="text-gray-600">Peminjaman Aktif</span>
                                <span className="font-semibold text-blue-600">{stats.active_borrowings}</span>
                            </div>
                            <div className="flex justify-between items-center">
                                <span className="text-gray-600">Terlambat Dikembalikan</span>
                                <span className="font-semibold text-red-600">{stats.overdue_borrowings}</span>
                            </div>
                            <div className="border-t pt-3">
                                <div className="text-center">
                                    <p className="text-sm text-green-600 font-medium">
                                        ✨ Perpustakaan Digital Tersedia 24/7
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Role-specific Information */}
                    {user.role === 'kader' && roleData.my_borrowings && (
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                📚 Peminjaman Saya
                            </h3>
                            {roleData.my_borrowings.length > 0 ? (
                                <div className="space-y-3">
                                    {roleData.my_borrowings.slice(0, 3).map((borrowing, index: number) => (
                                        <div key={index} className="flex justify-between items-center text-sm">
                                            <span className="text-gray-600 truncate flex-1">
                                                {borrowing.borrowable.title}
                                            </span>
                                            <span className="text-blue-600 ml-2">
                                                {new Date(borrowing.due_date).toLocaleDateString('id-ID')}
                                            </span>
                                        </div>
                                    ))}
                                    {roleData.my_borrowings.length > 3 && (
                                        <p className="text-xs text-gray-500 text-center">
                                            +{roleData.my_borrowings.length - 3} peminjaman lainnya
                                        </p>
                                    )}
                                </div>
                            ) : (
                                <p className="text-gray-500 text-sm">Tidak ada peminjaman aktif</p>
                            )}
                        </div>
                    )}

                    {(user.role === 'administrator' || user.role === 'pengurus') && roleData.pending_users && (
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                ⏳ Verifikasi Pending
                            </h3>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-yellow-600 mb-2">
                                    {roleData.pending_users}
                                </div>
                                <p className="text-sm text-gray-600">
                                    Akun menunggu verifikasi
                                </p>
                            </div>
                        </div>
                    )}
                </div>

                {/* Islamic Quote */}
                <div className="bg-emerald-50 border border-emerald-200 rounded-lg p-6 text-center">
                    <div className="text-2xl mb-3">🕌</div>
                    <p className="text-emerald-800 font-medium italic mb-2">
                        "Dan barangsiapa bertakwa kepada Allah niscaya Dia akan mengadakan baginya jalan keluar"
                    </p>
                    <p className="text-emerald-600 text-sm">
                        - QS. At-Talaq: 2 -
                    </p>
                    <p className="text-emerald-700 text-xs mt-3 font-medium">
                        Mari kita terus belajar dan berkarya untuk kemajuan umat
                    </p>
                </div>
            </div>
        </AppShell>
    );
}