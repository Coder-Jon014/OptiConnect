import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router } from "@inertiajs/react";
import TextInput from "@/Components/TextInput";
import SelectInput from "@/Components/SelectInput";
import { ChevronUpIcon, ChevronDownIcon } from "@heroicons/react/16/solid"
import TableHeading from "@/Components/TableHeading";
import { Tab } from "@headlessui/react";


export default function Index({ auth, customers, queryParams = null }) {
    queryParams = queryParams || {};

    const searchFieldChanged = (name, value) => {
        if (value) {
            queryParams[name] = value;
        } else {
            delete queryParams[name];
        }
        router.get(route('customer.index'), queryParams);
    };

    const sortChanged = (name) => {
        if (name === queryParams.sort_field) {
            queryParams.sort_direction = queryParams.sort_direction === 'asc' ? 'desc' : 'asc';
        } else {
            queryParams.sort_field = name;
            queryParams.sort_direction = 'asc';
        }
        router.get(route('customer.index'), queryParams);
    }

    const onKeyPress = (name, e) => {
        if (e.key !== 'Enter') return;
        searchFieldChanged(name, e.target.value);
    };

    // Ensure customers is an array
    const customerList = customers.data || [];

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Customers</h2>}
        >
            <Head title="Customers" />
            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="overflow-auto">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <TableHeading
                                                sort_field={queryParams.sort_field}
                                                sort_direction={queryParams.sort_direction}
                                                name="customer_id"
                                                sortChanged={sortChanged}
                                            >
                                                Customer ID
                                            </TableHeading>
                                            <TableHeading
                                                sort_field={queryParams.sort_field}
                                                sort_direction={queryParams.sort_direction}
                                                name="customer_name"
                                                sortChanged={sortChanged}
                                            >
                                                Customer Name
                                            </TableHeading>
                                            <th>
                                                <div className="px-3 py-3 flex items-center gap-2">
                                                    Phone
                                                </div>
                                            </th>
                                            <TableHeading
                                                sort_field={queryParams.sort_field}
                                                sort_direction={queryParams.sort_direction}
                                                name="town"
                                                sortChanged={sortChanged}
                                            >
                                                Town
                                            </TableHeading>
                                            <TableHeading
                                                sort_field={queryParams.sort_field}
                                                sort_direction={queryParams.sort_direction}
                                                name="customer_type"
                                                sortChanged={sortChanged}
                                            >
                                                Customer Type
                                            </TableHeading>
                                        </tr>
                                    </thead>
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr>
                                            <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700"></th>
                                            <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                                <TextInput
                                                    className="w-full"
                                                    defaultValue={queryParams.name}
                                                    placeholder="Customer Name"
                                                    onBlur={e => searchFieldChanged('name', e.target.value)}
                                                    onKeyPress={e => onKeyPress('name', e)} />
                                            </th>
                                            <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700"></th>
                                            <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                                <SelectInput
                                                    className="w-full"
                                                    defaultValue={queryParams.town}
                                                    onChange={e => searchFieldChanged('town', e.target.value)} >
                                                    <option value="">Select Town</option>
                                                    <option value="Negril">Negril</option>
                                                    <option value="St. Anns Bay">St. Anns Bay</option>
                                                    <option value="Mandeville">Mandeville</option>
                                                    <option value="Old Harbor">Old Harbor</option>
                                                    <option value="St. Jago">St. Jago</option>
                                                    <option value="Bridgeport">Bridgeport</option>
                                                    <option value="Dumfries">Dumfries</option>
                                                    <option value="Barbican">Barbican</option>
                                                    <option value="Independence City">Independence City</option>

                                                </SelectInput>
                                            </th>
                                            <th className="py-2 px-4 border-b border-gray-200 dark:border-gray-700"></th>
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
                            <Pagination links={customers.meta.links} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
