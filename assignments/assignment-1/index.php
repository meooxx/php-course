<?php
require_once 'apiModel.php';
$dogModel = new DogModel('/images/search');
/**
 * respond = [{
 *  "species_id": string,
		"id": string,
		"url": string,  // url
		"width": number,
		"height": number,
		"categories": [{
			"name": string,
			"species_id": string,
			"id": string
		}]
 *  ...
 * }]
 */
// search for 10 medium sized labradors
// id of labrador breed is 149, bay retriever is 76
$labradorRecords = $dogModel->get("include_breeds=true&limit=4&size=med&breed_id=149");
// error_log(json_encode($labradorRecords));
$bayRetrieverRecords = $dogModel->get("include_breeds=true&limit=4&breed_id=76");
// error_log(json_encode($bayRetrieverRecords));
$result = array_merge($labradorRecords, $bayRetrieverRecords);
require_once "views/dogs.view.php";

?>