import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import StatisticsCard from '@/Components/StatisticsCard';
import MapComponent from '@/Components/MapComponent';
import CustomerOLTBreakdown from '@/Components/CustomerOLTBreakdown';
import RecentOutages from '@/Components/RecentOutages';
import TeamsDeployed from '@/Components/TeamsDeployed';
import CustomerTypeBreakdown from '@/Components/CustomerTypeBreakdown';
import { OUTAGE_STATUS_CLASS_MAP, TEAM_STATUS_CLASS_MAP } from '@/constants';
import { format } from 'date-fns';

const Dashboard = ({ auth, stats, recentOutages, teamStatus, customers, oltData }) => {

    console.log("Stats", stats);


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
                        <div className="OLT-Breakdown rounded-lg inline-block">
                            <CustomerOLTBreakdown customers={customers} />
                        </div>
                        <div className="Refund-Amount">
                            <CustomerTypeBreakdown oltData={oltData} />
                        </div>
                        <div className="MapComponent">
                            <MapComponent title="OLT Deployment Map" />
                        </div>
                        <div className="Teams rounded-lg inline-block">
                            <TeamsDeployed teams={teamStatus} />
                        </div>
                        <div className="List-Of-Recent-Outages rounded-lg inline-block">
                            <RecentOutages outages={recentOutages} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Dashboard;
