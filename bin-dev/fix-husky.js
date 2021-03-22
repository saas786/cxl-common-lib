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

// After upgrade to v5, receiving `error Command "husky-run" not found`.
// https://github.com/typicode/husky/issues/875#issuecomment-783346740
// https://github.com/mohanraj-r/sa11y/commit/5de0da2364c95a47f056b0475fadca80efb63aff
// https://github.com/salesforce/sa11y/blob/caa24df18b75514bfbcbb4680d17dd51d7e7560e/package.json#L49
// https://github.com/salesforce/sa11y/commit/caa24df18b75514bfbcbb4680d17dd51d7e7560e#diff-7ae45ad102eab3b6d7e7896acd08c427a9b25b346470d7bc6507b6481575d519
// https://github.com/typicode/husky/issues/84
// https://github.com/Decathlon/vitamin-web/commit/29e3ef772b11e3c20491911817ef71acdd8c539a
// nothing to do here though, it seems like above code works for it as well.
