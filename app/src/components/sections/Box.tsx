import React from "react";
import { useOptions } from "@/stores/options";

import Title from "@/components/sections/Title";
import Field from "@/components/sections/Field";

import type { Section } from "@/stores/options";

interface Props {
	section: string;
}

export default function SectionBox({ section }: Props) {
	const state = useOptions((state) => state.options) as Section[];

	const k = section as keyof typeof state;

	const sec = state[k] as Section;

	return (
		<section className="m-0 p-8 w-full min-h-[600px] flex flex-col gap-8 relative bg-white rounded-2xl shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)]">
			<Title title={sec.section_title} link={sec.doc_link} />

			<div className="options w-full flex flex-col gap-6">
				{Object.entries(sec.fields).map(([k, field], index) => (
					<Field key={k} k={k} field={field} />
				))}
			</div>
		</section>
	);
}
