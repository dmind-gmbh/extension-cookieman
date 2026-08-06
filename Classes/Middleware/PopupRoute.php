<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Serves the consent popup on the root page of the site, with the query argument
 * `?consent`, for example `https://example.com/?consent`.
 *
 * The page itself only holds a small stub. The popup is the same for all pages, so the
 * browser loads it once and then uses it from its cache. The value of the argument is
 * free: the stub puts a hash of the configuration there, so that the browser loads the
 * popup again after a change.
 *
 * This middleware only switches to the page type of the popup. The normal page rendering
 * does the rest, which keeps TypoScript, the template paths of the theme, the language
 * and the page cache of TYPO3.
 *
 * It must run before the site middleware, which makes the route result from the path. The
 * middleware keeps the path so that the language resolution still works, and it removes
 * all query arguments so that TYPO3 does not see an unknown one (cHash).
 */
class PopupRoute implements MiddlewareInterface
{
    public const ARGUMENT = 'consent';
    public const TYPE = 1365499;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!array_key_exists(self::ARGUMENT, $request->getQueryParams())) {
            return $handler->handle($request);
        }

        return $handler->handle(
            $request
                ->withUri($request->getUri()->withQuery('type=' . self::TYPE))
                ->withQueryParams(['type' => (string) self::TYPE]),
        );
    }
}
