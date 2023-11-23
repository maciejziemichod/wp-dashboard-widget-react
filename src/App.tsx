import { useEffect, useState } from "react";
import { ErrorMessage } from "./components/ErrorMessage";
import { LoadingSpinner } from "./components/LoadingSpinner";
import { isDataValid } from "./utils/validation";
import { DataItem } from "./types";

declare const wpApiSettings: { root: string } | undefined;

function App() {
	const restUrl = wpApiSettings?.root;

	const [error, setError] = useState(restUrl ? null : "No REST URL found.");
	const [data, setData] = useState<DataItem[]>([]);
	const [isLoading, setIsLoading] = useState(true);

	useEffect(() => {
		fetch(`${restUrl}myplugin/v1/data`)
			.then((res) => res.json())
			.then((data: unknown) => {
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
	}, []);

	if (isLoading) {
		return <LoadingSpinner />;
	}

	if (error !== null) {
		return <ErrorMessage message={error} />;
	}

	return (
		<p>
			hello world, rest: {restUrl}, data: {JSON.stringify(data)}
		</p>
	);
}

export default App;
