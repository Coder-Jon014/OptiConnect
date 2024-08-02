import React from "react";
import { TrendingUp } from "lucide-react";
import { Bar, BarChart, CartesianGrid, LabelList, XAxis, YAxis, Cell } from "recharts";

import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/Components/ui/card";
import {
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
} from "@/Components/ui/chart";

const teamNames = {
  1: "Team Alpha External",
  2: "Team Alpha Internal",
  3: "Team Bravo External",
  4: "Team Bravo Internal",
  5: "Team Charlie External",
  6: "Team Charlie Internal",
  7: "Team Delta External",
  8: "Team Delta Internal",
  9: "Team Echo External",
  10: "Team Echo Internal",
};

const COLORS = {
  'Team Alpha External': '#0088FE',
  'Team Alpha Internal': '#0091C7',
  'Team Bravo External': '#FFBB28',
  'Team Bravo Internal': '#FF8042',
  'Team Charlie External': '#AF19FF',
  'Team Charlie Internal': '#FF4560',
  'Team Delta External': '#00E396',
  'Team Delta Internal': '#56D0D0',
  'Team Echo External': '#E0FF22',
  'Team Echo Internal': '#888888',
  'Unknown': '#888888',
};

const chartConfig = {
  timesdeployed: {
    label: "Times Deployed",
    color: "hsl(var(--chart-1))",
  },
  label: {
    color: "hsl(var(--background))",
  },
};

const NumberOfTimesTeamDeployedChart = ({ data }) => {
  const mappedData = data.map(item => ({
    team: teamNames[item.team_id] || "Unknown Team",
    timesdeployed: item.timesdeployed,
  }));

  return (
    <Card className="bg-[var(--foreground)] w-full">
      <CardHeader>
        <CardTitle className="text-white">Number of Times Teams Deployed</CardTitle>
        <CardDescription>Showing team deployment frequency</CardDescription>
      </CardHeader>
      <CardContent>
        <ChartContainer config={chartConfig}>
          <BarChart
            accessibilityLayer
            data={mappedData}
            layout="vertical"
            margin={{
              right: 16,
            }}
          >
            
            <YAxis
              dataKey="team"
              type="category"
              tickLine={false}
              tickMargin={10}
              axisLine={false}
              hide={true}
            />
            <XAxis dataKey="timesdeployed" type="number" hide />
            <ChartTooltip
              cursor={false}
              content={<ChartTooltipContent indicator="line" />}
            />
            <Bar
              dataKey="timesdeployed"
              layout="vertical"
              fill="var(--color-timesdeployed)"
              radius={4}
            >
              <LabelList
                dataKey="team"
                position="insideLeft"
                offset={8}
                className="fill-[--color-label]"
                fontSize={12}
              />
              <LabelList
                dataKey="timesdeployed"
                position="right"
                offset={8}
                className="fill-white"
                fontSize={12}
              />
              {mappedData.map((entry, index) => (
                <Cell key={`cell-${index}`} fill={COLORS[entry.team] || COLORS['Unknown']} />
              ))}
            </Bar>
          </BarChart>
        </ChartContainer>
      </CardContent>
      <CardFooter className="flex-col items-start gap-2 text-sm">
        <div className="flex gap-2 font-medium leading-none text-white">
          Showing total team deployments <TrendingUp className="h-4 w-4" />
        </div>
        <div className="leading-none text-muted-foreground">
          Data for all teams
        </div>
      </CardFooter>
    </Card>
  );
};

export default NumberOfTimesTeamDeployedChart;
