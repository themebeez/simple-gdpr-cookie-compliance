import React from "react";
import { __ } from "@wordpress/i18n";

import { Star } from "lucide-react";
import SaveButton from "@/components/Save";
import Logo from "@/components/global/Logo";

export default function Header() {
	return (
		<header className="px-6 py-4 flex flex-row items-center justify-between gap-5 fixed left-[180px] right-[20px] top-[40px] z-50 bg-white rounded-full shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)]">
			<LeftContainer />
			<RightContainer />
		</header>
	);
}

const LeftContainer = () => {
	const { simpleGDPRCookieLocal } = window;

	return (
		<div className="w-full flex items-center gap-4">
			<div className="flex-basis-0 flex items-center border-r border-gray-200 pr-4">
				<Logo />
			</div>

			<div className="flex items-center gap-x-1 font-sans font-[200] text-xs text-zinc-800 leading-3 uppercase">
				<span className="tracking-[3px]">
					{__("Addon version:", "simple-gdpr-cookie-compliance")}
				</span>
				{simpleGDPRCookieLocal?.version || "1.0.0"}
			</div>
		</div>
	);
};

const RightContainer = () => {
	return (
		<div className="w-full flex items-center gap-6 justify-end relative">
			<a
				target="_blank"
				href="https://wordpress.org/support/plugin/simple-gdpr-cookie-compliance/reviews/?filter=5"
				rel="noreferrer noopener"
				className="px-4 py-2 inline-flex items-center gap-x-2 text-md text-gray-600 border border-gray-200 hover:text-blue-500 rounded-full"
			>
				<span className="inline-flex items-center">
					<Star
						size={16}
						strokeWidth={1}
						className="text-zinc-800 fill-yellow-500"
					/>
					<Star
						size={16}
						strokeWidth={1}
						className="text-zinc-800 fill-yellow-500"
					/>
					<Star
						size={16}
						strokeWidth={1}
						className="text-zinc-800 fill-yellow-500"
					/>
					<Star
						size={16}
						strokeWidth={1}
						className="text-zinc-800 fill-yellow-500"
					/>
					<Star
						size={16}
						strokeWidth={1}
						className="text-zinc-800 fill-yellow-500"
					/>
				</span>
				{__("Rate SGCC", "simple-gdpr-cookie-compliance")}
			</a>
			<SaveButton />
		</div>
	);
};
