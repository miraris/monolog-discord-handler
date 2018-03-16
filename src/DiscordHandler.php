<?php
namespace DiscordHandler;

use \Monolog\Logger;
use \Monolog\Handler\AbstractProcessingHandler;

class DiscordHandler extends AbstractProcessingHandler
{
	private $initialized = false;
	private $client;

	private $name;
	private $subname;

	private $webhooks;
	private $statement;

	/**
     * Colors for a given log level.
     *
     * @var array
     */
    protected $levelColors = [
        Logger::DEBUG => 10395294,
        Logger::INFO => 5025616,
        Logger::NOTICE => 6323595,
        Logger::WARNING => 16771899,
        Logger::ERROR => 16007990,
        Logger::CRITICAL => 16007990,
        Logger::ALERT => 16007990,
        Logger::EMERGENCY => 16007990,
    ];

	/**
	 * MonologDiscordHandler constructor.
	 * @param \GuzzleHttp\Client $client
	 * @param array $webhooks
	 * @param int $level
	 * @param bool $bubble
	 */
	public function __construct($webhooks, $name, $subname = '', $level = Logger::DEBUG, $bubble = true)
	{
		$this->name = $name;
		$this->subname = $subname;
		$this->client = new \GuzzleHttp\Client();
		$this->webhooks = $webhooks;
		parent::__construct($level, $bubble);
	}

	/**
	 * @param array $record
	 */
	protected function write(array $record)
	{
		$content = [
			"embeds" => [
				[
					"title" => $record['level_name'],
					"description" => $record['message'],
					"timestamp" => date('Y-m-d').'T'.date("H:i:s").'.'.date("v").'Z',
					"color" => $this->levelColors[$record['level']]
				],
			],
		];

		foreach ($this->webhooks as $webhook) {
			$req = $this->client->request('POST', $webhook, [
				'json' => $content,
			]);
		}
	}
}