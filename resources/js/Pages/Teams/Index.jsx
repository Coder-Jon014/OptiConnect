import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { TEAM_STATUS_CLASS_MAP } from "@/constants";

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
                        <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Team Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      {teams.data.map((team) => (
                        <tr key={team.team_id} className="text-customBlue text-center">
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{team.team_name}</td>
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{team.team_type}</td>
                          <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                            {team.resource_name.join(', ')}
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
        </div>
      </div>
    </AuthenticatedLayout>
  );
}


/*
    This is the Teams Index page. 
    It displays a list of teams and their details in a table format.
    The table displays the following columns:
    - Team Name
    - Team Type
    - Resources
    - Team Status
    Each row in the table represents a team and its details.
    The table is paginated to display a limited number of teams per page.
*/