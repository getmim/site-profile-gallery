<?php
/**
 * GalleryController
 * @package site-profile-gallery
 * @version 0.0.1
 */

namespace SiteProfileGallery\Controller;

use SiteProfileGallery\Library\Meta;
use Profile\Model\Profile;
use LibFormatter\Library\Formatter;
use ProfileGallery\Model\ProfileGallery as PGallery;

class GalleryController extends \Site\Controller
{
	public function singleAction(){
		$name = $this->req->param->profile;

        $profile = Profile::getOne(['name'=>$name]);
        if(!$profile)
            return $this->show404();

        $profile = Formatter::format('profile', $profile);

        $id = $this->req->param->id;
        $gallery = PGallery::getOne(['id'=>$id,'profile'=>$profile->id]);
        if(!$gallery)
        	return $this->show404();

        $gallery = Formatter::format('profile-gallery', $gallery, ['profile']);
        
        $params = [
            'profile' => $profile,
            'meta'    => Meta::single($profile, $gallery),
            'gallery' => $gallery,
        ];

        $this->res->render('profile/gallery/single', $params);
        // $this->res->setCache(86400);
        $this->res->send();
	}
}