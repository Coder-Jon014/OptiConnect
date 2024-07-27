import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router } from "@inertiajs/react";
import TableHeading from "@/Components/TableHeading";
import { useCallback, useMemo } from "react";

export default function Index({ auth, customers, queryParams = null }) {
    queryParams = queryParams || {};

    const searchFieldChanged = useCallback((name, value) => {
        if (value) {
            queryParams[name] = value;
        } else {
            delete queryParams[name];
        }
        router.get(route('customer.index'), queryParams);
    }, [queryParams]);

    const sortChanged = useCallback((name) => {
        if (name === queryParams.sort_field) {
            queryParams.sort_direction = queryParams.sort_direction === 'asc' ? 'desc' : 'asc';
        } else {
            queryParams.sort_field = name;
            queryParams.sort_direction = 'asc';
        }
        router.get(route('customer.index'), queryParams);
    }, [queryParams]);

    const onKeyPress = useCallback((name, e) => {
        if (e.key !== 'Enter') return;
        searchFieldChanged(name, e.target.value);
    }, [searchFieldChanged]);

    const handleExport = useCallback(() => {
        window.location.href = route('customers.export');
    }, []);

    const customerList = useMemo(() => customers.data || [], [customers.data]);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-white leading-tight">Customers</h2>}
            subheader={<p className="font-regular text-md text-[var(--subheader)] leading-tight">List of customers in the system</p>}
        >
            <Head title="Customers" />
            <div className="py-8">
                <div className="m-10 rounded-xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <button
                                onClick={handleExport}
                                className="bg-green-700 hover:bg-green-900 text-white font-bold py-2 px-4 rounded mb-2"
                            >
                                Export Customers
                            </button>
                            <div className="overflow-auto rounded bg-[var(--foreground)] border-2 border-[var(--border)] p-4">
                                <table className="w-full text-sm text-left rtl:text-right text-white">
                                    <thead className="text-xs text-[var(--table-headings)] uppercase rounded-t-lg border-b border-[var(--border)]">
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
                                            <TableHeading
                                                sort_field={queryParams.sort_field}
                                                sort_direction={queryParams.sort_direction}
                                                name="phone"
                                                sortChanged={sortChanged}
                                            >
                                                Phone
                                            </TableHeading>
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
                                    <thead className="text-xs text-gray-700 uppercase">
                                    </thead>
                                    <tbody>
                                        {customerList.map((customer, index) => (
                                            <tr key={customer.customer_id} className={`hover:bg-[var(--table-hover)] border-b border-[var(--border)] rounded-full text-white ${index === 0 ? 'bg-[var(--even-odd)]' : ''}`}>
                                                <td className="py-2 px-4 rounded-l-lg ">{customer.customer_id}</td>
                                                <td className="py-2 px-4 ">{customer.customer_name}</td>
                                                <td className="py-2 px-4 ">{customer.telephone}</td>
                                                <td className="py-2 px-4 ">{customer.town.town_name}</td>
                                                <td className="py-2 px-4 rounded-r-lg">{customer.customerType.customer_type_name}</td>
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
