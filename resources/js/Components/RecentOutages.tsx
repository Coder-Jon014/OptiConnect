import * as React from "react"
import { Badge } from "@/Components/ui/badge"
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
  CardDescription,
} from "@/Components/ui/card"
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/Components/ui/table"

export function RecentOutages({ outages }) {
  return (
    <Card className=" bg-[var(--foreground)] w-full">
      <CardHeader className="px-7">
        <CardTitle className="text-white">Recent Outages</CardTitle>
        <CardDescription>Recent outages affecting the system.</CardDescription>
      </CardHeader>
      <CardContent>
        <Table className="w-full">
          <TableHeader>
            <TableRow>
              <TableHead>OLT Name</TableHead>
              <TableHead className="hidden sm:table-cell">Team</TableHead>
              <TableHead className="hidden sm:table-cell">Status</TableHead>
              <TableHead className="hidden md:table-cell">Start Time</TableHead>
              <TableHead className="text-right">Duration (days)</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {outages.map((outage, index) => (
              <TableRow key={index} className="bg-[var(--foreground)]">
                <TableCell>
                  <div className="font-medium text-white">{outage.olt.olt_name}</div>
                </TableCell>
                <TableCell className="hidden sm:table-cell text-white">
                  {outage.team ? `${outage.team.team_name} ${outage.team.team_type}` : 'No team assigned'}
                </TableCell>
                <TableCell className="hidden sm:table-cell">
                  <Badge className="text-xs text-white outline" variant={outage.status ? "secondary" : "outline"}>
                    {outage.status ? "Active" : "Resolved"}
                  </Badge>
                </TableCell>
                <TableCell className="hidden md:table-cell text-white">{new Date(outage.start_time).toLocaleString()}</TableCell>
                <TableCell className="text-right text-white">{(outage.duration / 86400).toFixed(0)}</TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </CardContent>
    </Card>
  )
}

export default RecentOutages;