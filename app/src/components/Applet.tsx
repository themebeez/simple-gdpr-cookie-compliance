import React from "react";

import Box from "@/components/sections/Box";
import Help from "@/components/widgets/Help";
import Container from "@/components/Container";

export default function Applet() {
	return (
		<Container className="mt-[140px]">
			<Branding />
			<main
				id="Applet"
				className="mt-10 w-full flex items-stretch justify-between relative"
			>
				<Content />
				<Sidebar />
			</main>
		</Container>
	);
}

const Branding = () => {
	return (
		<section className="w-full flex flex-col items-center">
			<span className="text-4xl font-sans font-[250] uppercase text-orange-200 tracking-[10px]">
				Simple GDPR Cookie Compliance🍪
			</span>
		</section>
	);
};

const Content = () => {
	return (
		<>
			<Box />
		</>
	);
};

const Sidebar = () => {
	return (
		<aside className="ms-12 w-full max-w-[300px] flex flex-col gap-12">
			<Help />
		</aside>
	);
};
