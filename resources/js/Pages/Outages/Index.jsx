import * as React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { Inertia } from '@inertiajs/inertia';
import { format } from 'date-fns';

export default function Index({ auth, outages }) {
  const handleGenerateOutage = () => {
    Inertia.post('/outages/generate');
  };

  const handleStopOutages = () => {
    Inertia.post('/outages/stop-all');
  };

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Outages</h2>}
    >
      <Head title="Outages" />
      <div className="py-8">
        <div className="max-w-screen-xl mx-auto sm:px-6 lg:px-8">
          <button
            onClick={handleGenerateOutage}
            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2"
          >
            Generate Outage
          </button>
          <button
            onClick={handleStopOutages}
            className="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
          >
            Stop All Outages
          </button>
          <div className="mt-4">
            <table className="min-w-full bg-white dark:bg-gray-800">
              <thead className='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500'>
                <tr>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Outage Number</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">OLT</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team Type</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Start Time</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">End Time</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Duration (hours)</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Status</th>
                </tr>
              </thead>
              <tbody>
                {outages.map((outage) => (
                  <tr key={outage.id} className="text-customBlue">
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.id}</td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.olt.olt_name}</td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.team.team_name}</td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.team.team_type}</td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                      {format(new Date(outage.start_time), 'yyyy-MM-dd HH:mm:ss')}
                    </td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                      {outage.end_time ? format(new Date(outage.end_time), 'yyyy-MM-dd HH:mm:ss') : 'N/A'}
                    </td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                      {(outage.duration / 3600).toFixed(2)}
                    </td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                      {outage.status ? 'Active' : 'Resolved'}
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
