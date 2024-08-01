import { AlertCircle } from "lucide-react"
import * as React from "react";

import {
  Alert,
  AlertDescription,
  AlertTitle,
} from "@/Components/ui/alert"

export function AlertDestructive({ header, message }) {
    return (
      <Alert variant="destructive" className="mb-4 bg-[var(--destructive-foreground)] text-red-500">
        <AlertCircle className="h-4 w-4" />
        <AlertTitle>{header}</AlertTitle>
        <AlertDescription>{message}</AlertDescription>
      </Alert>
    );
  }

