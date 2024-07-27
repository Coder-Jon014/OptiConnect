import React, { useMemo } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import StatisticsCard from '@/Components/StatisticsCard';
import MapComponent from '@/Components/MapComponent';
import OLTPieChart from '@/Components/OLTPieChart';
import RecentOutages from '@/Components/RecentOutages';
import TeamsDeployed from '@/Components/TeamsDeployed';
import OLTValueBarChart from '@/Components/OLTValueBarChart';
import { AlertDestructive } from '@/Components/AlerWarning';
import { OUTAGE_STATUS_CLASS_MAP } from '@/constants';
import { format } from 'date-fns';

const Dashboard = ({ auth, stats, recentOutages, teamStatus, customers, oltData }) => {

    // Memoize filtered ongoing outages
    const ongoingOutages = useMemo(() => {
        return recentOutages.filter(outage => outage.status === 1);
    }, [recentOutages]);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-white leading-tight">Dashboard</h2>}
            subheader={<p className="font-regular text-md text-[var(--subheader)] leading-tight">Dashboard for the system</p>}
        >
            <Head title="Dashboard" />
            <div className="py-12">
                <div className="w-full mx-auto sm:px-6 lg:px-8">
                    {ongoingOutages.map((outage, index) => (
                        <AlertDestructive
                            key={index}
                            header="Outage Ongoing"
                            message={`${outage.olt.olt_name} is currently having an outage with ${outage.team.team_type} ${outage.team.team_name} assigned to it.`}
                        />
                    ))}
                    <div className="container">
                        <div className="OLT-Breakdown rounded-lg inline-block">
                            <OLTPieChart customers={customers} />
                        </div>
                        <div className="Refund-Amount">
                            <OLTValueBarChart oltData={oltData} />
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
