<?php
	include_once (__DIR__."/../service/ConfigService.php");

	class DockerClient {

		private $URL = "http://v1.24%s";
	    
	    private $curlClient;
	    private $curlError = null;

	    public function __construct(?HostEntity $hostEntity = null) {
	        $this->curlClient = curl_init();
			//curl_setopt($this->curlClient, CURLOPT_UNIX_SOCKET_PATH, self::DOCKER_SOCKET);

            if ($hostEntity == null) {
                $config = ConfigService::loadConfig();
                curl_setopt($this->curlClient, CURLOPT_UNIX_SOCKET_PATH, $config->getDockerSocketPath());
            } else {
                $this->URL = "http://".$hostEntity->getIp().":".$hostEntity->getPort()."%s";
            }

	        curl_setopt($this->curlClient, CURLOPT_RETURNTRANSFER, true);
	    }

	    public function __destruct() {
	        curl_close($this->curlClient);
	    }

	    private function generateRequestUri(string $requestPath) {
	        return sprintf($this->URL, $requestPath);
	    }
	    
	    public function dispatchCommand(string $endpoint, array $parameters = null) {
	        curl_setopt($this->curlClient, CURLOPT_URL, $this->generateRequestUri($endpoint));

	        if (!is_null($parameters)) {
	          $payload = json_encode($parameters);
	          curl_setopt($this->curlClient, CURLOPT_POSTFIELDS, $payload);          
	        }

	        $result = curl_exec($this->curlClient);

	        if ($result === FALSE) {
	            $this->curlError = curl_error($this->curlClient);
	            return array();
	        }
	        
	        return json_decode($result, true);
	    }

        public function streamData(string $endpoint, array $parameters = null) {
            curl_setopt($this->curlClient, CURLOPT_URL, $this->generateRequestUri($endpoint));


            curl_setopt($this->curlClient, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($this->curlClient, CURLOPT_WRITEFUNCTION, "myProgressFunc");
//            var_dump(curl_getinfo($this->curlClient));
//            flush();
//            ob_flush();
            $result = curl_exec($this->curlClient);
            echo $result;


            if ($result === FALSE) {
                $this->curlError = curl_error($this->curlClient);
                return array();
            }

            return json_decode($result, true);
        }

        public function downloadFile(string $endpoint) {
            curl_setopt($this->curlClient, CURLOPT_URL, $this->generateRequestUri($endpoint));


            $result = curl_exec($this->curlClient);

            if ($result === FALSE) {
                $this->curlError = curl_error($this->curlClient);
                return array();
            }

            return $result;
        }

        public function uploadFile(string $endpoint, $file) {
            curl_setopt($this->curlClient, CURLOPT_URL, $this->generateRequestUri($endpoint));
            curl_setopt($this->curlClient, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($this->curlClient, CURLOPT_RETURNTRANSFER, true);

            $filedata = $file['tmp_name'];
            $filesize = $file['size'];

            $headers = array("Content-Type: application/x-tar");
//            $postfields = http_build_query("@$filedata");

            $postfields = file_get_contents($filedata);
            //var_dump($this->curlClient);

            curl_setopt($this->curlClient, CURLOPT_HEADER, true);
            curl_setopt($this->curlClient, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($this->curlClient, CURLOPT_POSTFIELDS, $postfields);

            curl_setopt($this->curlClient, CURLOPT_INFILESIZE, $filesize);

             curl_exec($this->curlClient);
        }

	    public function postCommand(string $endpoint) {
	        curl_setopt($this->curlClient, CURLOPT_URL, $this->generateRequestUri($endpoint));
	        curl_setopt($this->curlClient, CURLOPT_CUSTOMREQUEST, "POST");
	        
			$result = curl_exec($this->curlClient);

	        if ($result === FALSE) {
	            $this->curlError = curl_error($this->curlClient);
	            return array();
	        }
	        
	        return json_decode($result, true);
	    }

	    public function deleteCommand(string $endpoint): array {
	        curl_setopt($this->curlClient, CURLOPT_URL, $this->generateRequestUri($endpoint));
	        curl_setopt($this->curlClient, CURLOPT_CUSTOMREQUEST, "DELETE");
			
			$result = curl_exec($this->curlClient);
			//var_dump($result);
	        if ($result === FALSE) {
	            $this->curlError = curl_error($this->curlClient);
	            return array();
	        }
	        
	        return json_decode($result, true);
	    }
	    
	    public function getCurlError() {
	        return is_null($this->curlError) ? false : $this->curlError;
	    }

	    public function ping() : bool {
            curl_setopt($this->curlClient, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($this->curlClient, CURLOPT_URL, $this->generateRequestUri("/_ping"));
            $result = curl_exec($this->curlClient);

            return $result == "OK";
        }
	}

    function myProgressFunc($ch, $str){
        echo $str;
        flush();
        ob_flush();
        return strlen($str);
    }
?>