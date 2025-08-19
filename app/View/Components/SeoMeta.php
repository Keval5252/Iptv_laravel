<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Services\SeoService;

class SeoMeta extends Component
{
    public $title;
    public $description;
    public $keywords;
    public $author;
    public $robots;
    public $ogTitle;
    public $ogDescription;
    public $ogType;
    public $ogUrl;
    public $ogImage;
    public $twitterCard;
    public $twitterTitle;
    public $twitterDescription;
    public $twitterImage;
    public $canonical;
    public $structuredData;

    public function __construct(
        $title = null,
        $description = null,
        $keywords = null,
        $author = null,
        $robots = null,
        $ogTitle = null,
        $ogDescription = null,
        $ogType = null,
        $ogUrl = null,
        $ogImage = null,
        $twitterCard = null,
        $twitterTitle = null,
        $twitterDescription = null,
        $twitterImage = null,
        $canonical = null,
        $structuredData = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->author = $author;
        $this->robots = $robots;
        $this->ogTitle = $ogTitle;
        $this->ogDescription = $ogDescription;
        $this->ogType = $ogType;
        $this->ogUrl = $ogUrl;
        $this->ogImage = $ogImage;
        $this->twitterCard = $twitterCard;
        $this->twitterTitle = $twitterTitle;
        $this->twitterDescription = $twitterDescription;
        $this->twitterImage = $twitterImage;
        $this->canonical = $canonical;
        $this->structuredData = $structuredData;
    }

    public function render()
    {
        return view('components.seo-meta');
    }
}
