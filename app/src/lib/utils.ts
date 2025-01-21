import { twMerge } from "tailwind-merge";
import { clsx, type ClassValue } from "clsx";

/**
 * Function that merges tailwind classes.
 *
 * @param {ClassValue[]} inputs - The tailwind classes to merge.
 * @returns {string} - The merged tailwind classes.
 * @since 1.0.0
 */
export function cn(...inputs: ClassValue[]): string {
	return twMerge(clsx(inputs));
}
