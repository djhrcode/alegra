<?php

namespace App\Images\Domain;

interface ImageRepository
{
    public function search(ImageSearchCriteria $criteria): ImageCollection;
}
