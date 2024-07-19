"use client"
import * as React from "react";
import { useState } from "react";
import { TrendingUp } from "lucide-react";
import { Bar, BarChart, LabelList, XAxis, YAxis } from "recharts";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import Tooltip from "./Tooltip"; // Adjust the import path as necessary

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

export function CustomerBreakdownChart({ oltData }) {
    const [tooltip, setTooltip] = useState({
        visible: false,
        x: 0,
        y: 0,
        content: null,
    });

    const handleMouseEnter = (data, index, e) => {
        const { clientX, clientY } = e;
        setTooltip({
            visible: true,
            x: clientX,
            y: clientY,
            content: (
                <div className="flex items-center">
                    <span className="block w-2 h-2 mr-2" style={{ backgroundColor: COLORS[data.olt] || COLORS['Unknown'] }}></span>
                    <div>
                        <p>{data.olt}</p>
                        <p>Customer Count: {data.customer_count}</p>
                    </div>
                </div>
            ),
        });
    };

    const handleMouseLeave = () => {
        setTooltip({ visible: false, x: 0, y: 0, content: null });
    };

    const handleMouseMove = (e) => {
        const { clientX, clientY } = e;
        setTooltip((prev) => ({ ...prev, x: clientX, y: clientY }));
    };

    return (
        <Card className="bg-[var(--foreground)]">
            <CardHeader>
                <CardTitle className="text-white">Bar Chart - OLT Customer Count</CardTitle>
                <CardDescription className="text-gray-400">OLT Customer Breakdown</CardDescription>
            </CardHeader>
            <CardContent>
                <BarChart
                    width={500}
                    height={300}
                    data={oltData}
                    layout="vertical"
                    margin={{
                        top: 5,
                        right: 30,
                        left: 20,
                        bottom: 5,
                    }}
                >
                    <XAxis type="number" hide={true} />
                    <YAxis dataKey="olt" type="category" hide={true} />
                    <Bar
                        dataKey="customer_count"
                        fill="#8884d8"
                        radius={[0, 4, 4, 0]}
                        onMouseEnter={handleMouseEnter}
                        onMouseLeave={handleMouseLeave}
                        onMouseMove={handleMouseMove}
                    >
                        <LabelList dataKey="olt" position="insideLeft" offset={8} className="fill-background" fontSize={12} />
                        <LabelList dataKey="customer_count" position="right" offset={10} className="text-white" fontSize={12} />
                        {oltData.map((entry, index) => (
                            <Bar key={`bar-${index}`} dataKey="customer_count" fill={COLORS[entry.olt] || COLORS['Unknown']} />
                        ))}
                    </Bar>
                </BarChart>
                <Tooltip x={tooltip.x} y={tooltip.y} visible={tooltip.visible}>
                    {tooltip.content}
                </Tooltip>
            </CardContent>
            <CardFooter className="flex flex-col items-end gap-2 text-sm">
                <div className="flex gap-2 font-medium leading-none text-white">
                    Trending up by 5.2% this month <TrendingUp className="h-4 w-4" />
                </div>
                <div className="leading-none text-gray-400">
                    Showing total customers per OLT
                </div>
            </CardFooter>
        </Card>
    );
}

export default CustomerBreakdownChart;