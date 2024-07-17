import * as React from "react";
import { PieChart, Pie, Label, Tooltip, ResponsiveContainer } from "recharts";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";

const OLTBreakdownChart = ({ data }) => {
  const totalCustomers = data.reduce((acc, curr) => acc + curr.customerCount, 0);

  return (
    <Card className="flex flex-col">
      <CardHeader className="items-center pb-0">
        <CardTitle>OLT Breakdown</CardTitle>
      </CardHeader>
      <CardContent className="flex-1 pb-0">
        <ResponsiveContainer width="100%" height={250}>
          <PieChart>
            <Tooltip />
            <Pie
              data={data}
              dataKey="customerCount"
              nameKey="oltName"
              innerRadius={60}
              outerRadius={80}
              fill="#82ca9d"
            >
              <Label
                value={`${totalCustomers} Customers`}
                position="center"
                className="fill-foreground text-3xl font-bold"
              />
            </Pie>
          </PieChart>
        </ResponsiveContainer>
      </CardContent>
    </Card>
  );
};

export default OLTBreakdownChart;
