import React from "react";

import {
	Tooltip,
	TooltipContent,
	TooltipProvider,
	TooltipTrigger,
} from "@/components/ui/Tooltip";
import { Info } from "lucide-react";

interface Props {
	label: string;
	description?: string;
}

export default function OptionLabel({ label, description }: Props) {
	return (
		<div className="flex-basis-0 flex relative">
			{label && (
				<h2 className="flex items-center justify-between gap-x-2 font-normal text-base text-gray-700">
					{label}

					{description && (
						<TooltipProvider delayDuration={0.3}>
							<Tooltip>
								<TooltipTrigger className="text-gray-700 transition-colors duration-300 ease-in-out hover:text-gray-600">
									<Info size={18} strokeWidth={2} />
								</TooltipTrigger>
								<TooltipContent className="inline-flex items-center font-sans text-sm bg-zinc-800">
									{description}
								</TooltipContent>
							</Tooltip>
						</TooltipProvider>
					)}
				</h2>
			)}
		</div>
	);
}
