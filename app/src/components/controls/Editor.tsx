import { cn } from "@/lib/utils";
import { __ } from "@wordpress/i18n";
import { toast } from "react-hot-toast";
import { useOptions } from "@/stores/options";
import React, { useEffect, useMemo, useState } from "react";

import {
	Link as LinkX,
	Bold as BoldX,
	Unlink as UnlinkX,
	Italic as ItalicX,
	Pilcrow as ParagraphX,
} from "lucide-react";
import Link from "@tiptap/extension-link";
import Bold from "@tiptap/extension-bold";
import Text from "@tiptap/extension-text";
import Italic from "@tiptap/extension-italic";
import Document from "@tiptap/extension-document";
import Paragraph from "@tiptap/extension-paragraph";
import { useEditor, EditorContent } from "@tiptap/react";

import type { Editor } from "@tiptap/react";
import type { Field } from "@/stores/options";

interface Props {
	k: string;
	field: Field;
}

export default function EditorControl({ k, field }: Props) {
	const [focus, setFocus] = useState(false);

	const data = useOptions((state) => state.data) as Record<string, any>;

	/**
	 * Get the value of the position control.
	 *
	 * @returns {Record<string, number>} The value of the position control.
	 * @since 1.0.0
	 */
	const content = useMemo((): Record<string, number> => {
		return data[k];
	}, [data]);

	/**
	 * Function that handles the change of the editor.
	 *
	 * @param {string} html The new HTML content of the editor.
	 * @returns {void}
	 * @since 1.0.0
	 */
	const handleChange = (html: string): void => {
		useOptions.setState((state) => ({
			data: { ...state.data, [k]: html },
		}));
	};

	/**
	 * Editor instance.
	 *
	 * @since 1.0.0
	 */
	let editor = useEditor({
		editable: true,
		content: content || "<p>Hi there!</p>",
		extensions: [
			Bold,
			Text,
			Italic,
			Document,
			Paragraph,
			Link.configure({
				openOnClick: false,
				linkOnPaste: true,
				autolink: false,
				HTMLAttributes: {
					rel: "noopener noreferrer",
					target: "_blank",
					class: "text-blue-500 font-normal underline hover:text-blue-600",
				},
			}),
		],
		editorProps: {
			attributes: {
				class: "prose relative w-full",
			},
		},
		onTransaction: () => {
			editor = editor; // Force re-render so `editor.isActive` works as expected.
		},
		onFocus: () => setFocus(true),
		onBlur: () => setFocus(false),
		onUpdate: ({ editor }) => handleChange(editor.getHTML()),
	}) as Editor;

	/**
	 * Editor class names.
	 *
	 * @returns {string} The class names.
	 * @since 1.0.0
	 */
	const editorClass = useMemo((): string => {
		const iniClass =
			"editor p-6 w-full border border-gray-200 rounded-xl relative transition-all duration-300 ease-in-out shadow-sm";

		const activeClass = "ring-2 ring-offset-2 	ring-blue-500";

		return focus ? `${iniClass} ${activeClass}` : iniClass;
	}, [focus]);

	useEffect(() => {
		/**
		 * Cleanup function to destroy the editor.
		 */
		return () => editor?.destroy();
	}, []);

	return (
		<div className={editorClass}>
			<Toolbar editor={editor} />
			<EditorContent editor={editor} />
		</div>
	);
}

const Toolbar = ({ editor }: { editor: Editor }) => {
	/**
	 * Function to set the link.
	 *
	 * @returns {void}
	 * @since 1.0.0
	 */
	const setLink = (): void => {
		const link = editor.getAttributes("link").href;

		const url = window.prompt("URL", link)?.trim();

		const unsetLink = () => {
			editor.chain().focus().extendMarkRange("link").unsetLink().run();
			return;
		};

		/**
		 * Check the URL pattern.
		 *
		 * Pattern: https:// | http:// | mailto: | tel: | #
		 */
		const pattern = /^(https:\/\/|http:\/\/|mailto:|tel:|#)/;

		if (url && !pattern.test(url)) {
			const message = __(
				"Invalid URL pattern.",
				"simple-gdpr-cookie-compliance"
			);

			toast.error(message);

			unsetLink();
			return;
		}

		if (!url || url === "") {
			unsetLink();
			return;
		}

		editor.chain().focus().extendMarkRange("link").setLink({ href: url }).run();
	};

	/**
	 * Button class names.
	 *
	 * @param {boolean} active
	 * @returns {string} The class names.
	 * @since 1.0.0
	 */
	const buttonClass = (active: boolean = false): string => {
		const iniClass =
			"size-8 inline-flex items-center justify-center text-gray-700 bg-transparent border border-transparent transition-colors duration-500 ease-in-out rounded-full shadow-sm hover:border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:cursor-not-allowed disabled:opacity-50";

		const activeClass = "bg-gray-100 border-gray-300";

		return active ? cn(`${iniClass} ${activeClass}`) : iniClass;
	};

	return (
		<div className="pb-4 mb-6 w-full flex items-center gap-2 border-b border-gray-200">
			<button
				type="button"
				onClick={() => editor.chain().focus().setParagraph().run()}
				className={buttonClass(editor.isActive("paragraph"))}
			>
				<ParagraphX size={18} strokeWidth={1.6} />
			</button>

			<button type="button" className={buttonClass(editor.isActive("bold"))}>
				<BoldX
					onClick={() => editor.chain().focus().toggleBold().run()}
					size={18}
					strokeWidth={1.6}
				/>
			</button>

			<button type="button" className={buttonClass(editor.isActive("italic"))}>
				<ItalicX
					onClick={() => editor.chain().focus().toggleItalic().run()}
					size={18}
					strokeWidth={1.6}
				/>
			</button>

			<button
				type="button"
				onClick={setLink}
				className={buttonClass(editor.isActive("link"))}
			>
				<LinkX size={18} strokeWidth={1.6} />
			</button>

			<button
				type="button"
				onClick={() => editor.chain().focus().unsetLink().run()}
				disabled={!editor.isActive("link")}
				className={buttonClass()}
			>
				<UnlinkX size={18} strokeWidth={1.6} />
			</button>
		</div>
	);
};
