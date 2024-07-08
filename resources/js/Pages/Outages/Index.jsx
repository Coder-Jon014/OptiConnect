import * as React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';
import { Inertia } from '@inertiajs/inertia';
import { format } from 'date-fns';
import Pagination from '@/Components/Pagination';
import { OUTAGE_STATUS_CLASS_MAP } from '@/constants';
import TextInput from '@/Components/TextInput';
import TableHeading from '@/Components/TableHeading';

export default function Index({ auth, outages, queryParams = null }) {

  queryParams = queryParams || {};
  const searchFieldChanged = (name, value) => {
    if (value) {
      queryParams[name] = value;
    } else {
      delete queryParams[name];
    }
    router.get(route('outage.index'), queryParams);
  };

  const sortChanged = (name) => {
    if (name === queryParams.sort_field) {
      if (queryParams.sort_direction === 'asc') {
        queryParams.sort_direction = 'desc';
      } else {
        queryParams.sort_direction = 'asc';
      }
    } else {
      queryParams.sort_field = name;
      queryParams.sort_direction = 'asc';
    }
    router.get(route('outage.index'), queryParams);
  }

  const onKeyPress = (name, e) => {
    if (e.key !== 'Enter') return;
    searchFieldChanged(name, e.target.value);
  };

  // Ensure outages is an array
  const outageList = outages.data || [];

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
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="mt-4">
            <div className='py-3'>
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
            </div>
            <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div className="p-6 text-gray-900 dark:text-gray-100">
                <div className="overflow-auto">
                  <table className="min-w-full bg-white dark:bg-gray-800 mt-4">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                      <tr>
                        <TableHeading
                          name="outage_id"
                          sort_direction={queryParams.sort_direction}
                          sort_field={queryParams.sort_field}
                          sortChanged={sortChanged}
                        >
                          Outage Number
                        </TableHeading>
                        <TableHeading
                          name="olt"
                          sort_direction={queryParams.sort_direction}
                          sort_field={queryParams.sort_field}
                          sortChanged={sortChanged}
                        >
                          OLT
                        </TableHeading>
                        <TableHeading
                          name="team"
                          sort_direction={queryParams.sort_direction}
                          sort_field={queryParams.sort_field}
                          sortChanged={sortChanged}
                        >
                          Team
                        </TableHeading>
                        <TableHeading
                          name="team_type"
                          sort_direction={queryParams.sort_direction}
                          sort_field={queryParams.sort_field}
                          sortChanged={sortChanged}
                        >
                          Team Type
                        </TableHeading>
                        <TableHeading
                          name="start_time"
                          sort_direction={queryParams.sort_direction}
                          sort_field={queryParams.sort_field}
                          sortChanged={sortChanged}
                        >
                          Start Time
                        </TableHeading>
                        <TableHeading
                          name="end_time"
                          sort_direction={queryParams.sort_direction}
                          sort_field={queryParams.sort_field}
                          sortChanged={sortChanged}
                        >
                          End Time
                        </TableHeading>
                        <TableHeading
                          name="duration"
                          sort_direction={queryParams.sort_direction}
                          sort_field={queryParams.sort_field}
                          sortChanged={sortChanged}
                        >
                          Duration (hours)
                        </TableHeading>
                        <TableHeading
                          name="status"
                          sort_direction={queryParams.sort_direction}
                          sort_field={queryParams.sort_field}
                          sortChanged={sortChanged}
                        >
                          Status
                        </TableHeading>
                      </tr>
                    </thead>
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                      <tr>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700"></th>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                          <TextInput
                            className="w-full"
                            defaultValue={queryParams.olt}
                            placeholder="OLT"
                            onBlur={e => searchFieldChanged('olt', e.target.value)}
                            onKeyPress={e => onKeyPress('olt', e)} />
                        </th>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                          <TextInput
                            className="w-full"
                            defaultValue={queryParams.team}
                            placeholder="Team"
                            onBlur={e => searchFieldChanged('team', e.target.value)}
                            onKeyPress={e => onKeyPress('team', e)} />
                        </th>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700"></th>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700"></th>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700"></th>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700"></th>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700"></th>
                      </tr>
                    </thead>
                    <tbody>
                      {outageList.map((outage) => (
                        <tr key={outage.id} className="text-customBlue text-nowrap">
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.outage_id}</td>
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.olt}</td>
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.team}</td>
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.team_type}</td>
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.start_time}</td>
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{outage.end_time}</td>
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{Math.max(0, (outage.duration)).toFixed(2)}</td>
                          <td className={`py-2 px-4 border-b border-gray-200 dark:border-gray-700 ${OUTAGE_STATUS_CLASS_MAP[outage.status ? 'Active' : 'Resolved']}`}>{outage.status ? 'Active' : 'Resolved'}</td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <Pagination links={outages.meta.links} />
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
