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
import { TEAM_STATUS_CLASS_MAP } from "@/constants"

export function TeamsDeployed({ teams }) {
  // Pick out the active teams only 
  const activeTeams = teams.filter((team) => team.status)
  return (
    <Card className="bg-[var(--foreground)]">
      <CardHeader className="px-7">
        <CardTitle className="text-white">Teams Deployed</CardTitle>
        <CardDescription>List of deployed teams and their status.</CardDescription>
      </CardHeader>
      <CardContent>
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Name</TableHead>
              <TableHead className="text-right">Status</TableHead>
            </TableRow>
          </TableHeader>  
          <TableBody>
            {activeTeams.map((team, index) => (
              <TableRow key={index} className="bg-[var(--foreground)]">
                <TableCell>
                  <div className="font-medium text-white">{team.team_name} {team.team_type}</div>
                </TableCell>
                <TableCell className="text-right">
                  <Badge className="text-xs text-white outline" variant={team.status ? "secondary" : "outline"}>
                    {team.status ? "Active" : "Inactive"}
                  </Badge>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </CardContent>
    </Card>
  )
}

export default TeamsDeployed;
