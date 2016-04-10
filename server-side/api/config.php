<?php
    // Basic configuration class
    class Config {

        private $IMAGE_PATH = '/home/juanjo/Dev/ImageThread/front/images';
        private $MAX_FILE_SIZE = '2097152'; // 2MB

        public function getImagePath() {
            return $this->IMAGE_PATH;
        }
        public function getMaxFileSize() {
            return $this->MAX_FILE_SIZE;
        }
    }
?>
