import React from "react";

import { ChevronRight } from "lucide-react";

interface Props {
	title: string;
	link?: string | undefined;
}

export default function SectionTitle({ title, link }: Props) {
	const linkToDoc = link || "https://docs.addonify.com";

	return (
		<div className="pb-4 w-full flex flex-row items-center justify-between border-b border-gray-200">
			<div className="flex-basis-0">
				<h3 className="p-0 m-0 flex font-sans text-lg font-medium text-gray-800">
					{title}
				</h3>
			</div>

			<div className="flex-basis-0">
				<a
					href={linkToDoc}
					target="_blank"
					className="inline-flex items-center gap-x-2 text-base text-blue-500 hover:text-emerald-500 transition-colors duration-300 ease focus:outline-none focus:shadow-none leading-3"
				>
					Check docs <ChevronRight size={18} strokeWidth={1.5} />
				</a>
			</div>
		</div>
	);
}
