<?php
declare(strict_types=1);

namespace Shankar\CmsHeroImage\ViewModel\Page;

use Magento\Cms\Model\Page;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Shankar\CmsHeroImage\Model\Cms\FileInfo;

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
     * @throws NoSuchEntityException|LocalizedException
     */
    public function getCmsImage() :string
    {
        $url = false;
        $image = $this->page->getCmsHeroImage();
        if ($image) {
            if (is_string($image)) {
                $store = $this->storeManager->getStore();

                $isRelativeUrl = substr($image, 0, 1) === '/';

                $mediaBaseUrl = $store->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                );

                if ($isRelativeUrl) {
                    $url = $image;
                } else {
                    $url = $mediaBaseUrl
                        . ltrim(FileInfo::ENTITY_MEDIA_PATH, '/')
                        . '/'
                        . $image;
                }
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

    /**
     * @return null|string
     */
    public function isCmsImage() :?string
    {
        return $this->page->getCmsHeroImage();
    }
}
