import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import OfficeLayout from '@/Layouts/OfficeLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard() {
    return (
        <OfficeLayout>
            <Head title="Dashboard" />

            You're logged in! 11111
        </OfficeLayout>
    );
}
