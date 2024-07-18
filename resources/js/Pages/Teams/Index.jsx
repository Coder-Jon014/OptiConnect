import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { TEAM_STATUS_CLASS_MAP } from "@/constants";

export default function Index({ auth, teams }) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-white leading-tight">Teams</h2>}
      subheader={<p className="font-regular text-md text-[var(--subheader)] leading-tight">List of teams in the system</p>}
    >
      <Head title="Teams" />

      <div className="py-8">
        <div className="w-full mx-auto sm:px-6 lg:px-8">
          <div className="mt-4">
            <div className="overflow-hidden shadow-sm sm:rounded-lg">
              <div className="p-2 text-gray-900 dark:text-gray-100">
                <div className="overflow-auto rounded bg-[var(--foreground)] border-2 border-[var(--border)] p-4">
                  <table className="min-w-full rounded-lg">
                    <thead className="text-xs text-left text-[var(--table-headings)] uppercase rounded-t-lg border-b border-[var(--border)]">
                      <tr>
                        <th className="py-2 px-4 ">Team Name</th>
                        <th className="py-2 px-4 ">Resources</th>
                        <th className="py-2 px-4 ">Team Type</th>
                        <th className="py-2 px-4 ">Team Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      {teams.data.map((team, index) => (
                        <tr key={team.team_id} className={`hover:bg-[var(--table-hover)] border-b border-[var(--border)] rounded-full text-white text-nowrap ${index === 0 ? 'bg-[var(--even-odd)]' : ''}`}>
                          <td className="py-2 px-4 rounded-l-lg ">{team.team_name}</td>
                          <td className="py-2 px-4 ">{team.resource_name.join(', ')}</td>
                          <td className="py-2 px-4 ">{team.team_type}</td>
                          <td className={`py-2 px-4 rounded-r-lg ${TEAM_STATUS_CLASS_MAP[team.status ? 'Active' : 'Inactive']}`}>{team.status ? 'Active' : 'Inactive'}</td>
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