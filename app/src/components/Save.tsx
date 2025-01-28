import { __ } from "@wordpress/i18n";
import React, { useMemo } from "react";
import { useOptions, updateOptions } from "@/stores/options";

import { Save } from "lucide-react";

export default function SaveOptions() {
	const saving = useOptions((state) => state.saving);

	const loading = useOptions((state) => state.loading);

	const saveLabel = __("Save Options", "simple-gdpr-cookie-compliance");

	const savingLabel = __("Saving options...", "simple-gdpr-cookie-compliance");

	return (
		<button
			type="button"
			onClick={updateOptions}
			disabled={saving || loading}
			className="py-3 px-6 inline-flex items-center gap-x-2 text-base font-normal rounded-full border border-transparent bg-blue-600 text-white shadow transition-all duration-300 ease-in-out hover:shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)] hover:bg-emerald-500 focus:outline-none focus:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-100 disabled:text-gray-400 disabled:bg-gray-200 disabled:cursor-not-allowed"
		>
			{saving ? (
				<>
					{savingLabel}
					<Spinner disabled={loading || saving} />
				</>
			) : (
				<>
					{saveLabel}
					<Save size={18} strokeWidth={2} />
				</>
			)}
		</button>
	);
}

const Spinner = ({ disabled }: { disabled: boolean }) => {
	const claX = useMemo((): string => {
		return disabled ? "text-zinc-400" : "text-white";
	}, [disabled]);

	return (
		<span
			role="status"
			aria-label="loading"
			className={`animate-spin inline-block size-5 border-[2px] border-current border-t-transparent rounded-full ${claX}`}
		/>
	);
};
