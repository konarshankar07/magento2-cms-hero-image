<?php
declare(strict_types=1);

namespace Shankar\CmsHeroImage\ViewModel\Page;

use Magento\Cms\Model\Page;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class responsible for getting CMS hero image data
 */
class GetHeroImage implements ArgumentInterface
{
    /**
     * @var Page
     */
    protected $page;

    /**
     * @var UrlInterface
     */
    protected $url;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * CmsImage constructor.
     * @param Page $page
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Page $page,
        StoreManagerInterface $storeManager
    ) {
        $this->page = $page;
        $this->storeManager = $storeManager;
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getCmsImage() :string
    {
        $media_url = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $media_url . "cms/hero/image/" . $this->page->getCmsHeroImage();
        return $imageUrl;
    }

    /**
     * @return null|string
     */
    public function isCmsImage() :?string
    {
        return $this->page->getCmsHeroImage();
    }
}
