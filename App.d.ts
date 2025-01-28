export {};

declare global {
	interface Window {
		wp: WP;
		lodash: any;
		simpleGDPRCookieLocal: Record<string, any>;
	}
}

interface WP {
	apiFetch: (args: Record<string, any>) => Promise<any>;
}
