<?php

namespace Knock\KnockSdk\HttpClient\Utils;

use function count;
use League\Uri\Components\Query;
use function sprintf;

final class QueryStringBuilder
{
    /**
     * Encode a query as a query string according to RFC 3986.
     *
     * @param array $query
     * @return string
     */
    public static function build(array $query): string
    {
        if (0 === count($query)) {
            return '';
        }

        return sprintf('?%s', Query::createFromParams($query));
    }
}
