import React, { useMemo } from "react";
import { useOptions } from "@/stores/options";

import { Textarea } from "@/components/ui/Textarea";

import type { Field } from "@/stores/options";

interface Props {
	k: string;
	field: Field;
}

export default function TextAreaControl({ k, field }: Props) {
	const data = useOptions((state) => state.data) as Record<string, any>;

	/**
	 * Get the value of the textarea control.
	 *
	 * @returns {string} The value of the textarea control.
	 * @since 1.0.0
	 */
	const value = useMemo((): string => {
		return data[k] || "";
	}, [data]);

	/**
	 * Updates the value of the data store.
	 *
	 * @param {string} v The new value of the textarea control.
	 * @returns {void}
	 * @since 1.0.0
	 */
	const handleChange = (v: string): void => {
		useOptions.setState((state) => ({
			data: { ...state.data, [k]: v.trim() },
		}));
	};

	return (
		<Textarea
			defaultValue={value}
			placeholder={field.placeholder}
			onChange={(e) => handleChange(e.target.value)}
			className="p-4 min-h-[200px] font-normal text-base transition-colors duration-300 ease-in-out focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-500 "
		/>
	);
}
