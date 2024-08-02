import React from "react";
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/Components/ui/card";

const NumbersCard = ({ title, value, description, other }) => {
  return (
    <Card className="max-w-xs bg-[var(--foreground)]">
      <CardHeader>
        <CardTitle className="text-white">{title}</CardTitle>
      </CardHeader>
      <CardContent>
        <div className="flex items-baseline gap-1 text-4xl text-white font-bold tabular-nums leading-none">
          {value}
          <span className="text-sm font-normal text-muted-foreground"> {other}</span>
        </div>
        <CardDescription>
          {description}
        </CardDescription>
      </CardContent>
    </Card>
  );
};

export default NumbersCard;
