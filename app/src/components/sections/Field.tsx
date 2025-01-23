import React, { useCallback, useMemo } from "react";
import { cn } from "@/lib/utils";
import { useOptions, type Field } from "@/stores/options";

import Text from "@/components/controls/Text";
import Radio from "@/components/controls/Radio";
import Color from "@/components/controls/Color";
import Switch from "@/components/controls/Switch";
import Number from "@/components/controls/Number";
import Textarea from "@/components/controls/Textarea";
import Label from "@/components/sections/OptionLabel";

interface Props {
	k: string;
	field: Field;
}

export default function Field({ k, field }: Props) {
	const data = useOptions((state) => state.data) as Record<string, any>;

	const deps = field?.dependent || {};

	const full = field?.full_width || false;

	/**
	 * Check if the field should be hidden based on the dependent fields.
	 *
	 * @returns {boolean} Whether the field should be hidden.
	 * @since 1.0.0
	 */
	const hidden = useMemo((): boolean => {
		if (!deps || !Object.keys(deps).length) {
			return false;
		}

		const keys = Object.keys(deps);

		const values = Object.values(deps);

		return keys.some((key, i) => {
			return data[key] !== values[i];
		});
	}, [data]);

	return (
		<div
			className={cn(
				`option pb-8 w-full items-center justify-between relative border-b border-dashed border-gray-200 last:border-none last:mb-0 last:pb-0 ${
					full ? "grid-cols-1" : "grid-cols-2"
				} ${hidden ? "hidden" : "grid"}`
			)}
		>
			<Label label={field.label} description={field?.description} />

			<div className="input-container flex items-center justify-end relative">
				{field.type === "switch" && <Switch k={k} />}
				{field.type === "text" && <Text k={k} field={field} />}
				{field.type === "color" && <Color k={k} field={field} />}
				{field.type === "radio" && <Radio k={k} field={field} />}
				{field.type === "number" && <Number k={k} field={field} />}
				{field.type === "textarea" && <Textarea k={k} field={field} />}
			</div>
		</div>
	);
}
