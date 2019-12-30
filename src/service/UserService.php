<?php
    include_once (__DIR__."/../entity/UserEntity.php");
    include_once (__DIR__."/../dao/UserDao.php");

    class UserService {
        private $userDao;

        public function __construct() {
            $this->userDao = new UserDao();
        }

        public function checkValidUser(string $username, string $password) : bool {
            return $this->checkSessionKey(self::createKey($username, $password));
        }

        public function checkSessionKey(string $key) : bool {
            $users = $this->userDao->getAll();

            foreach ($users as $user) {
                if (self::createKey($user->getUsername(), $user->getPassword()) == $key) {
                    return true;
                }
            }

            return false;
        }

        public static function createKey(string $username, string $password) {
            return md5($username.' '.$password);
        }
    }

?>