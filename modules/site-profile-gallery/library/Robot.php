<?php
/**
 * Robot
 * @package site-profile-gallery
 * @version 0.0.1
 */

namespace SiteProfileGallery\Library;

use Profile\Model\Profile;
use ProfileGallery\Model\ProfileGallery as PGallery;

class Robot
{
	static private function getPages(): ?array{
        $cond = [
            'updated' => ['__op', '>', date('Y-m-d H:i:s', strtotime('-2 days'))]
        ];
        $pages = PGallery::get($cond);
        if(!$pages)
            return null;

        $profiles = array_column($pages, 'profile');
        $profiles = Profile::get(['id'=>$profiles]);
        $profiles = prop_as_key($profiles, 'id');

        foreach($pages as &$page)
        	$page->profile = $profiles[$page->profile];
        unset($page);

        return $pages;
    }

    static function feed(): array {
        $mim = &\Mim::$app;

        $pages = self::getPages();
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route = $mim->router->to('siteProfileGallery', ['id'=>$page->id,'profile'=>$page->profile->name]);
            $title = $page->title;
            $desc  = $page->title;

            $result[] = (object)[
                'description'   => $desc,
                'page'          => $route,
                'published'     => $page->created,
                'updated'       => $page->updated,
                'title'         => $title,
                'guid'          => $route
            ];
        }

        return $result;
    }

    static function sitemap(): array {
        $mim = &\Mim::$app;

        $pages = self::getPages();
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route  = $mim->router->to('siteProfileGallery', ['id'=>$page->id,'profile'=>$page->profile->name]);
            $result[] = (object)[
                'page'          => $route,
                'updated'       => $page->updated,
                'priority'      => '0.4',
                'changefreq'    => 'monthly'
            ];
        }

        return $result;
    }
}