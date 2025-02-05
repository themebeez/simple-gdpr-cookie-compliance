import React from "react";
import { Toaster } from "react-hot-toast";

import Header from "@/components/Header";
import Applet from "@/components/Applet";

export default function App() {
	return (
		<>
			<Header />
			<Applet />
			<Toaster
				position="top-center"
				containerStyle={{
					top: "3.5rem",
				}}
			/>
		</>
	);
}
