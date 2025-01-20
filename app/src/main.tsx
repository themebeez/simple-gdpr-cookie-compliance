import React from "react";
import ReactDOM from "react-dom/client";

import "@/App.css";
import "@fontsource-variable/inter";

import App from "./App";

const ele = document.getElementById("simple-gdpr-cookie-compliance-app");

ReactDOM.createRoot(ele!).render(
	<React.StrictMode>
		<App />
	</React.StrictMode>
);
