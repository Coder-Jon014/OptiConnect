"use client"
import * as React from "react";
import { TrendingUp } from "lucide-react";
import { Bar, BarChart, LabelList, XAxis, YAxis, Cell, CartesianGrid } from "recharts";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/Components/ui/card";
import { ChartContainer, ChartTooltip, ChartTooltipContent, ChartConfig } from "@/Components/ui/chart"; // Adjust the import path as necessary

const COLORS = {
  'OLT Negril': '#0088FE',
  'OLT St. Anns Bay': '#00C49F',
  'OLT Mandeville': '#FFBB28',
  'OLT Old Harbor': '#FF8042',
  'OLT St. Jago': '#AF19FF',
  'OLT Bridgeport': '#FF4560',
  'OLT Dumfries': '#00E396',
  'OLT Barbican': '#775DD0',
  'OLT Independence City': '#FEB019',
  'Unknown': '#888888',
};

const chartConfig = {
  olt: {
    label: "OLT",
    color: "var(--foreground)",
  },
  olt_value: {
    label: "OLT Value",
    color: "var(--primary)",
  },
} satisfies ChartConfig

export function OLTValueBarChart({ oltData }) {
  return (
    <Card className="bg-[var(--foreground)] pb-8">
      <CardHeader>
        <CardTitle className="text-white">OLT Value Breakdown</CardTitle>
        <CardDescription className="text-[var(--table-headings)]">Showing total OLT value</CardDescription>
      </CardHeader>
      <CardContent>
        <ChartContainer config={chartConfig}>
          <BarChart
            width={500}
            height={300}
            data={oltData}
            margin={{
              top: 20,
              right: 30,
              left: 20,
              bottom: 80,
            }}
          >
            <XAxis 
              dataKey="olt" 
              tickLine={true} 
              tickMargin={5} 
              axisLine={true} 
              stroke="#18181b" 
              interval={0} 
              angle={-45} 
              textAnchor="end" 
            />
            <YAxis type="number" tickLine={true} axisLine={true} stroke="#18181b" />
            <ChartTooltip
              cursor={false}
              content={
                <ChartTooltipContent
                  hideLabel
                  hideIndicator
                  formatter={(value, name, props) => (
                    <div style={{ color: 'white' }}>
                      <span
                        style={{
                          backgroundColor: props.color,
                          width: '10px',
                          height: '10px',
                          display: 'inline-block',
                          // marginRight: '0px',
                        }}
                      ></span>
                      {props.payload.olt}: ${value.toLocaleString()}
                    </div>
                  )}
                />
              }
            />
            <Bar dataKey="olt_value" radius={[4, 4, 4, 4]}>
              <LabelList dataKey="olt_value" position="top" offset={10} className="text-white" fontSize={12} formatter={(value) => `$${value.toLocaleString()}`} />
              {oltData.map((entry, index) => (
                <Cell key={`cell-${index}`} fill={COLORS[entry.olt] || COLORS['Unknown']} />
              ))}
            </Bar>
          </BarChart>
        </ChartContainer>
      </CardContent>
      <CardFooter className="flex flex-col items-center text-sm">
        <div className="flex gap-2 font-medium leading-none text-white">
          Trending up by 5.2% this month <TrendingUp className="h-4 w-4" />
        </div>
      </CardFooter>
    </Card>
  );
}

export default OLTValueBarChart;
