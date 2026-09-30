<?php

namespace Knock\KnockSdk\HttpClient\Utils;

use function array_is_list;
use function array_merge;
use function count;
use function is_array;
use function is_bool;

use League\Uri\Components\Query;

use function sprintf;

final class QueryStringBuilder
{
    /**
     * Encode a query as a query string according to RFC 3986.
     *
     * Lists of scalars are encoded as `key[]=value`, lists of arrays as `key[0][child]=value`
     * and associative arrays as `key[child]=value`, matching what the Knock API's Plug parser expects.
     *
     * @param array $query
     * @return string
     */
    public static function build(array $query): string
    {
        $pairs = self::toPairs($query);

        if (0 === count($pairs)) {
            return '';
        }

        return sprintf('?%s', Query::fromPairs($pairs));
    }

    /**
     * @param array $params
     * @param string|null $prefix
     * @return array<int, array{0: string, 1: string}>
     */
    private static function toPairs(array $params, ?string $prefix = null): array
    {
        $pairs = [];
        $isScalarList = array_is_list($params) && ! is_array($params[0] ?? null);

        foreach ($params as $key => $value) {
            if (null === $value) {
                continue;
            }

            if (null === $prefix) {
                $name = (string) $key;
            } elseif ($isScalarList) {
                $name = sprintf('%s[]', $prefix);
            } else {
                $name = sprintf('%s[%s]', $prefix, $key);
            }

            if (is_array($value)) {
                $pairs = array_merge($pairs, self::toPairs($value, $name));

                continue;
            }

            $pairs[] = [$name, self::toString($value)];
        }

        return $pairs;
    }

    /**
     * @param mixed $value
     * @return string
     */
    private static function toString($value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return (string) $value;
    }
}
