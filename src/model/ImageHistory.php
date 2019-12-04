<?php
    class ImageHistory {
        private $id;
        private $createdSince;
        private $createdBy;
        private $size;
        private $comment;

        public function __construct()
        {
        }

        public static function fromJSONObject($obj){
            $instance = new self();
            $instance->setComment($obj['comment']);
            $instance->setCreatedSince($obj['Created']);
            $instance->setCreatedBy($obj['CreatedBy']);
            $instance->setSize($obj['Size']);
            $instance->setId(str_replace("sha256:", "", $obj['Id']));

            return $instance;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getCreatedSince()
        {
            return $this->createdSince;
        }

        /**
         * @param mixed $createdSince
         */
        public function setCreatedSince($createdSince)
        {
            $this->createdSince = $createdSince;
        }

        /**
         * @return mixed
         */
        public function getCreatedBy()
        {
            return $this->createdBy;
        }

        /**
         * @param mixed $createdBy
         */
        public function setCreatedBy($createdBy)
        {
            $this->createdBy = $createdBy;
        }

        /**
         * @return mixed
         */
        public function getSize()
        {
            return $this->size;
        }

        /**
         * @param mixed $size
         */
        public function setSize($size)
        {
            $this->size = $size;
        }

        /**
         * @return mixed
         */
        public function getComment()
        {
            return $this->comment;
        }

        /**
         * @param mixed $comment
         */
        public function setComment($comment)
        {
            $this->comment = $comment;
        }


    }
?>