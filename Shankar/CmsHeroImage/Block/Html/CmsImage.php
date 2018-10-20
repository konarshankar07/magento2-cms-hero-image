<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Shankar\CmsHeroImage\Block\Html;

use Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;

class CmsImage extends Template
{
    protected $page;

    protected $_filesystem;

    public function __construct(
        Context $context,
        \Magento\Cms\Model\Page $page,
        \Magento\Framework\Filesystem $filesystem,
        array $data = []
    ) {
        $this->page = $page;
        $this->_filesystem = $filesystem;
        parent::__construct($context, $data);
    }

    public function getCmsImage() {
        $media_url = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $media_url."cms/hero/tmp/".$this->page->getCmsHeroImage();
        return $imageUrl;
    }

    public function isCmsImage() {
        $isCmsImage = false;
        if($this->page->getCmsHeroImage()) {
            $isCmsImage = true;
        }
        return $isCmsImage;
    }
}
