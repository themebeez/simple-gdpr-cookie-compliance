import React, { useMemo } from "react";
import { useOptions } from "@/stores/options";

import { Switch } from "@/components/ui/Switch";

interface Props {
	k: string;
}

export default function SwitchControl({ k }: Props) {
	const data = useOptions((state) => state.data) as Record<string, any>;

	/**
	 * Get the value of the switch control.
	 *
	 * @returns {boolean} The value of the switch control.
	 * @since 1.0.0
	 */
	const value = useMemo(() => {
		const input = data[k] || false;
		return input === "true" || input === true ? true : false;
	}, [data]);

	/**
	 * Updates the value of the data store.
	 *
	 * @param {boolean} v The new value of the switch control.
	 * @returns {void}
	 * @since 1.0.0
	 */
	const handleChange = (v: boolean): void => {
		useOptions.setState((state) => ({
			data: { ...state.data, [k]: v },
		}));
	};

	return (
		<Switch defaultChecked={value} onCheckedChange={(v) => handleChange(v)} />
	);
}
