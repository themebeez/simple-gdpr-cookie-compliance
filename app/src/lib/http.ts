const { apiFetch } = window.wp;

interface FetchArgs {
	data?: any;
	body?: any;
	headers?: Record<string, string>;
}

/**
 * Function that wraps apiFetch function.
 *
 * @param {string} path
 * @param {string} method
 * @param {FetchArgs} arg
 * @returns {Promise<[Error | null, unknown | null]>}
 *
 * @usage const [error, data] = await useFetch(url, method, { data, headers });
 * @since 2.0.0
 */
export const useFetch = async (
	path: string,
	method: string,
	arg: FetchArgs = {}
): Promise<[Error | null, unknown | null]> => {
	const [e, res] = await apiFetch({
		path,
		method,
		data: arg?.data ? arg.data : null,
		body: arg?.body ? arg.body : null,
		headers: {
			"cache-control": "no-cache",
			...arg?.headers,
		},
	})
		.then((result: any) => {
			return [null, result || null];
		})
		.catch((e: Error) => {
			return [e, null];
		});

	return [e, res];
};
