import React from "react";
import { Skeleton as Loading } from "@/components/ui/Skeleton";

export default function Skeleton() {
	const count = 100;
	return (
		<div className="w-full flex flex-col gap-4">
			<Loading className="h-4 w-full max-w-[150px] rounded-xl" />
			<Loading className="h-4 w-full max-w-[300px] rounded-xl" />
			<Loading className="h-4 w-full max-w-[400px] rounded-xl" />
			<Loading className="h-4 w-full max-w-[600px] rounded-xl" />
			<Loading className="h-4 w-full max-w-[800px] rounded-xl" />

			{Array.from({ length: count }).map((_, index) => (
				<Loading key={index} className="h-4 w-full rounded-xl" />
			))}
		</div>
	);
}
