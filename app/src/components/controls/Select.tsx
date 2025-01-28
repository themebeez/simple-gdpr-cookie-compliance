import React, { useMemo } from "react";
import { __ } from "@wordpress/i18n";
import { useOptions } from "@/stores/options";

import {
	Select,
	SelectValue,
	SelectItem,
	SelectContent,
	SelectTrigger,
} from "@/components/ui/Select";

import type { Field } from "@/stores/options";

interface Props {
	k: string;
	field: Field;
}

export default function SelectControl({ k, field }: Props) {
	const data = useOptions((state) => state.data) as Record<string, any>;

	const placeholder =
		field?.placeholder || __("Select", "simple-gdpr-cookie-compliance");

	/**
	 * Get the value of the select control
	 *
	 * @returns {string} The value of the select control
	 * @since 2.0.0
	 */
	const value = useMemo((): string => {
		return data[k];
	}, [data]);

	/**
	 * Updates the value of the data store.
	 *
	 * @param {string} v The new value of the select control
	 * @returns {void}
	 * @since 2.0.0
	 */
	const handleChange = (v: string): void => {
		useOptions.setState((state) => ({
			data: { ...state.data, [k]: v.trim() },
		}));
	};

	return (
		<Select defaultValue={value} onValueChange={(v) => handleChange(v)}>
			<SelectTrigger className="w-[250px] h-12 rounded-lg px-3 ps-4 inline-flex items-center justify-between border border-gray-200 shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
				<SelectValue placeholder={placeholder} />
			</SelectTrigger>
			<SelectContent className="px-2 py-4 shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)] rounded-xl">
				{field.choices &&
					Object.entries(field.choices).map(([k, v]) => (
						<SelectItem
							key={k}
							value={k}
							className="rounded-lg px-3 py-2 w-full max-w-full cursor-pointer transition-colors duration-500 ease-in-out hover:bg-gray-100"
						>
							{v}
						</SelectItem>
					))}
			</SelectContent>
		</Select>
	);
}
