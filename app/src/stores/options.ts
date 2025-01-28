import { create } from "zustand";
import toast from "react-hot-toast";
import { __ } from "@wordpress/i18n";
import { useFetch } from "@/lib/http";
import { isEqual, clone } from "@/lib/utils";

export interface Section {
	doc_link?: string;
	section_title: string;
	fields: Field[];
}

export interface Sections {
	[key: string]: {
		doc_link?: string;
		section_title: string;
		fields: Field[];
	};
}

export interface Field {
	type: any;
	value: any;
	unit: string;
	label: string;
	min?: number;
	max?: number;
	step?: number;
	placeholder?: string;
	choices?: Record<string, any>;
	description: string;
	full_width?: boolean;
	dependent?: Record<string, any>[];
}

export interface Fields {
	[key: string]: Field[];
}

interface Store {
	data: Record<string, any> | null;
	oldData: Record<string, any> | null;
	options: Section[] | null;
	loading: boolean;
	saving: boolean;
}

export const useOptions = create<Store>((set) => ({
	/**
	 * The data store. Reactive state for the options.
	 */
	data: null,

	/**
	 * Non-reactive state for the fields.
	 */
	oldData: null,

	/**
	 * The sections, fields, and choices store. Non-reactive state for the options.
	 */
	options: null,

	/**
	 * Loading state.
	 *
	 * @var {boolean} - The loading state.
	 */
	loading: true,

	/**
	 * Saving state.
	 *
	 * @var {boolean} - The saving state.
	 */
	saving: false,
}));

/**
 * Get the options.
 *
 * @returns {Promise<void>} The options.
 * @since 2.0.0
 */
export const getOptions = async (): Promise<void> => {
	useOptions.setState({ loading: true });

	const path = "sgcc/v1/options";

	const [e, res]: [Error | null, any] = await useFetch(path, "GET");

	if ((e && !res) || !res.success || !res.data) {
		throw new Error(e?.message);
	}

	const data = res?.data?.values;

	const sections = res?.data?.sections;

	/**
	 * Clone the data.
	 */
	useOptions.setState({ oldData: clone(data) });

	/**
	 * Set the stores.
	 */
	useOptions.setState({ data: data });

	useOptions.setState({ options: sections as any });

	useOptions.setState({ loading: false });
};

/**
 * Update the options.
 *
 * @returns {Promise<void>} The options.
 * @since 2.0.0
 */
export const updateOptions = async (): Promise<void> => {
	const data = useOptions.getState().data as Record<string, any>;

	const old = useOptions.getState().oldData as Record<string, any>;

	if (!old || !data || !Object.keys(data).length || !Object.keys(old).length) {
		toast.success(__("No changes.", "simple-gdpr-cookie-compliance"));
		return;
	}

	const updated: Record<string, any> = {};

	for (const [k, v] of Object.entries(data)) {
		if (!isEqual(v, old[k])) {
			updated[k] = v;
		}
	}

	if (!updated || !Object.keys(updated).length) {
		toast.success(__("No changes.", "simple-gdpr-cookie-compliance"));
		return;
	}

	useOptions.setState({ saving: true });

	const path = "sgcc/v1/options";

	const [e, res]: [Error | null, any] = await useFetch(path, "PATCH", {
		data: JSON.stringify(updated),
	});

	useOptions.setState({ saving: false });

	if ((e && !res) || !res.success) {
		toast.error(
			__("Failed to update the settings.", "simple-gdpr-cookie-compliance")
		);

		throw new Error(e?.message);
	}

	/**
	 * Clone the data.
	 */
	useOptions.setState({ oldData: clone(data) });

	toast.success(__("Settings updated.", "simple-gdpr-cookie-compliance"));
};
