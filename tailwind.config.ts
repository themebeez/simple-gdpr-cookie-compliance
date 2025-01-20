export default {
	content: ["./app/src/**/*.{js,ts,jsx,tsx}"],
	plugins: [require("@tailwindcss/forms")],
	theme: {
		extend: {
			fontFamily: {
				sans: ["Inter Variable", "sans-serif"],
				system: ["Arial", "Helvetica", "system-ui", "sans-serif"],
				mono: [
					"Menlo",
					"Monaco",
					"monospace",
					"Courier New",
					"ui-monospace",
					"SFMono-Regular",
				],
			},
			colors: {
				brand: "#00C16A",
				"brand-alt": "#12A764",
			},
		},
	},
};
