import React from "react";

import SaveOptions from "@/components/Save";

export default function Header() {
	return (
		<header className="px-6 py-4 flex flex-row items-center justify-between gap-5 fixed left-[180px] right-[20px] top-[40px] z-50 bg-white rounded-full shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)]">
			<div className="flex-basis-0 flex items-center gap-4">
				<Branding />
				<Version />
			</div>

			<div className="w-full flex items-center justify-end">
				<SaveOptions />
			</div>
		</header>
	);
}

const Branding = () => {
	return (
		<div className="flex-basis-0 flex items-center">
			<h1 className="inline-flex items-center font-medium text-lg">Cookie.</h1>
		</div>
	);
};

const Version = () => {
	return null;
};
