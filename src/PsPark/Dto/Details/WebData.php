<?php

declare(strict_types=1);

namespace PsPark\Dto\Details;

use PsPark\Dto\RequestDtoInterface;

class WebData implements RequestDtoInterface
{
    public function __construct(
        private readonly ?string $ip = null,
        private readonly ?string $userAgent = null,
        private readonly ?int $browserColorDepth = null,
        private readonly ?string $browserLanguage = null,
        private readonly ?int $browserScreenHeight = null,
        private readonly ?int $browserScreenWidth = null,
        private readonly ?string $browserTimezone = null,
        private readonly ?int $browserTimezoneOffset = null,
        private readonly ?bool $browserJavaEnabled = null,
        private readonly ?bool $browserJavaScriptEnabled = null,
        private readonly ?string $browserAcceptHeader = null,
    ) {
    }

    /**
     * @return array
     *
     * @psalm-return array{
     *     ip?: string|null,
     *     user_agent?: string|null,
     *     browser_color_depth?: int|null,
     *     browser_language?: string|null,
     *     browser_screen_height?: int|null,
     *     browser_screen_width?: int|null,
     *     browser_timezone?: string|null,
     *     browser_timezone_offset?: int|null,
     *     browser_java_enabled?: bool|null,
     *     browser_java_script_enabled?: bool|null,
     *     browser_accept_header?: string|null,
     * }
     */
    public function asArray(): array
    {
        return array_filter(
            [
                'ip'                          => $this->ip,
                'user_agent'                  => $this->userAgent,
                'browser_color_depth'         => $this->browserColorDepth,
                'browser_language'            => $this->browserLanguage,
                'browser_screen_height'       => $this->browserScreenHeight,
                'browser_screen_width'        => $this->browserScreenWidth,
                'browser_timezone'            => $this->browserTimezone,
                'browser_timezone_offset'     => $this->browserTimezoneOffset,
                'browser_java_enabled'        => $this->browserJavaEnabled,
                'browser_java_script_enabled' => $this->browserJavaScriptEnabled,
                'browser_accept_header'       => $this->browserAcceptHeader,
            ],
            static fn(mixed $value): bool => $value === false || !empty($value)
        );
    }
}
