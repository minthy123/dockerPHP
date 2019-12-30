<?php
    require_once(__DIR__.'/../model/Image.php');
    require_once(__DIR__.'/../model/ImageHistory.php');
    require_once('DockerClient.php');

    class ImageClient {
        private $dockerClient;

        private const KILL_IMAGE_COMMAND = '/images/%s';
        private const LIST_ALL_IMAGES = '/images/json';
        private const IMAGE_INFO = '/images/%s/json';
        private const IMAGE_HISTORY = '/images/%s/history';

        public function __construct(?HostEntity $hostEntity = null) {
            $this->dockerClient = new DockerClient($hostEntity);
        }

        public function getAllImages() {
            $result = [];
            $jsonArray = $this->dockerClient->dispatchCommand(self::LIST_ALL_IMAGES);
            foreach ($jsonArray as $key=>$json) {
                array_push($result, Image::fromJSONObject($json));
            }

            return $result;
        }

        public function countImages(){
            $result = self::getAllImages();

            return count($result);
        }

        public function getImageInfo($imageId) : Image{
            $json = $this->dockerClient->dispatchCommand(
                sprintf(self::IMAGE_INFO, $imageId));

            return Image::fromJSONDetail($json);
        }

        public function getImageHistory(string $imageId) : array {
            $result = [];

            $jsonArray = $this->dockerClient->dispatchCommand(
                sprintf(self::IMAGE_HISTORY, $imageId));

            foreach ($jsonArray as $key=>$json) {
                array_push($result, ImageHistory::fromJSONObject($json));
            }

            return $result;
        }

        public function deleteImage($id) {
            $this->dockerClient->deleteCommand(
                sprintf(self::KILL_IMAGE_COMMAND, $id));
        }
	
    }
?>