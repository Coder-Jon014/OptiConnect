import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function Index({ auth, teams }) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Teams</h2>}
    >
      <Head title="Teams" />

      <div className="py-8">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="mt-4">
            <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div className="p-6 text-gray-900 dark:text-gray-100">
                <div className="overflow-auto">
                  <table className="min-w-full bg-white dark:bg-gray-800">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                      <tr>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team Name</th>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team Type</th>
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Resources</th>
                      </tr>
                    </thead>
                    <tbody>
                      {teams.data.map((team) => (
                        <tr key={team.team_id} className="text-customBlue">
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{team.team_name}</td>
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{team.team_type}</td>
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                            {team.resource_name.join(', ')}
                          </td>
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
    This is the Teams Index page. It is a React functional component. It receives two props: auth and teams.
    The auth prop is an object that contains the authenticated user information.
    The teams prop is an array of Teams.

    The component returns an AuthenticatedLayout component that contains the authenticated user information and a header.
    The header is a heading that says "Teams".

    The component also returns a Head component that sets the title of the page to "Teams".

    The component returns a div element with the class "py-8" that contains a div element with the classes "max-w-7xl mx-auto sm:px-6 lg:px-8".
*/