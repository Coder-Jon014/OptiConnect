import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import StatisticsCard from '@/Components/StatisticsCard';
import MapComponent from '@/Components/MapComponent';
import CustomerOLTBreakdown from '@/Components/CustomerOLTBreakdown';
import { OUTAGE_STATUS_CLASS_MAP, TEAM_STATUS_CLASS_MAP } from '@/constants';
import { format } from 'date-fns';

const Dashboard = ({ auth, stats, recentOutages, teamStatus, allOutages, customers }) => {
    // Debugging: Log props to ensure data is received
    // console.log('Stats:', stats);
    // console.log('Recent Outages:', recentOutages);
    // console.log('Team Status:', teamStatus);
    // console.log('All Outages:', allOutages);
    console.log('Customers:', customers);

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
            header={<h2 className="font-semibold text-xl text-white leading-tight">Dashboard</h2>}
            subheader={<p className="font-regular text-md text-[var(--subheader)] leading-tight">Dashboard for the system</p>}
        >
            <Head title="Dashboard" />
            <div className="py-12">
                <div className="w-full mx-auto sm:px-6 lg:px-8">
                    <div className="container">
                        <div className="OLT-Breakdown rounded-lg w-2/3">
                            <CustomerOLTBreakdown customers={customers} />
                        </div>
                        <div className="Refund-Amount">
                            Refund Amount
                        </div>
                        <div className="MapComponent">
                            Mapcomponent
                        </div>
                        <div className="Teams">
                            Teams
                        </div>
                        <div className="List-Of-Recent-Outages">
                            List Of Recent Outages
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Dashboard;
