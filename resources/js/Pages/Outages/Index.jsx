import * as React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';
import { Inertia } from '@inertiajs/inertia';
import { format } from 'date-fns';
import Pagination from '@/Components/Pagination';
import { OUTAGE_STATUS_CLASS_MAP } from '@/constants';
import TextInput from '@/Components/TextInput';
import SelectInput from '@/Components/SelectInput';
import TableHeading from '@/Components/TableHeading';

export default function Index({ auth, outages, slas, queryParams = null }) {


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

  const handleExportOutageReport = () => {
    Inertia.get('/outages/report');
  }

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-white leading-tight">Outages</h2>}
      subheader={<p className="font-regular text-md text-[var(--subheader)] leading-tight">List of outages in the system</p>}
    >
      <Head title="Outages" />
      <div className="py-8">
        <div className="w-full mx-auto sm:px-6 lg:px-8">
          <div className="mt-4">
            <div className="overflow-hidden shadow-sm sm:rounded-lg">
              <div className="p-6 text-gray-900 dark:text-gray-100">
              <button
                onClick={handleGenerateOutage}
                className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2 mb-2"
              >
                Generate Outage
              </button>
              <button
                onClick={handleStopOutages}
                className="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mb-2"
              >
                Stop All Outages
              </button>
              <button
                onClick={handleExportOutageReport}
                className="bg-green-700 hover:bg-green-900 text-white font-bold py-2 px-4 rounded ml-2 mb-2"
              >
                Export Outage Report
              </button>
                <div className="overflow-auto rounded bg-[var(--foreground)] border-2 border-[var(--border)] p-4">
                  <table className="w-full text-sm text-left rtl:text-right text-white">
                    <thead className="text-xs text-[var(--table-headings)] uppercase rounded-t-lg border-b border-[var(--border)]">
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
                          Duration (Days)
                        </TableHeading>
                        <TableHeading
                          name="status"
                          sort_direction={queryParams.sort_direction}
                          sort_field={queryParams.sort_field}
                          sortChanged={sortChanged}
                        >
                          Status
                        </TableHeading>
                        <TableHeading
                          name="refund_amount"
                          sort_direction={queryParams.sort_direction}
                          sort_field={queryParams.sort_field}
                          sortChanged={sortChanged}
                        >
                          Refund Amount
                        </TableHeading>
                      </tr>
                    </thead>
                    <tbody>
                      {outageList.map((outage, index) => (
                        <tr key={outage.id} className={`hover:bg-[var(--table-hover)] rounded-lg border-b border-[var(--border)] text-white ${index === 0 ? 'bg-[var(--even-odd)]' : ''}`}>
                          <td className="py-2 px-4 rounded-l-lg ">{outage.outage_id}</td>
                          <td className="py-2 px-4 ">{outage.olt}</td>
                          <td className="py-2 px-4 ">{outage.team}</td>
                          <td className="py-2 px-4 ">{outage.team_type}</td>
                          <td className="py-2 px-4 ">{outage.start_time}</td>
                          <td className="py-2 px-4 ">{outage.end_time}</td>
                          <td className="py-2 px-4 ">{Math.max(0, (outage.duration / 24)).toFixed(0)}</td>
                          <td className={`py-2 px-4 ${OUTAGE_STATUS_CLASS_MAP[outage.status ? 'Active' : 'Resolved']}`}>{outage.status ? 'Active' : 'Resolved'}</td>
                          <td className="py-2 px-4 rounded-r-lg">{new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(outage.refund_amount)}</td>
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
