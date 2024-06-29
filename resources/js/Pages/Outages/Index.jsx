import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage } from "@inertiajs/react";
import { Inertia } from '@inertiajs/inertia';
import React from 'react';
import { DataGrid } from '@mui/x-data-grid';


export default function Index({ auth, outages }) {
    const handleOutageGeneration = () => {
        Inertia.post('/outages/generate');
    };

    const handleStopAllOutages = () => {
        Inertia.post('/outages/stop-all');
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Outages</h2>}
        >
            <Head title="Outages" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="flex justify-end space-x-4 mb-4">
                                <button onClick={handleOutageGeneration} className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Generate Outage
                                </button>
                                <button onClick={handleStopAllOutages} className="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Stop All Outages
                                </button>
                            </div>
                            <pre>{JSON.stringify(outages, undefined, 2)}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
