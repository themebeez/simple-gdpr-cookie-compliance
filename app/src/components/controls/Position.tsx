import React, { useMemo } from "react";
import { useOptions } from "@/stores/options";

import type { Field } from "@/stores/options";

interface Props {
	k: string;
	field: Field;
}

export default function PositionControl({ k, field }: Props) {
	const data = useOptions((state) => state.data) as Record<string, any>;

	const choices = field.choices as Record<string, any>;

	/**
	 * Collection of icons for the position control.
	 *
	 * @since 2.0.0
	 */
	const icons: Record<string, string> = {
		top_offset:
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13 12V20H11V12H4L12 4L20 12H13Z"></path></svg>',
		bottom_offset:
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13 12H20L12 20L4 12H11V4H13V12Z"></path></svg>',
		left_offset:
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 13V20L4 12L12 4V11H20V13H12Z"></path></svg>',
		right_offset:
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path></svg>',
	};

	/**
	 * Get the value of the position control.
	 *
	 * @returns {Record<string, number>} The value of the position control.
	 * @since 2.0.0
	 */
	const value = useMemo((): Record<string, number> => {
		return data[k];
	}, [data]);

	/**
	 * Updates the value of the data store.
	 *
	 * @param {string} kk
	 * @param {string} v
	 * @returns {void}
	 * @since 2.0.0
	 */
	const handleChange = (kk: string, v: string): void => {
		useOptions.setState((state) => ({
			data: {
				...state.data,
				[k]: {
					...(state.data?.[k] || {}),
					[kk]: Number(v),
				},
			},
		}));
	};

	return (
		<div className="position-control w-full max-w-[180px] grid grid-cols-2 gap-2 items-center">
			{Object.entries(choices).map(([k, v]) => (
				<label key={k} htmlFor={k} className="flex flex-col items-center gap-1">
					<span
						dangerouslySetInnerHTML={{ __html: icons[k] }}
						className="size-4 inline-flex items-center text-gray-400"
					/>

					<input
						type="number"
						id={k}
						name={k}
						defaultValue={value[k] || 0}
						disabled={!icons[k] || !icons[k].length}
						placeholder={v}
						onChange={(e) => handleChange(k, e.target.value)}
						className="px-3 py-3 w-20 h-12 inline-flex items-center text-center !text-base !text-gray-700 !border !border-gray-200 !rounded-lg !shadow-sm !focus:outline-none !focus:shadow-none !focus:ring-2 !focus:ring-blue-500 !focus:ring-offset-2 disabled:opacity-50"
					/>
				</label>
			))}
		</div>
	);
}
