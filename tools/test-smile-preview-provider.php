<?php
/**
 * Regression checks for Smile Preview OpenAI request shape.
 */

define('ABSPATH', __DIR__);

class WP_Error {
    private $code;
    private $message;

    public function __construct($code, $message) {
        $this->code = $code;
        $this->message = $message;
    }

    public function get_error_code() {
        return $this->code;
    }

    public function get_error_message() {
        return $this->message;
    }
}

if (!function_exists('curl_file_create')) {
    function curl_file_create($filename, $mime_type = null, $posted_filename = null) {
        return array(
            'filename' => $filename,
            'mime_type' => $mime_type,
            'posted_filename' => $posted_filename,
        );
    }
}

require __DIR__ . '/../simple-dental-theme/includes/smile-preview-provider.php';

function assert_true($condition, $message) {
    if (!$condition) {
        fwrite(STDERR, "FAIL: $message\n");
        exit(1);
    }
}

$tmp = tempnam(sys_get_temp_dir(), 'smile-preview-');
file_put_contents($tmp, 'fake-image-bytes');

$fields = simple_dental_openai_smile_preview_post_fields($tmp, 'image/png', 'Whiter smile', 'gpt-image-2');
assert_true(isset($fields['image[]']), 'GPT image edits must upload source as image[] multipart field.');
assert_true(!isset($fields['image']), 'Legacy image multipart field must not be used.');
assert_true(!isset($fields['input_fidelity']), 'gpt-image-2 must omit input_fidelity.');
assert_true($fields['model'] === 'gpt-image-2', 'Model should be preserved.');
assert_true(strpos($fields['prompt'], 'Whiter smile') !== false, 'Prompt should include selected goals.');

$legacy_fields = simple_dental_openai_smile_preview_post_fields($tmp, 'image/png', 'Whiter smile', 'gpt-image-1');
assert_true(isset($legacy_fields['image[]']), 'Legacy GPT image model still uses image[] multipart field.');
assert_true(isset($legacy_fields['input_fidelity']) && $legacy_fields['input_fidelity'] === 'high', 'gpt-image-1 should request high input fidelity.');

unlink($tmp);
echo "PASS: Smile Preview provider request shape is compatible with GPT image edits.\n";
