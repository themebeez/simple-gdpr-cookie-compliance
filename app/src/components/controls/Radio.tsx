import React, { useMemo } from "react";
import { useOptions } from "@/stores/options";

import { RadioGroup, RadioGroupItem } from "@/components/ui/RadioGroup";

import type { Field } from "@/stores/options";

interface Props {
	k: string;
	field: Field;
}

export default function RadioControl({ k, field }: Props) {
	const data = useOptions((state) => state.data) as Record<string, any>;

	/**
	 * Get the value of the text control.
	 *
	 * @returns {string} The value of the text control.
	 * @since 1.0.0
	 */
	const value = useMemo((): string => {
		return data[k];
	}, [data]);

	/**
	 * Updates the value of the data store.
	 *
	 * @param {string} v The new value of the text control.
	 * @returns {void}
	 * @since 1.0.0
	 */
	const handleChange = (v: string): void => {
		useOptions.setState((state) => ({
			data: { ...state.data, [k]: v.trim() },
		}));
	};

	return (
		<RadioGroup
			defaultValue={value}
			onValueChange={(v) => handleChange(v)}
			className="w-full flex items-center gap-4"
		>
			{field.choices &&
				Object.entries(field.choices).map(([k, v]) => (
					<div
						key={k}
						className="px-5 py-3 flex items-center gap-x-2 border border-gray-200 rounded-xl shadow-sm transition-all duration-300 ease-in-out"
					>
						<RadioGroupItem value={k} id={k} />
						<label
							htmlFor={k}
							className="inline-flex items-center text-[15px] text-gray-700"
						>
							{v}
						</label>
					</div>
				))}
		</RadioGroup>
	);
}
