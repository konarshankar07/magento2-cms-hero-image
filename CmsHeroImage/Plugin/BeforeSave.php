<?php declare(strict_types=1);

namespace Shankar\CmsHeroImage\Plugin;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Model\PageRepository;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
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
    private $logger;
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * BeforeSave constructor.
     * @param LoggerInterface $logger
     * @param Filesystem $filesystem
     */
    public function __construct(
        LoggerInterface $logger,
        Filesystem $filesystem
    ) {
        $this->logger = $logger;
        $this->filesystem = $filesystem;
    }

    public function beforeSave(PageRepository $subject, PageInterface $page) :void
    {
        $cmsHeroImage = $page->getCmsHeroImage();
        if ($this->isTmpFileAvailable($cmsHeroImage) && $imageName = $this->getUploadedImageName($cmsHeroImage)) {
            $imageName = $cmsHeroImage[0]['name'];
        } elseif ($this->fileResidesOutsideCategoryDir($cmsHeroImage)) {
            // phpcs:ignore Magento2.Functions.DiscouragedFunction
            $value[0]['url'] = parse_url($cmsHeroImage[0]['url'], PHP_URL_PATH);
            $imageName = $value[0]['url'];
        }
        $page->setCmsHeroImage($imageName);
    }

    public function afterSave(PageRepository $subject, PageInterface $page) :void
    {
        $cmsHeroImage = $page->getCmsHeroImage();
        if (isset($cmsHeroImage)) {
            try {
                $this->getImageUploader()->moveFileFromTmp($cmsHeroImage);
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }
    }

    private function getImageUploader() :ImageUploader
    {
        if ($this->imageUploader === null) {
            $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(HeroimageUpload::class);
        }

        return $this->imageUploader;
    }

    /**
     * Check if temporary file is available for new image upload.
     *
     * @param array $value
     * @return bool
     */
    private function isTmpFileAvailable(array $value)
    {
        return is_array($value) && isset($value[0]['tmp_name']);
    }

    /**
     * Gets image name from $value array.
     *
     * Will return empty string in a case when $value is not an array.
     *
     * @param array $value Attribute value
     * @return string
     */
    private function getUploadedImageName(array $value)
    {
        if (is_array($value) && isset($value[0]['name'])) {
            return $value[0]['name'];
        }

        return '';
    }

    /**
     * Check for file path resides outside of category media dir. The URL will be a path including pub/media if true
     *
     * @param array|null $value
     * @return bool
     */
    private function fileResidesOutsideCategoryDir(?array $value): bool
    {
        if (!is_array($value) || !isset($value[0]['url'])) {
            return false;
        }

        $fileUrl = ltrim($value[0]['url'], '/');
        $baseMediaDir = $this->filesystem->getUri(DirectoryList::MEDIA);

        if (!$baseMediaDir) {
            return false;
        }

        return strpos($fileUrl, $baseMediaDir) !== false;
    }
}
