import React from "react";
import { cn } from "@/lib/utils";

import Text from "@/components/controls/Text";
import Color from "@/components/controls/Color";
import Switch from "@/components/controls/Switch";
import Textarea from "@/components/controls/Textarea";
import Label from "@/components/sections/OptionLabel";

import type { Field } from "@/stores/options";

interface Props {
	k: string;
	field: Field;
}

export default function Field({ k, field }: Props) {
	const claX = () => {
		return field?.full_width ? "grid-cols-1 gap-4" : "grid-cols-2 gap-6";
	};

	return (
		<div
			className={cn(
				`option pb-8 w-full grid items-center justify-between relative border-b border-dashed border-gray-200 last:border-none last:mb-0 last:pb-0 ${claX()}`
			)}
		>
			<Label label={field.label} description={field?.description} />

			<div className="input-container flex items-center justify-end relative">
				{field.type === "switch" && <Switch k={k} />}
				{field.type === "text" && <Text k={k} field={field} />}
				{field.type === "color" && <Color k={k} field={field} />}
				{field.type === "textarea" && <Textarea k={k} field={field} />}
			</div>
		</div>
	);
}
