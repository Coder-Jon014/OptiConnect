import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function Index({ auth, customers }) {
  // Ensure customers is an array
  const customerList = customers.data || [];

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Customers</h2>}
    >
      <Head title="Customers" />
      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="mt-4">
            <table className="min-w-full bg-white dark:bg-gray-800">
              <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                <tr>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Customer ID</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Name</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Phone</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Town</th>
                  <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Customer Type</th>
                </tr>
              </thead>
              <tbody>
                {customerList.map((customer) => (
                  <tr key={customer.customer_id} className="text-customBlue">
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{customer.customer_id}</td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{customer.customer_name}</td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{customer.telephone}</td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{customer.town.town_name}</td>
                    <td className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{customer.customerType.customer_type_name}</td>
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
