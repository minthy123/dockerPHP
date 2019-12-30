<?php
    class ImageHistory {
        private $id;
        private $createdSince;
        private $createdBy;
        private $size;
        private $comment;
        private $tag;
        private $isNullId;

        public function __construct()
        {
        }

        public static function fromJSONObject($obj){
            $instance = new self();
            $instance->setComment($obj['Comment']);
            $instance->setCreatedSince($obj['Created']);
            $instance->setCreatedBy($obj['CreatedBy']);
            $instance->setSize($obj['Size']);
            if (strpos($obj['Id'], 'sha256:') !== false) {
                $instance->setId(str_replace("sha256:", "", $obj['Id']));
                $instance->setIsNullId(false);
            } else {
                $instance->setIsNullId(true);
            }


            if ($obj['Tags'] != null && !empty($obj['Tags'])) {
                $instance->setTag($obj['Tags'][0]);
            }


            return $instance;
        }

        /**
         * @return mixed
         */
        public function getIsNullId()
        {
            return $this->isNullId;
        }

        /**
         * @param mixed $isNullId
         */
        public function setIsNullId($isNullId): void
        {
            $this->isNullId = $isNullId;
        }



        /**
         * @return mixed
         */
        public function getTag()
        {
            return $this->tag;
        }

        /**
         * @param mixed $tag
         */
        public function setTag($tag): void
        {
            $this->tag = $tag;
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