const fs = require('fs');
const vm = require('vm');

const source = fs.readFileSync('simple-dental-theme/assets/js/smile-preview.js', 'utf8');

function assert(condition, message) {
  if (!condition) {
    console.error(`FAIL: ${message}`);
    process.exit(1);
  }
}

const maxEdgeMatch = source.match(/const\s+MAX_CANVAS_EDGE\s*=\s*(\d+)\s*;/);
const jpegQualityMatch = source.match(/canvas\.toBlob\([\s\S]*?'image\/jpeg',\s*([0-9.]+)\s*\);/);

assert(maxEdgeMatch, 'MAX_CANVAS_EDGE constant exists.');
assert(Number(maxEdgeMatch[1]) === 768, 'AI upload max edge should be 768px.');
assert(jpegQualityMatch, 'AI upload JPEG quality exists.');
assert(Number(jpegQualityMatch[1]) === 0.86, 'AI upload JPEG quality should be 0.86.');

new vm.Script(source);

console.log('PASS: Smile Preview client downsizes AI upload to 768px at JPEG quality 0.86.');
