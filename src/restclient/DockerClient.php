<?php
	class DockerClient {

		private const DOCKER_SOCKET = "/var/run/docker.sock";
		private const URL = "http://v1.24%s";
	    
	    private $curlClient;
	    private $socketPath;
	    private $curlError = null;

	    public function __construct() {
	        $this->curlClient = curl_init();
	        curl_setopt($this->curlClient, CURLOPT_UNIX_SOCKET_PATH, self::DOCKER_SOCKET);
	        curl_setopt($this->curlClient, CURLOPT_RETURNTRANSFER, true);
	    }

	    public function __destruct() {
	        curl_close($this->curlClient);
	    }

	    private function generateRequestUri(string $requestPath) {
	        return sprintf(self::URL, $requestPath);
	    }
	    
	    public function dispatchCommand(string $endpoint, array $parameters = null): array {
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

	    public function postCommand(string $endpoint) {
	        curl_setopt($this->curlClient, CURLOPT_URL, $this->generateRequestUri($endpoint));
	        curl_setopt($this->curlClient, CURLOPT_CUSTOMREQUEST, "POST");
	        
			$result = curl_exec($this->curlClient);
			//var_dump($result);

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

	    public function getAllImage() {
	    	return $this->dispatchCommand('/images/json');
	    }
	}
?>