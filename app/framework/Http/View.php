<?php declare(strict_types=1);

namespace Framework\Http;

use InvalidArgumentException;
use RuntimeException;

final class View
{
    public static function render(string $template, array $data = []): string
    {
        if (preg_match('/^[a-zA-Z0-9_\-\/]+$/', $template) !== 1) {
            throw new InvalidArgumentException(sprintf('Invalid template name: %s', $template));
        }

        $file = ROOT_DIR . '/views/' . $template . '.php';

        if (!is_file($file)) {
            throw new RuntimeException(sprintf('Template not found: %s', $file));
        }

        extract($data, EXTR_SKIP);

        ob_start();

        require $file;

        return (string) ob_get_clean();
    }
}
