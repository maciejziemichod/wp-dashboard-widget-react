import {
	CartesianGrid,
	Line,
	LineChart,
	ResponsiveContainer,
	Tooltip,
	XAxis,
	YAxis,
} from "recharts";
import { DataItem } from "../types.ts";
import styles from "./Chart.module.css";

type ChartProps = {
	data: DataItem[];
};

function formatTick(value: number): string {
	return new Date(value).toLocaleDateString();
}

export function Chart({ data }: ChartProps) {
	return (
		<div className={styles.container}>
			<ResponsiveContainer>
				<LineChart
					width={500}
					height={300}
					data={data}
					margin={{
						top: 5,
						right: 30,
						left: 20,
						bottom: 5,
					}}
				>
					<CartesianGrid strokeDasharray="3 3" />
					<XAxis dataKey="timestamp" tickFormatter={formatTick} />
					<YAxis />
					<Tooltip />
					<Line type="monotone" dataKey="value" stroke="#0e7490" />
				</LineChart>
			</ResponsiveContainer>
		</div>
	);
}
