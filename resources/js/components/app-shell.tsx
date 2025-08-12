import React from 'react';
import { AppHeader } from '@/components/app-header';
import { AppContent } from '@/components/app-content';
import { SidebarProvider } from '@/components/ui/sidebar';
import { SharedData, BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/react';

interface AppShellProps {
    children: React.ReactNode;
    variant?: 'header' | 'sidebar';
    breadcrumbs?: BreadcrumbItem[];
}

export function AppShell({ children, variant = 'header', breadcrumbs = [] }: AppShellProps) {
    const isOpen = usePage<SharedData>().props.sidebarOpen;

    if (variant === 'header') {
        return (
            <div className="flex min-h-screen w-full flex-col bg-gray-50">
                <AppHeader breadcrumbs={breadcrumbs} />
                <AppContent variant={variant} className="flex-1 p-6">
                    {children}
                </AppContent>
            </div>
        );
    }

    return (
        <SidebarProvider defaultOpen={isOpen}>
            <div className="flex min-h-screen w-full flex-col">
                <AppHeader breadcrumbs={breadcrumbs} />
                <AppContent variant={variant} className="flex-1 p-6">
                    {children}
                </AppContent>
            </div>
        </SidebarProvider>
    );
}