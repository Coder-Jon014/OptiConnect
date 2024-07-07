import { ChevronUpIcon, ChevronDownIcon } from "@heroicons/react/16/solid"
export default function TableHeading({sort_field = null, sort_direction = null, name, sortable = true, sortChanged = () => {}, children}){
    return (
        <th
        onClick={() => sortChanged(name)}>
        <div className="px-3 py-3 flex items-center gap-2 cursor-pointer">
            {sortable && (
                <div>
                <ChevronUpIcon className={
                    "w-4 " + (sort_field === (name) && sort_direction === 'asc' ? 'text-white' : ' ')
                } />
                <ChevronDownIcon className={
                    "w-4 -mt-2 " + (sort_field === (name) && sort_direction === 'desc' ? 'text-white' : ' ')
                } />
            </div>
            ) }
            {children}
        </div>
    </th>
    )
}