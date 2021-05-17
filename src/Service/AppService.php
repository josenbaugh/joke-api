<?php

namespace App\Service;

use App\Service\JokeApiWrapper;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ApiConfiguration;

class AppService
{

	/**
	 * jokeService 
	 *
	 * @var JokeApiWrapper
	 * @access private
	 */
	private $jokeService;

	/**
	 * em 
	 *
	 * @var EntityManagerInterface
	 * @access private
	 */
	private $em;

	/**
	 * configRepo 
	 *
	 * @var ApiConfigurationRepository
	 * @access private
	 */
	private $configRepo;

	/**
	 * Constructor
	 *
	 * @param JokeApiWrapper $jokeService
	 * @param EntityManagerInterface $entityManager
	 * @access public
	 */
	public function __construct(JokeApiWrapper $jokeService, EntityManagerInterface $entityManager) {
		$this->jokeService = $jokeService;
		$this->em = $entityManager;
		$this->configRepo = $this->em->getRepository(ApiConfiguration::class);
	} // End function Constructor

    /**
     * getJoke
     *
     * @access public
	 * @throws VendorApiException
     * @return array
     */
    public function getJoke(): array
    {
		$this->applyBlacklist($this->jokeService);

		$joke = $this->jokeService->getExternalDevJoke();

        return $joke;
    } // End function getJoke

	/**
	 * applyBlacklist
	 *
	 * access the database to check what blacklist parameters to use
	 * this allows these to be changed without code changes
	 *
	 * @param JokeApiWrapper $jokeService
	 * @access private
	 * @return void
	 */
	private function applyBlacklist($jokeService): void {
		// Ideally I'd do it this way with the ORM but it's not working
		// TODO fix the orm....
		// $blacklistparams = $this->configRepo->findBy(['Type' => 'blacklist']);

		$sql = "select * from ApiConfiguration where Type = 'blacklist';";
		$stmt = $this->em->getConnection()->prepare($sql);
		$stmt->execute();
		$blacklistitems = $stmt->fetchAll();

		//items marked in the database false will be blocked so filter out those
		$itemstoexclude = array_filter($blacklistitems, function($v, $k) {
			return $k='Value' && $v='false'; }, ARRAY_FILTER_USE_BOTH);

		//grab the names of the items we want to exclude
		$queryparams = '&blacklistFlags=' . implode(',', array_column($itemstoexclude, 'Name'));

		//apply to the query params in the vendor service
		$jokeService->setUrl($jokeService->getUrl() . $queryparams);
	} // End function applyBlacklist
}
