import React, { useMemo } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import StatisticsCard from '@/Components/StatisticsCard';
import MapComponent from '@/Components/MapComponent';
import NumbersCard from '@/Components/NumbersCard';
import OLTPieChart from '@/Components/OLTPieChart';
import RecentOutages from '@/Components/RecentOutages';
import NumberOfTimesTeamDeployedChart from '@/Components/NumberOfTimesTeamDeployedChart';
import TeamsDeployed from '@/Components/TeamsDeployed';
import OLTValueBarChart from '@/Components/OLTValueBarChart';
import { AlertDestructive } from '@/Components/AlerWarning';
import { formatValue } from '@/Components/formatValue';
import { OUTAGE_STATUS_CLASS_MAP } from '@/constants';
import { format } from 'date-fns';

const Dashboard = ({ auth, recentOutages, teamStatus, oltData, stats }) => {

    // Memoize filtered ongoing outages
    const ongoingOutages = useMemo(() => {
        return recentOutages.filter(outage => outage.status === true);
    }, [recentOutages]);
    console.log(stats);

    

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
                        <div className="Number-Card-1 rounded-lg inline-block">
                            <NumbersCard title="Total Number of Outages this Month" value={stats.totalOutages} description="Total outages occurred this month" />
                        </div>
                        <div className="Number-Card-2 rounded-lg inline-block">
                            <NumbersCard title="Days Since The Last Outage" value={stats.daysSinceLastOutage} description="Days since last outage" />
                        </div>
                        <div className="Number-Card-3 rounded-lg inline-block">
                            <NumbersCard title="Total Refund for This Month" value={formatValue(stats.totalRefund)} other='USD' description="Total refund for this month" />
                        </div>
                        <div className="Number-Card-4 rounded-lg inline-block">
                            <NumbersCard title="Total Outages Solved Within SLA" value={stats.totalNoRefund} description="Total outages solved within SLA" />
                        </div>
                        <div className="OLT-Breakdown rounded-lg inline-block">
                            <OLTPieChart oltData={oltData} />
                        </div>
                        <div className="OLT-Value-Breakdown">
                            <OLTValueBarChart oltData={oltData} />
                        </div>
                        <div className="MapComponent">
                        <MapComponent title="OLT Deployment Map" ongoingOutages={ongoingOutages} onTowerClick={() => {}} />
                        </div>
                        <div className="Teams rounded-lg inline-block">
                            <TeamsDeployed teams={teamStatus} />
                        </div>
                        <div className="List-Of-Recent-Outages rounded-lg inline-block">
                            <RecentOutages outages={recentOutages} />
                        </div>
                        <div className="Number-Of-Times-Deployed rounded-lg inline-block">
                            <NumberOfTimesTeamDeployedChart data={stats.numberofTimeTeamdeployed} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Dashboard;
