<?php


namespace belenka\fedex\Services\Ship\Type;

/**
 * Class PackagingType
 * @package belenka\fedex\Services\Ship\Type
 */
class PackagingType
{
    const YOUR_PACKAGING = 'YOUR_PACKAGING'; // 150lbs/68KG or 70lbs/32KG
    const FEDEX_ENVELOPE = 'FEDEX_ENVELOPE'; // 1lbs/0.5KG
    const FEDEX_BOX = 'FEDEX_BOX'; // 20lbs/9KG
    const FEDEX_SMALL_BOX = 'FEDEX_SMALL_BOX'; // 20lbs/9KG
    const FEDEX_MEDIUM_BOX = 'FEDEX_MEDIUM_BOX'; // 20lbs/9KG
    const FEDEX_LARGE_BOX = 'FEDEX_LARGE_BOX'; // 20lbs/9KG
    const FEDEX_EXTRA_LARGE_BOX = 'FEDEX_EXTRA_LARGE_BOX'; // 20lbs/9KG
    const FEDEX_10KG_BOX = 'FEDEX_10KG_BOX'; // 22lbs/10KG
    const FEDEX_25KG_BOX = 'FEDEX_25KG_BOX'; // 55lbs/25KG
    const FEDEX_PAK = 'FEDEX_PAK'; // 20lbs/9KG
    const FEDEX_TUBE = 'FEDEX_TUBE'; //20lbs/9KG
}
