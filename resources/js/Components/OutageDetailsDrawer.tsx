import React from 'react';
import {
  Drawer,
  DrawerClose,
  DrawerContent,
  DrawerDescription,
  DrawerFooter,
  DrawerHeader,
  DrawerTitle,
} from "@/Components/ui/drawer";
import {Button} from '@/Components/ui/button';

const OutageDetailsDrawer = ({ outage, isOpen, onClose }) => (
  <Drawer open={isOpen} onClose={onClose}>
    <DrawerContent>
      <DrawerHeader>
        <DrawerTitle>Outage Details</DrawerTitle>
        <DrawerDescription>
          Detailed information about the outage.
        </DrawerDescription>
      </DrawerHeader>
      <div className="p-4">
        <p><strong>Outage ID:</strong> {outage.outage_id}</p>
        <p><strong>OLT:</strong> {outage.olt}</p>
        <p><strong>Team:</strong> {outage.team}</p>
        <p><strong>Team Type:</strong> {outage.team_type}</p>
        <p><strong>Start Time:</strong> {outage.start_time}</p>
        <p><strong>End Time:</strong> {outage.end_time}</p>
        <p><strong>Duration:</strong> {Math.max(0, (outage.duration / 24)).toFixed(0)} days</p>
        <p><strong>Status:</strong> {outage.status ? 'Active' : 'Resolved'}</p>
        <p><strong>Refund Amount:</strong> {new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(outage.refund_amount)}</p>
      </div>
      <DrawerFooter>
        <Button onClick={onClose} className="mr-2">Close</Button>
      </DrawerFooter>
    </DrawerContent>
  </Drawer>
);

export default OutageDetailsDrawer;
