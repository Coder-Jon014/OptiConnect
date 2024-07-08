import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import StatisticsCard from '@/Components/StatisticsCard';
import { OUTAGE_STATUS_CLASS_MAP } from '@/constants';

const Dashboard = ({ auth, stats, recentOutages, teamStatus }) => {
    // Debugging: Log props to ensure data is received
    console.log('Stats:', stats);
    console.log('Recent Outages:', recentOutages);
    console.log('Team Status:', teamStatus);

    // Filter ongoing outages
    const ongoingOutages = recentOutages.filter(outage => outage.status === 1);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {ongoingOutages.length > 0 && (
                        <div className="mb-6 p-4 bg-red-100 text-red-800 rounded">
                            {ongoingOutages.map((outage, index) => (
                                <div key={index}>
                                    {outage.olt.olt_name} is currently having an outage. Team {outage.team.team_name} is working on it.
                                </div>
                            ))}
                        </div>
                    )}

                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <StatisticsCard title="Total OLTs" value={stats.totalOlts} />
                        <StatisticsCard title="Total Teams" value={stats.totalTeams} />
                        <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 className="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Currently Ongoing Outages</h3>
                            <div className="text-4xl font-bold text-white">
                                <span>{stats.ongoingOutages}</span>
                                <span className="text-gray-400">/{stats.totalOutages}</span>
                            </div>
                        </div>
                    </div>

                    {/* Recent Outages */}
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div className="p-6">
                            <h3 className="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Recent Outages</h3>
                            <table className="min-w-full bg-white dark:bg-gray-800">
                                <thead className='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500'>
                                    <tr className='text-nowrap'>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">OLT</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Start Time</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Duration (Hours)</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {recentOutages.map((outage, index) => (
                                        <tr key={index} className="text-customBlue">
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.olt.olt_name}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.team.team_name}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.start_time}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{Math.max(0, (outage.duration / 3600)).toFixed(2)}</td>
                                            <td className={`py-2 px-4 border-b border-gray-200 dark:border-gray-700 ${OUTAGE_STATUS_CLASS_MAP[outage.status ? 'Active' : 'Resolved']}`}>{outage.status ? 'Active' : 'Resolved'}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {/* Team Status */}
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Team Status</h3>
                            <table className="min-w-full bg-white dark:bg-gray-800">
                                <thead className='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500'>
                                    <tr>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team ID</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team Name</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Resources</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {teamStatus.map((team, index) => (
                                        <tr key={index} className="text-customBlue">
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{team.team_id}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{team.team_name}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                                {team.resources.map((resource, idx) => (
                                                    <span key={idx}>{resource.resource_name}{idx < team.resources.length - 1 ? ', ' : ''}</span>
                                                ))}
                                            </td>
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
