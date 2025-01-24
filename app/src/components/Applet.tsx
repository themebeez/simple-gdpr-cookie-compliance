import Options from "@/options.json";
import React, { useEffect } from "react";
import { useOptions } from "@/stores/options";

import Box from "@/components/sections/Box";
import Help from "@/components/widgets/Help";
import Donation from "@/components/widgets/Donation";
import Container from "@/components/Container";
import Skeleton from "@/components/global/Skeleton";

export default function Applet() {
	const { values, sections } = Options;

	useEffect(() => {
		useOptions.setState({ data: values });
		useOptions.setState({ options: sections as any });
	}, []);

	return (
		<Container className="mt-[140px]">
			<Branding />
			<main
				id="Applet"
				className="mt-10 w-full flex items-stretch justify-between relative"
			>
				{sections ? <Content /> : <Skeleton />}

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
	const sections = useOptions((state) => state.options);

	return (
		<aside className="w-full flex flex-col gap-12">
			{sections &&
				Object.entries(sections).map(([k, section], index) => (
					<Box key={k} section={k} />
				))}
		</aside>
	);
};

const Sidebar = () => {
	return (
		<aside className="ms-12 w-full max-w-[300px] flex flex-col gap-12">
			<Donation />
			<Help />
		</aside>
	);
};
