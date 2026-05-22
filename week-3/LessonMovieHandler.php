<?php 
	/**
	 * lesson movie handler
	 * this is the blueprint for the API fetches
	 * 
	 * @author Shaoqiu
	 * 
	 */

	class LessonMovieHandler {
		private $targetUrl;
		private $securityKey;
		public function __construct($incomingUrl, $incomingKey) {
			$this->targetUrl = $incomingUrl;
			$this->securityKey = $incomingKey;
		}
		/**
		 * this pull the movie dataset from the api
		 * 
		 */
		public function fetchCurrentPopular($selectedPage = 1){

			// constructing the string  with newly assigned class property
			$endPoint = "{$this->targetUrl}/movie/popular?api_key={$this->securityKey}&language=en-US&page=" . intval($selectedPage);
			$rawJsonString = @file_get_contents($endPoint);
			
			if($rawJsonString === false) {
				return [];
			}
			$decodedData = json_decode($rawJsonString);
			$results = $decodedData->results ?? [];

			return $results;
			
			


		}
		




		




	}




?>