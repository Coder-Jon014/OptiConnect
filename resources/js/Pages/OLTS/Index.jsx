import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { OLT_LEVEL_CLASS_MAP } from "@/constants";
import { Head } from "@inertiajs/react";

export default function Index({ auth, olts }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-white leading-tight">OLTs</h2>}
            subheader={<p className="font-regular text-md text-[var(--subheader)] leading-tight">List of OLTs in the system</p>}
        >
            <Head title="OLTs" />

            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="mt-4">
                        <div className="overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-2 text-gray-900 dark:text-gray-100">
                                <div className="overflow-auto rounded bg-[var(--foreground)] border-2 border-[var(--border)] p-4">
                                    <table className="min-w-full rounded-lg">
                                        <thead className="text-xs text-left text-[var(--table-headings)] uppercase rounded-t-lg border-b border-[var(--border)]">
                                            <tr>
                                                <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">OLT Name</th>
                                                <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Parish</th>
                                                <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Town</th>
                                                <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Customer Count</th>
                                                <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Business Customer Count</th>
                                                <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Residential Customer Count</th>
                                                <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">OLT Value</th>
                                                <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Resource</th>
                                                <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Rank</th>
                                                <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Level</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {olts.data.map((olt, index) => (
                                                <tr key={olt.olt_id} className={`hover:bg-[var(--table-hover)] border-b border-[var(--border)] rounded-full text-white text-nowrap ${index === 0 ? 'bg-[var(--even-odd)]' : ''}`}>
                                                    <td className="py-2 px-4 rounded-l-lg ">{olt.olt_name}</td>
                                                    <td className="py-2 px-4 ">{olt.parish}</td>
                                                    <td className="py-2 px-4 ">{olt.town}</td>
                                                    <td className="py-2 px-4 ">{olt.customer_count}</td>
                                                    <td className="py-2 px-4 ">{olt.business_customer_count}</td>
                                                    <td className="py-2 px-4 ">{olt.residential_customer_count}</td>
                                                    <td className="py-2 px-4 ">{olt.olt_value}</td>
                                                    <td className="py-2 px-4 ">{olt.resource_name}</td>
                                                    <td className="py-2 px-4 ">{olt.rank}</td>
                                                    <td className={`py-2 px-4 rounded-r-lg ${OLT_LEVEL_CLASS_MAP[olt.level ? 'High' : 'Low']}`}>{olt.level ? 'High' : 'Low'}</td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

/*
    This is the OLTs Index page. It is a React functional component. It receives two props: auth and olts.
    The auth prop is an object that contains the authenticated user information.
    The olts prop is an array of OLTs.

    The component returns an AuthenticatedLayout component that contains the authenticated user information and a header.
    The header is a heading that says "OLTs".

    The component also returns a Head component that sets the title of the page to "OLTs".

    The component returns a div element with the class "py-8" that contains a div element with the classes "max-w-7xl mx-auto sm:px-6 lg:px-8".
    Inside this div element, there is a div element with the classes "bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg".
    Inside this div element, there is a div element with the classes "p-6 text-gray-900 dark:text-gray-100".

    Inside this last div element, there is a pre element that displays the olts prop as a JSON string.

    This component is used to display the list of OLTs in the system.


     <div className="mt-4">
            <table className="min-w-full bg-white dark:bg-gray-800">
              <thead className='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500'>
                <tr>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Outage Number</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">OLT</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Town</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Customer Count</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Business Customer Count</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Residential Customer Count</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">OLT Value</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Resources</th>
                </tr>
              </thead>
              <tbody>
                
*/