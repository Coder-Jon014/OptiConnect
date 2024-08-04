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
                    <p className='text-white'><strong>OLT:</strong> {outage.olt.olt_name}</p>
                    <p className='text-white'><strong>Team:</strong> {outage.team.team_name}</p>
                    <p className='text-white'><strong>Team Type:</strong> {outage.team.team_type}</p>
                    <p className='text-white'><strong>Start Time:</strong> {outage.start_time}</p>
                    <p className='text-white'><strong>End Time:</strong> {outage.end_time}</p>
                    <p className='text-white'><strong>Duration:</strong> {Math.max(0, (outage.duration / 24)).toFixed(0)} days</p>
                    <p className='text-white'><strong>Status:</strong> {outage.status ? 'Active' : 'Resolved'}</p>
                    <p className='text-white'><strong>Refund Amount:</strong> {outage.sla.refund_amount ? new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(outage.sla.refund_amount) : 'N/A'}</p>
                </div>
                {outage.status === 1 && (
                <Form {...form}>
                    <form onSubmit={form.handleSubmit(handleSave)} className="space-y-6 p-4">
                        <FormField
                            control={form.control}
                            name="team"
                            render={({ field }) => (
                                <FormItem className="flex flex-col">
                                    <FormLabel className="text-white">Reassign Team</FormLabel>
                                    <Popover>
                                        <PopoverTrigger asChild>
                                            <FormControl>
                                                <Button
                                                    variant="outline"
                                                    role="combobox"
                                                    className={cn(
                                                        "w-full justify-between",
                                                        !field.value ? "text-muted-foreground" : "text-white" // Apply text-white class if field.value is present
                                                    )}
                                                    style={{ border: '1px solid var(--foreground)' }}
                                                >
                                                    {field.value
                                                        ? inactiveTeams.find(
                                                            (team) => team.team_id === field.value
                                                        )?.team_name
                                                        : "Select team"}
                                                    <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50 text-white" />
                                                </Button>

                                            </FormControl>
                                        </PopoverTrigger>
                                        <PopoverContent className="w-full p-0 bg-[var(--foreground)]">
                                            <Command>
                                                <CommandInput placeholder="Search team..." />
                                                <CommandList>
                                                    <CommandEmpty>No team found.</CommandEmpty>
                                                    <CommandGroup>
                                                        {inactiveTeams.map((team) => (
                                                            <CommandItem
                                                                value={team.team_name}
                                                                key={team.team_id}
                                                                onSelect={() => {
                                                                    form.setValue("team", team.team_id);
                                                                }}
                                                                className='text-white'
                                                            >
                                                                <Check
                                                                    className={cn(
                                                                        "mr-2 h-4 w-4",
                                                                        team.team_id === field.value
                                                                            ? "opacity-100"
                                                                            : "opacity-0"
                                                                    )}
                                                                />
                                                                {team.team_name}
                                                            </CommandItem>
                                                        ))}
                                                    </CommandGroup>
                                                </CommandList>
                                            </Command>
                                        </PopoverContent>
                                    </Popover>
                                    <FormDescription>
                                        Select a team to reassign to this outage.
                                    </FormDescription>
                                    <FormMessage />
                                </FormItem>
                            )}
                        />
                        <Button type="submit">Save</Button>
                    </form>
                </Form>
                )}
                <DrawerFooter>
                    <Button onClick={onClose} className="mr-2">Close</Button>
                </DrawerFooter>
            </DrawerContent>
        </Drawer>
    );
};

export default OutageDetailsDrawer;
