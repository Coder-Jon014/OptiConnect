import React from 'react';
import StatisticsCard from '@/Components/StatisticsCard';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { format } from 'date-fns';
import MapComponent from '@/Components/MapComponent';

const Dashboard = ({ auth, stats, recentOutages, teamStatus }) => {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <MapComponent />
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <StatisticsCard title="Total OLTs" value={stats.totalOlts} />
                        <StatisticsCard title="Total Teams" value={stats.totalTeams} />
                        <StatisticsCard title="Ongoing Outages" value={`${stats.ongoingOutages}/${stats.totalOutages}`} />
                    </div>



                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <h3 className="text-lg font-semibold mb-4">Recent Outages</h3>
                            <table className="min-w-full bg-white dark:bg-gray-800">
                                <thead className='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500'>
                                    <tr>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">OLT</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Start Time</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Duration (hours)</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {recentOutages.map((outage) => (
                                        <tr key={outage.outage_id} className="text-customBlue">
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.olt.olt_name}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.team.team_name}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{format(new Date(outage.start_time), 'yyyy-MM-dd HH:mm:ss')}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{(outage.duration / 3600).toFixed(2)}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.status ? 'Active' : 'Resolved'}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <h3 className="text-lg font-semibold mb-4">Team Status</h3>
                            <table className="min-w-full bg-white dark:bg-gray-800">
                                <thead className='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500'>
                                    <tr>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Resources</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {teamStatus.map((team) => (
                                        <tr key={team.team_id} className="text-customBlue">
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{team.team_name}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                                {team.resources.map(resource => resource.resource_name).join(', ')}
                                            </td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{team.is_active ? 'Active' : 'Inactive'}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Dashboard;
