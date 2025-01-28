export {};

declare global {
	interface Window {
		wp: WP;
		lodash: any;
		simpleGDPRCookieLocal: {
			[key: string]: unknown;
		};
	}
}

interface WP {
	apiFetch: (args: Record<string, any>) => Promise<any>;
}
