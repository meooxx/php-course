<?php
require_once "config.php";

class DogModel
{

	private $path = "";
	public function __construct($endPoint)
	{
		$this->path = DOG_API_BASE_URL . $endPoint;

	}
	public function get($query)
	{
		// include the API key in the request header
		$options = [
			"http" => [
				"method" => "GET",
				"header" => [
					"X-API-KEY: " . DOG_API_KEY,
				]
			]
		];
		$url = $this->path . "?" . $query;
		error_log("url: " . $url);
		// error_log("params: " . json_encode($options));
		$rawJsonString = @file_get_contents($url, false, stream_context_create($options));
		if ($rawJsonString === false) {
			return [];
		}
		return json_decode($rawJsonString);
	}

}

?>