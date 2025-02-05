import React, { useMemo } from "react";
import { useOptions } from "@/stores/options";

import { Input } from "@/components/ui/Input";

import type { Field } from "@/stores/options";

interface Props {
	k: string;
	field: Field;
}

export default function TextControl({ k, field }: Props) {
	const data = useOptions((state) => state.data) as Record<string, any>;

	/**
	 * Get the value of the text control.
	 *
	 * @returns {string} The value of the text control.
	 * @since 2.0.0
	 */
	const value = useMemo((): string => {
		return data[k] || "";
	}, [data]);

	/**
	 * Updates the value of the data store.
	 *
	 * @param {string} v The new value of the text control.
	 * @returns {void}
	 * @since 2.0.0
	 */
	const handleChange = (v: string): void => {
		useOptions.setState((state) => ({
			data: { ...state.data, [k]: v.trim() },
		}));
	};

	return (
		<Input
			defaultValue={value}
			placeholder={field.placeholder}
			onChange={(e: any) => handleChange(e.target.value)}
			className="w-full max-w-[350px] font-normal text-base transition-colors duration-300 ease-in-out focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-500 "
		/>
	);
}
