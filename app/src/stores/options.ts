import { create } from "zustand";

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
	label: string;
	placeholder?: string;
	choices?: Choices;
	description: string;
	full_width?: boolean;
}

export interface Fields {
	[key: string]: Field[];
}

interface Choices {
	[key: string]: {
		[key: string]: any;
	};
}

interface Store {
	data: Record<string, any> | null;
	options: Section[] | null;
}

export const useOptions = create<Store>((set) => ({
	/**
	 * The data store. Reactive state for the options.
	 */
	data: null,

	/**
	 * The sections, fields, and choices store. Non-reactive state for the options.
	 */
	options: null,
}));
