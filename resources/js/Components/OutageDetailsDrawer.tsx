import React from 'react';
import {
    Drawer,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
} from "@/Components/ui/drawer";
import { Button } from '@/Components/ui/button';
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import {
    Form,
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/Components/ui/form";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover";
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from "@/Components/ui/command";
import { Check, ChevronsUpDown } from "lucide-react";
import { cn } from "@/lib/utils";

const FormSchema = z.object({
    team: z.number({
        required_error: "Please select a team.",
    }),
});

const OutageDetailsDrawer = ({ data, isOpen, onClose, onSave, isLoading }) => {
    const form = useForm<z.infer<typeof FormSchema>>({
        resolver: zodResolver(FormSchema),
        defaultValues: {
            team: 0,
        },
    });

    const handleSave = (formData) => {
        onSave(formData.team);
    };

    if (isLoading || !data || !data.outage) {
        return null; // Or a loading indicator, e.g. <div>Loading...</div>
    }

    console.log('data', data);

    const teams = data.teams || [];
    const outage = data.outage;
    const inactiveTeams = teams.filter(team => team.status !== 1);


    return (
        <Drawer open={isOpen} onClose={onClose}>
            <DrawerContent>
                <DrawerHeader>
                    <DrawerTitle className="text-white text-2xl font-semibold leading-none tracking-tight">Outage Details</DrawerTitle>
                    <DrawerDescription>
                        Detailed information about the outage.
                    </DrawerDescription>
                </DrawerHeader>
                <div className="p-4 grid grid-cols-2 gap-4">
                    <p className='text-white'><strong>Outage ID:</strong> {outage.outage_id}</p>
                    <p className='text-white'><strong>Outage Type:</strong> {outage.outage_type}</p>
                    {/* Resources Needed */}
                    <p className='text-white'><strong>Deployment Cost:</strong> {new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(outage.deployment_cost)}</p>
                    <p className='text-white'><strong>OLT:</strong> {outage.olt}</p>
                    <p className='text-white'><strong>Team:</strong> {outage.team}</p>
                    <p className='text-white'><strong>Team Type:</strong> {outage.team_type}</p>
                    <p className='text-white'><strong>Start Time:</strong> {new Date(outage.start_time).toLocaleString()}</p>
                    <p className='text-white'><strong>End Time:</strong> {new Date(outage.end_time).toLocaleString()}</p>
                    <p className='text-white'><strong>Duration:</strong> {Math.max(0, (outage.duration / 24)).toFixed(0)} days</p>
                    <p className='text-white'><strong>Status:</strong> {outage.status ? 'Active' : 'Resolved'}</p>
                    <p className='text-white'><strong>Refund Amount:</strong> {new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(outage.refund_amount)}</p>
                    {/* Total Cost */}
                    <p className='text-white'>
                        <strong>Total Cost:</strong> {new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
                            Number(outage.deployment_cost) + Number(outage.refund_amount)
                        )}
                    </p>

                </div>
                <DrawerFooter>
                    <Button onClick={onClose} className="mr-2">Close</Button>
                </DrawerFooter>
            </DrawerContent>
        </Drawer>
    );
};

export default OutageDetailsDrawer;
