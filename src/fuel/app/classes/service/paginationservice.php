<?php

use Fuel\Core\Pagination;
use Fuel\Core\Uri;

class Service_PaginationService
{
    /**
     * CREATE PAGINATION
     */
    public static function forge($name,$url,$total_items,$per_page,$uri_segment = 4,$query = []) {
        return Pagination::forge($name, [
            'pagination_url' => Uri::create($url),
            'total_items' => $total_items,
            'per_page' => $per_page,
            'uri_segment' => $uri_segment,
            'link_offset' => $query
                ? '?' . http_build_query($query)
                : '',
            'wrapper' => '
                <div class="pagination">
                    {pagination}
                </div>
            ',
            'active' => '
                <span class="active">
                    {link}
                </span>
            ',
            'regular' => '
                <span>
                    {link}
                </span>
            ',
            'previous' => '
                <span>
                    {link}
                </span>
            ',
            'next' => '
                <span>
                    {link}
                </span>
            ',
            'previous-inactive' => '
                <span class="previous-inactive">
                    {link}
                </span>
            ',
            'next-inactive' => '
                <span class="next-inactive">
                    {link}
                </span>
            ',
        ]);
    }
}
