import React from "react";
import { Button } from "@/Components/ui/button";

interface AssignTeamButtonProps {
  onClick: () => void;
  description: string;
}

export default function AssignTeamButton({ onClick, description }: AssignTeamButtonProps) {
  return (
    <Button variant="ghost" onClick={onClick}>
      {description}
    </Button>
  );
}