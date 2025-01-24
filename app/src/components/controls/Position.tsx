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
	 * @since 1.0.0
	 */
	const icons: Record<string, string> = {
		"top-left-offset":
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.3608 10.9468L18.0176 16.6037L16.6034 18.0179L10.9466 12.361L5.99683 17.3108V5.99707H17.3105L12.3608 10.9468Z"></path></svg>',
		"top-offset":
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13 12V20H11V12H4L12 4L20 12H13Z"></path></svg>',
		"top-right-offset":
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"></path></svg>',
		"bottom-left-offset":
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.3608 13.0515L17.3105 18.0013H5.99683V6.68758L10.9466 11.6373L16.6034 5.98047L18.0176 7.39468L12.3608 13.0515Z"></path></svg>',
		"bottom-offset":
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13 12H20L12 20L4 12H11V4H13V12Z"></path></svg>',
		"bottom-right-offset":
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.6366 13.0515L5.97974 7.39468L7.39395 5.98047L13.0508 11.6373L18.0006 6.68758V18.0013H6.68684L11.6366 13.0515Z"></path></svg>',
	};

	/**
	 * Get the value of the position control.
	 *
	 * @returns {Record<string, number>} The value of the position control.
	 * @since 1.0.0
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
	 * @since 1.0.0
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
		<div className="position-control w-full max-w-[300px] grid grid-cols-3 gap-4 items-center">
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
