import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import StatisticsCard from '@/Components/StatisticsCard';
import MapComponent from '@/Components/MapComponent';
import { OUTAGE_STATUS_CLASS_MAP, TEAM_STATUS_CLASS_MAP } from '@/constants';
import { format } from 'date-fns';

const Dashboard = ({ auth, stats, recentOutages, teamStatus, allOutages }) => {
    // Debugging: Log props to ensure data is received
    console.log('Stats:', stats);
    console.log('Recent Outages:', recentOutages);
    console.log('Team Status:', teamStatus);
    console.log('All Outages:', allOutages);

    // Filter OLTs with outages
    const [filteredOLT, setFilteredOLT] = useState(null);

    // Filter OLTs with ongoing outages
    const handleTowerClick = (oltName) => {
        setFilteredOLT(filteredOLT === oltName ? null : oltName);
    };

    // Filter outages by OLT
    const filteredOutages = filteredOLT
        ? recentOutages.filter(outage => outage.olt.olt_name === filteredOLT)
        : recentOutages;


    // Filter OLTs with ongoing outages
    const ongoingOutages = recentOutages.filter(outage => outage.status);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {/* Ongoing Outages */}
                    {ongoingOutages.length > 0 && (
                        <div className="mb-6 p-4 bg-red-100 text-red-800 rounded">
                            {ongoingOutages.map((outage, index) => (
                                <div key={index}>
                                    {outage.olt.olt_name} is currently having an outage. {outage.team.team_name} is working on it.
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
                                <span className="text-gray-400 font-medium text-sm">/{stats.totalOutages}</span>
                            </div>
                        </div>
                    </div>
                    <MapComponent title="OLT Locations" onTowerClick={handleTowerClick} />
                    {/* If OLT is selected, filter outages from all outages by OLT, otherwise show recent outages from recent outages */}

                    {/* Recent Outages */}
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div className="p-6">
                            <h3 className="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Recent Outages</h3>
                            <table className="min-w-full bg-white dark:bg-gray-800">
                                <thead className='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500'>
                                    <tr>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">OLT</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team Type</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Start Time</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Outage Duration</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {filteredOutages.map((outage, index) => (
                                        <tr key={index} className="text-customBlue">

                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-center">{outage.olt.olt_name}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-center">{outage.team.team_name}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-center">{outage.team.team_type}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-center">{format(new Date(outage.start_time), 'yyyy-MM-dd HH:mm:ss')}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{Math.max(0, (outage.duration / 86400)).toFixed(0)}</td>
                                            <td className={`py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-center ${OUTAGE_STATUS_CLASS_MAP[outage.status ? 'Active' : 'Resolved']}`}>{outage.status ? 'Active' : 'Resolved'}</td>
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
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team Name</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Resources</th>
                                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {teamStatus.map((team, index) => (
                                        <tr key={index} className="text-customBlue">
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{team.team_name}</td>
                                            <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                                {team.resources.map((resource, idx) => (
                                                    <span key={idx}>{resource.resource_name}{idx < team.resources.length - 1 ? ', ' : ''}</span>
                                                ))}
                                            </td>
                                            <td className={`py-2 px-4 border-b border-gray-200 dark:border-gray-700 ${TEAM_STATUS_CLASS_MAP[team.status ? 'Active' : 'Inactive']}`}>{team.status ? 'Active' : 'Inactive'}</td>
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
