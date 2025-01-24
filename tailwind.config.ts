export default {
	darkMode: ["class"],
	content: ["./app/src/**/*.{js,ts,jsx,tsx}"],
	plugins: [
		require("@tailwindcss/forms"),
		require("tailwindcss-animate"),
		require("@tailwindcss/typography"),
	],
	theme: {
		extend: {
			fontFamily: {
				sans: ["Inter Variable", "sans-serif"],
				system: ["Arial", "Helvetica", "system-ui", "sans-serif"],
				cursive: ["cursive"],
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
			borderRadius: {
				lg: "var(--radius)",
				md: "calc(var(--radius) - 2px)",
				sm: "calc(var(--radius) - 4px)",
			},
		},
	},
};
