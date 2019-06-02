<?php
/**
 * Copyright (c) 2019 Shankar Konar
 */

namespace Shankar\CmsHeroImage\Model\Cms\Page;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Cms\Model\Page\DataProvider
{

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $page = "";
        $items = $this->collection->getItems();
        /** @var $page \Magento\Cms\Model\Page */
        foreach ($items as $page) {
            $this->loadedData[$page->getId()] = $page->getData();
        }

        $data = $this->dataPersistor->get('cms_page');

        if (!empty($data)) {
            $page = $this->collection->getNewEmptyItem();

            $page->setData($data);
            $this->loadedData[$page->getId()] = $page->getData();
            $this->dataPersistor->clear('cms_page');
        }
        /* For Modify  You custom image field data */
        if( !empty($page) ) {
            if(!empty($this->loadedData[$page->getId()]['cms_hero_image'])){
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
                $currentStore = $storeManager->getStore();
                $media_url=$currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

                $image_name=$this->loadedData[$page->getId()]['cms_hero_image'];
                unset($this->loadedData[$page->getId()]['cms_hero_image']);
                $this->loadedData[$page->getId()]['cms_hero_image'][0]['name']=$image_name;
                $this->loadedData[$page->getId()]['cms_hero_image'][0]['url']=$media_url."cms/hero/tmp/".$image_name;
                $this->loadedData[$page->getId()]['cms_hero_image'][0]['image_path'] = array(
                    array(
                        'name'  =>  $image_name,
                        'url'   =>  $media_url."cms/hero/tmp/".$image_name // Should return a URL to view the image. For example, http://domain.com/pub/media/../../imagename.jpeg
                    )
                );
            }
        }
        return $this->loadedData;
    }
}