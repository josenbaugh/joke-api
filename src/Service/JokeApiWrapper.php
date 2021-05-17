<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Exception\VendorApiException;

class JokeApiWrapper
{
	/**
	 * client 
	 *
	 * @var HttpClientInterface
	 * @access private
	 */
	private $client;

	/**
	 * baseUrl 
	 *
	 * @var string
	 * @access private
	 */
	private $baseUrl;

	/**
	 * Constructor
	 *
	 * @param HttpClientInterface $client
	 * @access public
	 */
	public function __construct(HttpClientInterface $client) {
        $this->client = $client;
		$this->baseUrl = 'https://v2.jokeapi.dev/joke/Programming?format=xml';
		// $this->baseUrl = 'https://v2.jokeapi.dev/joke/Programming?blacklistFlags=nsfw,religious,political,racist,sexist,explicit&format=xml';

	} // End function Constructor
	
	/**
	 * getUrl
	 *
	 * @access public
	 * @return string
	 */
	public function getUrl(): string {
		return $this->baseUrl;
	} // End function getUrl

	/**
	 * setUrl
	 *
	 * @param string $url
	 * @access public
	 * @return string
	 */
	public function setUrl($url): string {
		$this->baseUrl = $url;
		return $this->baseUrl;
	} // End function setUrl

    /**
     * getExternalDevJoke
	 *
	 * This function goes to the external api and checks the response, throwing
	 * appropriate exceptions to be handled by the controller
     *
     * @access public
	 * @throws VendorApiException
     * @return array
     */
    public function getExternalDevJoke(): array
    {
		// attempt to make request to vendor any \excpetion level errors will
		// bubble up to controller and be caught and logged
		$response = $this->client->request(
			'GET', $this->baseUrl
		);

		// verify our response has correct HTTP code and content type
        $statusCode = $response->getStatusCode();
		if ($statusCode != 200) throw new VendorApiException("Vendor returned non OK response $statusCode", Response::HTTP_INTERNAL_SERVER_ERROR);
        $contentType = $response->getHeaders()['content-type'][0];
		if ($contentType != 'application/xml; charset=UTF-8') throw new VendorApiException("Vendor returned unexpected content type $contentType", Response::HTTP_INTERNAL_SERVER_ERROR);

		// convert xml to an associative array by loading it to a simplexml
		// object then json encode and decode
		// probably isn't the most efficient for this use but if I wanted the
		// whole response to leave this function it's a quick way to convert
		$xml = simplexml_load_string($response->getContent(), "SimpleXMLElement", LIBXML_NOCDATA);
		$json = json_encode($xml);
		$content = json_decode($json,TRUE);

		// verify the error flag passed in a good server response
		if ($content['error'] == "true") throw new VendorApiException("Vendor returned error response", Response::HTTP_INTERNAL_SERVER_ERROR);

        return $content;

    } // End function getExternalDevJoke


}
