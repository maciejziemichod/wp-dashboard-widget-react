export type DataItem = {
	timestamp: number;
	value: number;
};

export type TimeSelectOptionKey = "seven" | "fifteen" | "thirty";
export type TimeSelectOption = {
	value: number;
	label: string;
};
export type TimeSelectOptions = {
	[key in TimeSelectOptionKey]: TimeSelectOption;
};
