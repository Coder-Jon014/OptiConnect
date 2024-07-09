import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import Pagination from '@/Components/Pagination';

export default function Index({ auth, slas, queryParams }) {
    const slaList = slas.data || [];
    console.log(slaList);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">SLAs</h2>}
        >
            <Head title="SLAs" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                    <tr>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Outage ID</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Refund Amount</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Duration (Hours)</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Compensation Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {slaList.map((sla) => (
                                        <tr key={sla.id}>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{sla.id}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(sla.refund_amount)}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{sla.max_duration}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{sla.compensation_details}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                            <Pagination links={slas.links} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
