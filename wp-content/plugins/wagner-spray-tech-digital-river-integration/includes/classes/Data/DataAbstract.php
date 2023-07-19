<?php
/**
 * Wagner Spray Tech Digital River Integration Data Functionality
 *
 * @package WagnerSprayTechDigitalRiverIntegration\Data
 */

namespace WagnerSprayTechDigitalRiverIntegration\Data;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WagnerSprayTechCore\BaseAbstract;


/**
 * Connect to Digital River and transform data ready for WordPress.
 */
abstract class DataAbstract extends BaseAbstract {

	const TOKEN_END_POINT = 'https://api.digitalriver.com/v1/shoppers/token';


	const MAX_PAGE_SIZE = 50;


	/**
	 * Guzzle Client.
	 *
	 * @var Client
	 */
	public $client;


	/**
	 * Which endpoint type to get.
	 *
	 * @var string
	 */
	public string $type = '';


	/**
	 * Custom arguments array.
	 *
	 * @var array
	 */
	public array $custom_args = [];


	/**
	 * Total results count.
	 *
	 * @var int
	 */
	public int $total_results = 0;


	/**
	 * Total results pages.
	 *
	 * @var int
	 */
	public int $total_pages = 0;


	/**
	 * Available API keys.
	 *
	 * @var array|string[]
	 */
	private array $api_keys = [
		'Wagner' => '3da4cd857f714d1b8bd97048736a3804',
	];


	/**
	 * API endpoint.
	 *
	 * @var string
	 */
	public string $api_endpoint = '';


	/**
	 * Add the guzzle client as a variable.
	 */
	public function __construct() {

		parent::__construct();
		$this->client = new Client();
	}


	/**
	 * Get a single item by id.
	 *
	 * @param string $id The id to look for.
	 *
	 * @return array
	 * @throws GuzzleException On connection error.
	 */
	public function get_single( string $id ): array {

		$rtn = [];

		try {
			$req = $this->get_request( $this->api_endpoint . '/' . $id, $this->get_args() );
			$rtn = $this->transform_single( $this->get_array_from_response( $req ) );

		} catch ( \Exception $e ) {
			$message = 'Error getting Digital River Token: ' . $e->getMessage();
			error_log( $message ); // phpcs:ignore
			echo esc_html( $message );
		}

		return $rtn;
	}

	/**
	 *  Abstract request getter.
	 *
	 * @param string $base_uri Base URI.
	 * @param array  $args Request arguments.
	 *
	 * @return ResponseInterface|null
	 * @throws GuzzleException On connection error.
	 */
	public function get_request( string $base_uri, array $args = [] ): ?ResponseInterface {

		if ( empty( $base_uri ) ) {
			return null;
		}

		$args = ( ! empty( $args ) ) ? $args : $this->get_args();

		return $this->client->request(
			'GET',
			$base_uri,
			$args
		);
	}


	/**
	 * Convert JSON response into php array.
	 *
	 * @param ResponseInterface|null $response Response object.
	 *
	 * @return array
	 */
	public function get_array_from_response( ?ResponseInterface $response ): array {

		if ( empty( $response ) ) {
			return [];
		}

		$response = $response->getBody()->getContents();
		if ( empty( $response ) ) {
			return [];
		}
		return json_decode( $response, true ) ?? [];
	}

	/**
	 * Return default arguments for each request.
	 *
	 * @throws GuzzleException On token error.
	 */
	protected function get_args(): array {

		return array_merge_recursive(
			[
				'headers' => [
					'Authorization' => 'Bearer ' . $this->get_token(),
				],
				'query'   => [
					'format' => 'json',
				],
			],
			$this->custom_args,
		);
	}

	/**
	 * Get the bearer token.
	 *
	 * @throws GuzzleException On token error.
	 */
	private function get_token(): string {

		$transient_name = 'dr_bearer_token';
		$rtn            = get_transient( $transient_name ) ?? '';

		if ( ! empty( $rtn ) ) {
			return $rtn;
		}

		try {
			$req = $this->get_request(
				self::TOKEN_END_POINT,
				[
					'headers' => [
						'apiKey' => $this->api_keys['Wagner'],
						'Accept' => 'application/xml',
					],
					'query'   => [
						'format'   => 'json',
						'pageSize' => self::MAX_PAGE_SIZE,
					],
				]
			);

			$response = json_decode( $req->getBody()->getContents(), true );
			if ( ! empty( $response['access_token'] ) ) {

				$rtn = (string) $response['access_token'];
				if ( ! empty( $rtn ) ) {
					set_transient( $transient_name, $rtn, HOUR_IN_SECONDS );
				}
			}
		} catch ( \Exception $e ) {
			$message = 'Error getting Digital River Token: ' . $e->getMessage();
			error_log( $message ); // phpcs:ignore
			echo esc_html( $message );
		}

		return $rtn;
	}


	/**
	 * Pluck the results data from the input data to return just the specific results.
	 *
	 * @param array $input_data Input data.
	 * @return array
	 */
	abstract protected function transform_multiple( array $input_data): array;


	/**
	 * Transform the single input data.
	 *
	 * @param array $input_data Input data.
	 *
	 * @return array
	 */
	abstract protected function transform_single( array $input_data): array;

	/**
	 * Set the total results.
	 *
	 * @param int $input_total_results Total results count.
	 *
	 * @return void
	 */
	protected function set_total_results( int $input_total_results ): void {
		$this->total_results = $input_total_results;
	}

	/**
	 * Set the total pages.
	 *
	 * @param int $input_total_pages Total pages count.
	 *
	 * @return void
	 */
	protected function set_total_pages( int $input_total_pages ): void {
		$this->total_pages = $input_total_pages;
	}

	/**
	 * Return the value of an array key by name. Assumes input data is ['name'=>'name, 'value'=>'result'].
	 *
	 * @param array  $data Input data.
	 * @param string $name Name to filter input data array by.
	 *
	 * @return string
	 */
	protected function filter_value_by_name( array $data, string $name ): string {

		$filter = wp_list_filter( $data, [ 'name' => $name ] );
		return current( $filter )['value'] ?? '';
	}


	/**
	 * Convert string boolean to boolean.
	 *
	 * @param string $str   String to convert. Anything other than true will result in false.
	 *
	 * @return bool
	 */
	protected function convert_string_to_boolean( string $str ): bool {
		return $str === 'true';
	}
}
