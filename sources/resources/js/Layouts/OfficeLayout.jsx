import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import HasSidebar from "@/Pages/Office/Components/HasSidebar";
import {usePage} from "@inertiajs/react";
export default function OfficeLayout({ children }) {
    const { auth } = usePage().props

    return (
        <AuthenticatedLayout user={auth.user}>
            <div className="w-full flex">
                <div className="w-1/5">
                    <HasSidebar posttype={auth.posttype}/>
                </div>
                <div className="w-4/5">
                    <div className="py-[15px]">
                        <div className="w-full mx-auto sm:px-6 lg:px-8">
                            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div className="p-6 text-gray-900">{children}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
