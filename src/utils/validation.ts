import { DataItem } from "../types";

export function isDataValid(data: unknown): data is DataItem[] {
	if (!Array.isArray(data)) {
		return false;
	}

	return data.every(
		(item) =>
			typeof item === "object" &&
			item !== null &&
			!Array.isArray(item) &&
			typeof item.value === "number" &&
			typeof item.timestamp === "number",
	);
}
