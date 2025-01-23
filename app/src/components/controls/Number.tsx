import React, { useMemo } from "react";
import { useOptions } from "@/stores/options";

import { Plus, Minus } from "lucide-react";

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
	 * @param {number} val The new value of the text control.
	 * @returns {void}
	 * @since 1.0.0
	 */
	const update = (val: number | string): void => {
		useOptions.setState((state) => ({
			data: { ...state.data, [k]: val },
		}));
	};

	/**
	 * Increases the value of the text control.
	 *
	 * @returns {void}
	 * @since 1.0.0
	 */
	const increase = (): void => {
		const max = field.max || 1000000000000000;

		if (Number(value) < max) {
			const steps = field.step || 1;

			/**
			 * Set the count state to the current value of the text control plus the steps.
			 */
			update(Number(value) + steps);
		}
	};

	/**
	 * Decreases the value of the text control.
	 *
	 * @returns {void}
	 * @since 1.0.0
	 */
	const decrease = (): void => {
		const min = field.min || 0;

		if (Number(value) > min) {
			const steps = field.step || 1;

			/**
			 * Set the count state to the current value of the text control minus the steps.
			 */
			update(Number(value) - steps);
		}
	};

	/**
	 * Handle when the text control is changed.
	 *
	 * @param {string} val The new value of the text control.
	 * @returns {void}
	 * @since 1.0.0
	 */
	const handleChange = (val: string): void => {
		const min = field.min || 0;

		const max = field.max || 1000000000000000;

		const input = parseInt(val) || min;

		switch (true) {
			case input < min:
				update(min);
				break;
			case input > max:
				update(max);
				break;
			default:
				update(input);
				break;
		}
	};

	return (
		<div className="py-2 px-3 w-full bg-white border border-gray-200 rounded-xl">
			<div className="w-full flex justify-between items-center gap-x-3">
				<div>
					<span className="ps-2 block text-xs text-gray-500">{field.unit}</span>
					<input
						type="number"
						value={value}
						onChange={(e) => handleChange(e.target.value)}
						min={field?.min || 0}
						max={field?.max || 1000000000000000}
						step={field?.step || 1}
						className="input-ghost p-0 bg-transparent !border-0 text-gray-700 focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none !focus:outline-none !focus:ring-0 !focus:border-0 !focus:ring-0 !focus:shadow-none"
					/>
				</div>

				<div className="flex justify-end items-center gap-x-1.5">
					<button
						type="button"
						onClick={decrease}
						className="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
						tabIndex={-1}
					>
						<Minus size={14} strokeWidth={2} />
					</button>

					<button
						type="button"
						onClick={increase}
						className="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
						tabIndex={-1}
					>
						<Plus size={14} strokeWidth={2} />
					</button>
				</div>
			</div>
		</div>
	);
}
