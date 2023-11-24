import { TimeSelectOptionKey, TimeSelectOptions } from '../types';

type SelectProps = {
	onSelectChange: (e: React.ChangeEvent<HTMLSelectElement>) => void;
	value: TimeSelectOptionKey;
	options: TimeSelectOptions;
};

export function Select({ onSelectChange, value, options }: SelectProps) {
	return (
		<select value={value} onChange={onSelectChange}>
			{Object.entries(options).map(([key, { label }]) => (
				<option key={key} value={key}>
					{label}
				</option>
			))}
		</select>
	);
}
