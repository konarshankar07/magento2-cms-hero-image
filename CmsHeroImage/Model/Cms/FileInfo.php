<?php declare(strict_types=1);

namespace Shankar\CmsHeroImage\Model\Cms;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;

/**
 * Class FileInfo
 *
 * Provides information about requested file
 */
class FileInfo
{
    /**
     * Path in /pub/media directory
     */
    const ENTITY_MEDIA_PATH = '/cms/hero/image';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Mime
     */
    private $mime;

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;

    /**
     * @param Filesystem $filesystem
     * @param Mime $mime
     */
    public function __construct(
        Filesystem $filesystem,
        Mime $mime
    ) {
        $this->filesystem = $filesystem;
        $this->mime = $mime;
    }

    /**
     * Get WriteInterface instance
     *
     * @return WriteInterface
     * @throws FileSystemException
     */
    private function getMediaDirectory(): WriteInterface
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }
        return $this->mediaDirectory;
    }

    /**
     * Retrieve MIME type of requested file
     *
     * @param string $fileName
     * @return string
     * @throws FileSystemException
     */
    public function getMimeType($fileName): string
    {
        $filePath = self::ENTITY_MEDIA_PATH . '/' . ltrim($fileName, '/');
        $absoluteFilePath = $this->getMediaDirectory()->getAbsolutePath($filePath);

        $result = $this->mime->getMimeType($absoluteFilePath);
        return $result;
    }

    /**
     * Get file statistics data
     *
     * @param string $fileName
     * @return array
     * @throws FileSystemException
     */
    public function getStat($fileName): array
    {
        $filePath = self::ENTITY_MEDIA_PATH . '/' . ltrim($fileName, '/');

        $result = $this->getMediaDirectory()->stat($filePath);
        return $result;
    }

    /**
     * Check if the file exists
     *
     * @param string $fileName
     * @return bool
     * @throws FileSystemException
     */
    public function isExist($fileName): bool
    {
        $filePath = self::ENTITY_MEDIA_PATH . '/' . ltrim($fileName, '/');

        $result = $this->getMediaDirectory()->isExist($filePath);
        return $result;
    }
}
