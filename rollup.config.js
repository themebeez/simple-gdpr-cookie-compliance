import path from 'path';
import { fileURLToPath } from 'url';

import scss from 'rollup-plugin-scss';
import babel from '@rollup/plugin-babel';
import alias from '@rollup/plugin-alias';
import terser from '@rollup/plugin-terser';
import resolve from '@rollup/plugin-node-resolve';

import postcss from 'postcss';
import cssnano from 'cssnano';
import autoprefixer from 'autoprefixer';
import postcssRTLCSS from 'postcss-rtlcss';
import { Mode, Source } from 'postcss-rtlcss/options';

/**
 * Define extensions to be resolved via alias.
 *
 * @since 2.0.0
 */
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const rootDir = path.resolve(__dirname);

const resolveExtensions = resolve({
	extensions: ['.mjs', '.js', '.jsx', '.sass', '.scss'],
});

const resolveAlias = alias({
	entries: [
		{
			find: 'src',
			replacement: path.resolve(rootDir, './public/assets/src/'),
		},
	],
	resolveExtensions,
});

/**
 * Prepare global options.
 * Holds path & name of source and destination assets.
 *
 * @since 2.0.0
 */
const assets = {
	script: {
		src: './public/assets/src/init.js',
		build: './public/assets/dist/public.min.js',
	},
	scss: {
		src: './public/assets/src/scss',
		build: './public/assets/dist/public.min.css',
		buildName: 'public.min.css',
	},
};

/**
 * Define plugins once and reuse them.
 */
export default [
	{
		input: assets['script']['src'],
		output: {
			file: assets['script']['build'],
			name: 'js',
			format: 'umd', // "umd", "iife", "esm", "cjs"
		},
		plugins: [
			resolve(),
			babel(),
			terser(),
			scss({
				output: assets['scss']['build'],
				fileName: assets['scss']['buildName'],
				sourceMap: true,
				watch: assets['scss']['src'],
				processor: async () => postcss([
					autoprefixer(),
					postcssRTLCSS({
						mode: Mode.override,
						source: Source.ltr,
					}),
					cssnano()
				])
			}),
			resolveAlias,
		]
	}
];
