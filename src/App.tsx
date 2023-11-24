import { useEffect, useState } from "react";
import { ErrorMessage } from "./components/ErrorMessage";
import { LoadingSpinner } from "./components/LoadingSpinner";
import { isDataValid } from "./utils/validation";
import { DataItem, TimeSelectOptionKey, TimeSelectOptions } from "./types";
import { Select } from "./components/Select.tsx";
import { Chart } from "./components/Chart.tsx";
import styles from "./App.module.css";

declare const wpApiSettings: { root: string } | undefined;

const timeSelectOptions: TimeSelectOptions = {
	seven: {
		value: 7,
		label: "Last 7 days",
	},
	fifteen: {
		value: 15,
		label: "Last 15 days",
	},
	thirty: {
		value: 30,
		label: "Last month",
	},
} as const;

function App() {
	const restUrl = wpApiSettings?.root;

	const [error, setError] = useState(restUrl ? null : "No REST URL found.");
	const [data, setData] = useState<DataItem[]>([]);
	const [isLoading, setIsLoading] = useState(true);
	const [selectedOption, setSelectedOption] =
		useState<TimeSelectOptionKey>("seven");

	useEffect(() => {
		let ignore = false;

		fetch(
			`${restUrl}myplugin/v1/data?count=${timeSelectOptions[selectedOption].value}`,
		)
			.then((res) => {
				if (!res.ok) {
					throw new Error(
						`Error response from the API. Status code: ${res.status}`,
					);
				}

				return res.json();
			})
			.then((data: unknown) => {
				if (ignore) {
					return;
				}

				if (!isDataValid(data)) {
					setError("Incorrect format of data received from API");
					return;
				}

				setData(data);
			})
			.catch((error) => {
				setError(error.message);
			})
			.finally(() => {
				setIsLoading(false);
			});

		return () => {
			ignore = true;
		};
	}, [selectedOption]);

	function handleSelectChange(e: React.ChangeEvent<HTMLSelectElement>): void {
		const value = e.target.value;
		if (value in timeSelectOptions) {
			setSelectedOption(value as TimeSelectOptionKey);
		}
	}

	if (isLoading) {
		return <LoadingSpinner />;
	}

	if (error !== null) {
		return <ErrorMessage message={error} />;
	}

	return (
		<>
			<div className={styles.header}>
				<h2>Graph Widget</h2>
				<Select
					onSelectChange={handleSelectChange}
					value={selectedOption}
					options={timeSelectOptions}
				/>
			</div>

			<Chart data={data} />
		</>
	);
}

export default App;
