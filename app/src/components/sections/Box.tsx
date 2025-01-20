import React from "react";

import Title from "@/components/sections/Title";

export default function SectionBox() {
	return (
		<section className="m-0 p-8 w-full min-h-[600px] flex flex-col relative bg-white rounded-2xl shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)]">
			<Title title="Basic options" />
		</section>
	);
}
