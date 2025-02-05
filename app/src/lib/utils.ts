import { twMerge } from "tailwind-merge";
import { clsx, type ClassValue } from "clsx";

const { isEqual: equal, cloneDeep } = window.lodash;

/**
 * Function that merges tailwind classes.
 *
 * @param {ClassValue[]} inputs - The tailwind classes to merge.
 * @returns {string} - The merged tailwind classes.
 * @since 2.0.0
 */
export function cn(...inputs: ClassValue[]): string {
	return twMerge(clsx(inputs));
}

/**
 * Compare if arguments are equal.
 *
 * @param {unknown} arg1
 * @param {unknown} arg2
 * @returns {boolean}
 * @since 2.0.0
 */
export const isEqual = (arg1: unknown, arg2: unknown): boolean => {
	return equal(arg1, arg2) ? true : false;
};

/**
 * Clone the deeply nested object.
 *
 * @param {unknown} arg
 * @returns {unknown} - cloned object.
 * @since 2.0.0
 */
export const clone = <T>(arg: T): T => {
	return cloneDeep(arg) as T;
};
