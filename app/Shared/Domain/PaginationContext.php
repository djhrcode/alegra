<?php

namespace App\Shared\Domain;

use Illuminate\Support\Facades\Route;
use League\Fractal\Pagination\PaginatorInterface;

final class PaginationContext implements PaginatorInterface
{
    public function __construct(
        private int $perPage,
        private int $total,
        private int $totalPages,
        private int $currentPage
    ) {
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getLastPage()
    {
        return $this->totalPages;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getCount()
    {
        return $this->total;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getUrl($page)
    {
        return route(Route::currentRouteName(), [ 'page' => $page ]);
    }
}
