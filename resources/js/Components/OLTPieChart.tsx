import React from 'react';
import { Label, Pie, PieChart, Cell, Tooltip, Sector } from 'recharts';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/Components/ui/card';
import { ChartConfig, ChartContainer, ChartTooltip, ChartTooltipContent } from '@/Components/ui/chart';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';

const COLORS = {
  'OLT Negril': '#0088FE',
  'OLT St. Anns Bay': '#0091C7',
  'OLT Mandeville': '#FFBB28',
  'OLT Old Harbor': '#FF8042',
  'OLT St. Jago': '#AF19FF',
  'OLT Bridgeport': '#FF4560',
  'OLT Dumfries': '#00E396',
  'OLT Barbican': '#56D0D0',
  'OLT Independence City': '#E0FF22',
  'Unknown': '#888888',
};

const chartConfig = {
  visitors: {
    label: 'Visitors',
  },
  chrome: {
    label: 'Chrome',
    color: 'hsl(var(--chart-1))',
  },
  safari: {
    label: 'Safari',
    color: 'hsl(var(--chart-2))',
  },
  firefox: {
    label: 'Firefox',
    color: 'hsl(var(--chart-3))',
  },
  edge: {
    label: 'Edge',
    color: 'hsl(var(--chart-4))',
  },
  other: {
    label: 'Other',
    color: 'hsl(var(--chart-5))',
  },
} satisfies ChartConfig;

type OLTPieChartProps = {
  oltData: {
    olt: string;
    customer_count: number;
    business_customer_count: number;
    residential_customer_count: number;
    olt_value: string;
  }[];
};

const OLTPieChart: React.FC<OLTPieChartProps> = ({ oltData }) => {
  const [activeOLT, setActiveOLT] = React.useState<string | null>('all');

  // Ensure oltData is always an array
  const data = oltData || [];

  const filteredData = activeOLT === 'all' ? data : data.filter(item => item.olt === activeOLT);
  
  // Ensure filteredData is always an array
  const totalCustomers = filteredData.reduce((acc, curr) => acc + (curr.customer_count || 0), 0);

  const olts = data.map(item => item.olt);
  return (
    <Card className="flex flex-col bg-[var(--foreground)] rounded-lg pb-8">
      <CardHeader className="flex-row items-start space-y-0 pb-2">
        <div className="grid gap-2">
          <CardTitle className="text-white">Customer OLT Breakdown</CardTitle>
          <CardDescription className="text-[var(--table-headings)]">Total number of customers: {totalCustomers}</CardDescription>
        </div>
        <Select value={activeOLT || ''} onValueChange={(value) => setActiveOLT(value === 'all' ? 'all' : value)}>
          <SelectTrigger
            className="ml-auto h-7 w-[130px] rounded-lg pl-2.5 mb-4 mt-1 bg-transparent text-sm font-medium text-white border-4"
            aria-label="Select OLT"
          >
            <SelectValue placeholder="Select OLT" />
          </SelectTrigger>
          <SelectContent align="end" className="rounded-xl bg-white p-0 border-4">
            <SelectItem key="all" value="all" className="rounded-lg [&_span]:flex">
              <div className="flex items-center gap-2 text-xs">
                <span className="flex h-3 w-3 shrink-0 rounded-sm" />
                All OLTs
              </div>
            </SelectItem>
            {olts.map((key, index) => (
              <SelectItem key={key} value={key} className="rounded-lg [&_span]:flex">
                <div className="flex items-center gap-2 text-xs">
                  <span className="flex h-3 w-3 shrink-0 rounded-sm" />
                  {key}
                </div>
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
      </CardHeader>
      <CardContent className="flex-1 pb-0">
        <ChartContainer config={chartConfig} className="mx-auto">
          <PieChart>
            <ChartTooltip cursor={false} content={<ChartTooltipContent hideLabel />} />
            <Pie data={filteredData} dataKey="customer_count" nameKey="olt" innerRadius={80} stroke="none">
              <Label
                content={({ viewBox }) => {
                  if (viewBox && 'cx' in viewBox && 'cy' in viewBox) {
                    return (
                      <text x={viewBox.cx} y={viewBox.cy} textAnchor="middle" dominantBaseline="middle">
                        <tspan x={viewBox.cx} y={viewBox.cy} className="text-3xl font-bold" fill="var(--primary)">
                          {totalCustomers.toLocaleString()}
                        </tspan>
                        <tspan x={viewBox.cx} y={(viewBox.cy || 0) + 24} fill="var(--muted-foreground)">
                          Customers
                        </tspan>
                      </text>
                    );
                  }
                }}
              />
              {filteredData.map((entry, index) => (
                <Cell key={`cell-${index}`} fill={COLORS[entry.olt]} />
              ))}
            </Pie>
          </PieChart>
        </ChartContainer>
      </CardContent>
      <CardFooter className="flex-col gap-2 text-sm pt-10">
        <div className="flex items-center gap-2 font-medium leading-none text-white">
          Distribution of customers across OLTs
        </div>
      </CardFooter>
    </Card>
  );
};

export default OLTPieChart;
