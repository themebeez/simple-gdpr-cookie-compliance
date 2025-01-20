import React from "react";
import { mc } from "@/lib/utils";

interface Props {
	className?: string;
	children: React.ReactNode;
}

export default function Container({ className, children }: Props) {
	return (
		<div
			className={mc(
				`p-0 m-0 px-4 max-w-[1200px] w-full mx-auto relative block ${className}`
			)}
		>
			{children}
		</div>
	);
}
