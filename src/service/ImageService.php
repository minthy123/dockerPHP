<?php
    include_once (__DIR__.'/../restclient/ImageClient.php');
    include_once (__DIR__.'/../model/Image.php');
    include_once (__DIR__.'/../service/LibraryService.php');

    class ImageService {

        private $imageClient;
        private $libraryService;

        public function __construct(?HostEntity $hostEntity = null)
        {
            $this->imageClient = new ImageClient($hostEntity);
            $this->libraryService = new LibraryService();
        }

        public function getImage(string $imageId): Image {
            return $this->imageClient->getImageInfo($imageId);
        }

        public function getImageWithHistories(string $imageId) : Image {
            $image = $this->getImage($imageId);
            $this->getHistoriesAndBaseImage($image);

            return $image;
        }

        private function getHistoriesAndBaseImage(Image $image) : void
        {
            if ($image->getHistories() == null) {
                $image->setHistories($this->imageClient->getImageHistory($image->getId()));
            }
        }

        public function isOSNeededGPU(Image $image) : bool {
            $this->getHistoriesAndBaseImage($image);
            var_dump($image->getBaseImageName());
            $libraryEntity = $this->libraryService->getOperatingSystem($image->getBaseImageName());

            if ($libraryEntity == null) return false;

            return $libraryEntity->getIsGPU();
        }
    }
?>