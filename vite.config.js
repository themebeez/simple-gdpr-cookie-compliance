import path from "path";
import react from "@vitejs/plugin-react";
import { v4wp } from "@kucrut/vite-for-wp";

export default {
	plugins: [
		react({
			jsxRuntime: "automatic",
		}),
		v4wp({
			input: "app/src/main.tsx",
			outDir: "app/dist",
		}),
	],
	resolve: {
		alias: {
			"@": path.resolve(__dirname, "./app/src"),
		},
	},
	build: {
		sourcemap: false,
	},
};
