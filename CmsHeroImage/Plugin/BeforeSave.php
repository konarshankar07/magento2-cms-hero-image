<?php declare(strict_types=1);

namespace Shankar\CmsHeroImage\Plugin;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Model\PageRepository;
use Psr\Log\LoggerInterface;
use Shankar\CmsHeroImage\HeroimageUpload;
use Shankar\CmsHeroImage\Model\ImageUploader;

class BeforeSave
{
    /**
     * @var ImageUploader
     */
    private $imageUploader;

    /**
     * @var LoggerInterface
     */
    private $_logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }

    public function beforeSave(PageRepository $subject, PageInterface $page)
    {
        $data = $page->getData();
        if (isset($data['cms_hero_image']) && is_array($data['cms_hero_image'])) {
            $imageName = $data['cms_hero_image'][0]['name'];
            $page->setCmsHeroImage($imageName);
        }
    }

    public function afterSave(PageRepository $subject, PageInterface $page)
    {
        $data = $page->getData();
        if (isset($data['cms_hero_image'])) {
            try {
                $this->getImageUploader()->moveFileFromTmp($data['cms_hero_image']);
            } catch (\Exception $e) {
                $this->_logger->critical($e);
            }
        }
    }

    private function getImageUploader()
    {
        if ($this->imageUploader === null) {
            $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(HeroimageUpload::class);
        }

        return $this->imageUploader;
    }
}
