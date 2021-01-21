// https://github.com/typicode/husky/issues/749#issuecomment-691531840
// until this is fixed: https://github.com/yarnpkg/yarn/issues/8340
const fs = require('fs');

// If Operating System is Windows, fix Husky for Yarn
if (process.platform === 'win32') {
	const huskyScript = fs.readFileSync('.git/hooks/husky.sh', {
		encoding: 'utf-8',
	});
	const fixedHuskyScript = huskyScript.replace(
		'run_command yarn run --silent;;',
		'run_command npx --no-install;;'
	);
	fs.writeFileSync('.git/hooks/husky.sh', fixedHuskyScript);
}
