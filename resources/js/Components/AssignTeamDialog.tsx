import React, { useState } from "react";
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from "@/Components/ui/dialog";
import { Button } from "@/Components/ui/button";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from "@/Components/ui/select";

interface AssignTeamDialogProps {
  isOpen: boolean;
  onClose: () => void;
  data: any; // Consider creating a proper type for this
  onSave: (teamId: number | null) => void; // Add this line
}

export default function AssignTeamDialog({ isOpen, onClose, data, onSave }: AssignTeamDialogProps) {
  const [selectedTeam, setSelectedTeam] = useState(data.outage.team_id || null);
  console.log('data', data);

  const handleSave = () => {
    // Convert the selectedTeam string to a integer
    const teamId = parseInt(selectedTeam);
    console.log('Selected Team ID:', teamId);
    onSave(teamId);
    onClose();
  };

  const handleTeamChange = (value: string) => {
    setSelectedTeam(value);
  };

  return (
    <Dialog open={isOpen} onOpenChange={onClose}>
      <DialogContent className="sm:max-w-[600px]">
        <DialogHeader>
          <DialogTitle>Team Assignment</DialogTitle>
          <DialogDescription>
            {`Assign a team to ${data.outage.olt}`}
          </DialogDescription>
        </DialogHeader>
        <div className="mt-2 mb-2">
          <p className="text-md text-white">Resources needed:</p>
          <ul className="list-disc pl-5 mt-1 text-sm text-white">
            <li>{data.olt.resource_name}</li>
            <li>{data.outageType.resource_name}</li>
          </ul>
        </div>
        <div className="space-y-6">
          <Select value={selectedTeam} onValueChange={handleTeamChange}>
            <SelectTrigger className="w-full">
              <SelectValue placeholder="Select a team" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectLabel>Teams Available</SelectLabel>
                {data.teams.map((team) => (
                  <SelectItem key={team.team_id} value={team.team_id.toString()}>
                    {team.team_name} - {team.team_type} (${team.deployment_cost}USD)
                    <br />
                    <small>{team.resource_name.join(", ")}</small>
                  </SelectItem>
                ))}
              </SelectGroup>
            </SelectContent>
          </Select>
        </div>
        {selectedTeam && data.teams.some(team => team.team_id.toString() === selectedTeam) && (
          <p className="mt-4 text-sm text-green-500">
            {data.teams.find(team => team.team_id.toString() === selectedTeam)?.team_name} has been selected and will be assigned to this outage.
          </p>
        )}
        <DialogFooter>
          <Button onClick={handleSave}>Save changes</Button>
          <Button variant="ghost" onClick={onClose}>
            Cancel
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  );
}