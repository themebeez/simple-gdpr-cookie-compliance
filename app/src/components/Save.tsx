import React from "react";

import { Save } from "lucide-react";

export default function SaveOptions() {
	return (
		<button
			type="button"
			className="py-3 px-6 inline-flex items-center gap-x-2 text-base font-normal rounded-full border border-transparent bg-blue-600 text-white shadow transition-all duration-300 ease-in-out hover:shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)] hover:bg-emerald-500 focus:outline-none focus:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-100 disabled:text-gray-300 disabled:bg-gray-200 disabled:cursor-not-allowed"
		>
			Save options
			<Save size={18} strokeWidth={2} />
		</button>
	);
}
