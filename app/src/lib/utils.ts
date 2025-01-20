import { twMerge } from "tailwind-merge";

/**
 * Function that merges tailwind classes.
 *
 * @param {string} classes - The tailwind classes.
 * @returns {string} - The merged tailwind classes.
 * @since 1.0.0
 */
export const mc = (classes: string): string => twMerge(classes);
