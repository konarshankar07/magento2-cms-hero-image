<?php
/**
 * Copyright (c) 2019 Shankar Konar
 */
namespace Shankar\CmsHeroImage\Block\Html;

use Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;

/**
 * Class CmsImage
 * @package Shankar\CmsHeroImage\Block\Html
 */
class CmsImage extends Template
{
    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $page;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;

    
    protected $__storeManager;

    /**
     * CmsImage constructor.
     * @param Context $context
     * @param \Magento\Cms\Model\Page $page
     * @param \Magento\Framework\Filesystem $filesystem
     * @param array $data
     */
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

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCmsImage() {
        $media_url = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $media_url."cms/hero/tmp/".$this->page->getCmsHeroImage();
        return $imageUrl;
    }

    /**
     * @return bool
     */
    public function isCmsImage() {
        $isCmsImage = false;
        if($this->page->getCmsHeroImage()) {
            $isCmsImage = true;
        }
        return $isCmsImage;
    }
}
