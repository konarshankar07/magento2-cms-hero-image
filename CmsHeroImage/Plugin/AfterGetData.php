<?php

declare(strict_types=1);

namespace Shankar\CmsHeroImage\Plugin;

use Magento\Cms\Model\Page\DataProvider;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Shankar\CmsHeroImage\Model\Cms\FileInfo;

/**
 * Class responsible for setting data for the data provider
 */
class AfterGetData
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var FileInfo
     */
    private $fileInfo;

    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    public function afterGetData(DataProvider $subject, $result): array
    {
        $heroImageWrapper = [];
        if (!$result) {
            return [];
        }
        foreach ($result as $individual) {
            $image_name = $individual['cms_hero_image'];
            if ($image_name && $this->getFileInfo()->isExist($image_name)) {
                $media_url = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
                unset($individual['cms_hero_image']);
                $stat = $this->getFileInfo()->getStat($image_name);
                $mime = $this->getFileInfo()->getMimeType($image_name);
                $heroImageWrapper[$individual['page_id']]['cms_hero_image'][0]['name'] = basename($image_name);
                if ($this->getFileInfo()->isBeginsWithMediaDirectoryPath($image_name)) {
                    $heroImageWrapper[$individual['page_id']]['cms_hero_image'][0]['url'] = $image_name;
                } else {
                    $heroImageWrapper[$individual['page_id']]['cms_hero_image'][0]['url']
                        = $media_url . FileInfo::ENTITY_MEDIA_PATH . '/' . $image_name;
                }
                $heroImageWrapper[$individual['page_id']]['cms_hero_image'][0]['size']
                    = isset($stat) ? $stat['size'] : 0;
                $heroImageWrapper[$individual['page_id']]['cms_hero_image'][0]['type'] = $mime;
            }
        }
        foreach ($heroImageWrapper as $pageId => $heroImageProvider) {
            $result[$pageId]['cms_hero_image'] = $heroImageProvider['cms_hero_image'];
        }
        return $result;
    }

    /**
     * Get FileInfo instance
     *
     * @return FileInfo
     */
    private function getFileInfo(): FileInfo
    {
        if ($this->fileInfo === null) {
            $this->fileInfo = ObjectManager::getInstance()->get(FileInfo::class);
        }
        return $this->fileInfo;
    }
}
