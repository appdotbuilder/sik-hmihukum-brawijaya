import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import type { BreadcrumbItem } from '@/types';

interface Book {
    id: number;
    title: string;
    author: string;
    description: string;
    type: 'physical' | 'digital';
    category: string;
    status: string;
    stock: number;
    cover_image?: string;
}

interface KaryaKader {
    id: number;
    title: string;
    description: string;
    type: 'physical' | 'digital';
    category: string;
    status: string;
    stock: number;
    user: {
        id: number;
        name: string;
    };
    cover_image?: string;
}

interface Props {
    books: {
        data: Book[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    karyaKaders: {
        data: KaryaKader[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    // filters parameter removed as it's not used in the component
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Perpustakaan',
        href: '/library',
    },
];

export default function LibraryIndex({ books, karyaKaders }: Props) {
    const [activeTab, setActiveTab] = useState<'books' | 'karya'>('books');
    
    const getTypeIcon = (type: string) => {
        return type === 'digital' ? '💻' : '📚';
    };

    const getCategoryColor = (category: string) => {
        const colors = {
            'islamic': 'bg-green-100 text-green-800',
            'law': 'bg-blue-100 text-blue-800',
            'research': 'bg-purple-100 text-purple-800',
            'textbook': 'bg-orange-100 text-orange-800',
            'reference': 'bg-indigo-100 text-indigo-800',
            'general': 'bg-gray-100 text-gray-800',
            'article': 'bg-yellow-100 text-yellow-800',
            'thesis': 'bg-red-100 text-red-800',
            'proposal': 'bg-pink-100 text-pink-800',
        };
        return colors[category as keyof typeof colors] || 'bg-gray-100 text-gray-800';
    };

    return (
        <AppShell breadcrumbs={breadcrumbs}>
            <Head title="Perpustakaan Komisariat - SIK HMI Hukum Brawijaya" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-6 text-white">
                    <h1 className="text-3xl font-bold mb-2">
                        📚 Perpustakaan Komisariat HMI Hukum Brawijaya
                    </h1>
                    <p className="opacity-90">
                        Akses koleksi buku dan karya kader digital maupun fisik. 
                        Baca langsung atau pinjam sesuai kebutuhan studi Anda.
                    </p>
                </div>

                {/* Statistics */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div className="bg-white rounded-lg shadow-md p-4 text-center">
                        <div className="text-3xl font-bold text-blue-600">{books.total}</div>
                        <div className="text-sm text-gray-600">Total Buku</div>
                    </div>
                    <div className="bg-white rounded-lg shadow-md p-4 text-center">
                        <div className="text-3xl font-bold text-purple-600">{karyaKaders.total}</div>
                        <div className="text-sm text-gray-600">Karya Kader</div>
                    </div>
                    <div className="bg-white rounded-lg shadow-md p-4 text-center">
                        <div className="text-3xl font-bold text-green-600">
                            {books.data.filter(b => b.type === 'digital').length + karyaKaders.data.filter(k => k.type === 'digital').length}
                        </div>
                        <div className="text-sm text-gray-600">Konten Digital</div>
                    </div>
                    <div className="bg-white rounded-lg shadow-md p-4 text-center">
                        <div className="text-3xl font-bold text-orange-600">24/7</div>
                        <div className="text-sm text-gray-600">Akses Digital</div>
                    </div>
                </div>

                {/* Tabs */}
                <div className="bg-white rounded-lg shadow-md">
                    <div className="border-b border-gray-200">
                        <nav className="flex">
                            <button
                                onClick={() => setActiveTab('books')}
                                className={`px-6 py-3 text-sm font-medium border-b-2 ${
                                    activeTab === 'books'
                                        ? 'border-blue-500 text-blue-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                }`}
                            >
                                📚 Buku ({books.total})
                            </button>
                            <button
                                onClick={() => setActiveTab('karya')}
                                className={`px-6 py-3 text-sm font-medium border-b-2 ${
                                    activeTab === 'karya'
                                        ? 'border-purple-500 text-purple-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                }`}
                            >
                                📝 Karya Kader ({karyaKaders.total})
                            </button>
                        </nav>
                    </div>

                    <div className="p-6">
                        {/* Books Tab */}
                        {activeTab === 'books' && (
                            <div>
                                {books.data.length > 0 ? (
                                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        {books.data.map((book) => (
                                            <div key={book.id} className="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                                <div className="flex items-start justify-between mb-3">
                                                    <div className="flex items-center space-x-2">
                                                        <span className="text-2xl">{getTypeIcon(book.type)}</span>
                                                        <span className={`px-2 py-1 text-xs rounded-full ${getCategoryColor(book.category)}`}>
                                                            {book.category}
                                                        </span>
                                                    </div>
                                                    {book.type === 'physical' && (
                                                        <span className="text-sm text-gray-500">Stok: {book.stock}</span>
                                                    )}
                                                </div>
                                                
                                                <h3 className="font-semibold text-gray-900 mb-2 line-clamp-2">
                                                    {book.title}
                                                </h3>
                                                
                                                <p className="text-sm text-gray-600 mb-2">
                                                    Penulis: {book.author}
                                                </p>
                                                
                                                <p className="text-sm text-gray-500 mb-4 line-clamp-3">
                                                    {book.description}
                                                </p>
                                                
                                                <Link href={`/books/${book.id}`}>
                                                    <Button 
                                                        size="sm" 
                                                        className="w-full bg-blue-600 hover:bg-blue-700"
                                                    >
                                                        {book.type === 'digital' ? '🖥️ Baca Digital' : '📖 Detail Buku'}
                                                    </Button>
                                                </Link>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <div className="text-center py-12">
                                        <div className="text-6xl mb-4">📚</div>
                                        <h3 className="text-lg font-medium text-gray-900 mb-2">Belum Ada Buku</h3>
                                        <p className="text-gray-500">Koleksi buku akan segera ditambahkan.</p>
                                    </div>
                                )}
                            </div>
                        )}

                        {/* Karya Kader Tab */}
                        {activeTab === 'karya' && (
                            <div>
                                {karyaKaders.data.length > 0 ? (
                                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        {karyaKaders.data.map((karya) => (
                                            <div key={karya.id} className="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                                <div className="flex items-start justify-between mb-3">
                                                    <div className="flex items-center space-x-2">
                                                        <span className="text-2xl">{getTypeIcon(karya.type)}</span>
                                                        <span className={`px-2 py-1 text-xs rounded-full ${getCategoryColor(karya.category)}`}>
                                                            {karya.category}
                                                        </span>
                                                    </div>
                                                    {karya.type === 'physical' && (
                                                        <span className="text-sm text-gray-500">Stok: {karya.stock}</span>
                                                    )}
                                                </div>
                                                
                                                <h3 className="font-semibold text-gray-900 mb-2 line-clamp-2">
                                                    {karya.title}
                                                </h3>
                                                
                                                <p className="text-sm text-gray-600 mb-2">
                                                    Penulis: {karya.user.name}
                                                </p>
                                                
                                                <p className="text-sm text-gray-500 mb-4 line-clamp-3">
                                                    {karya.description}
                                                </p>
                                                
                                                <Link href={`/karya-kaders/${karya.id}`}>
                                                    <Button 
                                                        size="sm" 
                                                        className="w-full bg-purple-600 hover:bg-purple-700"
                                                    >
                                                        {karya.type === 'digital' ? '🖥️ Baca Digital' : '📖 Detail Karya'}
                                                    </Button>
                                                </Link>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <div className="text-center py-12">
                                        <div className="text-6xl mb-4">📝</div>
                                        <h3 className="text-lg font-medium text-gray-900 mb-2">Belum Ada Karya</h3>
                                        <p className="text-gray-500">Karya kader akan segera ditambahkan.</p>
                                    </div>
                                )}
                            </div>
                        )}
                    </div>
                </div>

                {/* Islamic Quote */}
                <div className="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                    <div className="text-2xl mb-3">📖</div>
                    <p className="text-green-800 font-medium italic mb-2">
                        "Dan Katakanlah: 'Tuhanku, Tambahkanlah Kepadaku Ilmu Pengetahuan'"
                    </p>
                    <p className="text-green-600 text-sm">
                        - QS. Taha: 114 -
                    </p>
                    <p className="text-green-700 text-xs mt-3 font-medium">
                        Teruslah belajar dan menambah ilmu melalui membaca
                    </p>
                </div>
            </div>
        </AppShell>
    );
}