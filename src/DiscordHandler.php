<?php

namespace DiscordHandler;

use GuzzleHttp\Client;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class DiscordHandler extends AbstractProcessingHandler
{
    /**
     * @var \GuzzleHttp\Client;
     */
    private $client;

    /**
     * @var array
     */
    private $webhooks;

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
     * DiscordHandler constructor.
     * @param $webhooks
     * @param int $level
     * @param bool $bubble
     */
    public function __construct($webhooks, $level, $bubble = true)
    {
        $this->client = new Client();
        $this->webhooks = $webhooks;
        parent::__construct($level, $bubble);
    }

    /**
     * @param array $record
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function write(array $record)
    {
        $content = [
            "embeds" => [
                [
                    "title" => $record['level_name'],
                    "description" => $record['message'],
                    "timestamp" => date('Y-m-d') . 'T' . date("H:i:s") . '.' . date("v") . 'Z',
                    "color" => $this->levelColors[$record['level']],
                ],
            ],
        ];

        foreach ($this->webhooks as $webhook) {
            $this->client->request('POST', $webhook, [
                'json' => $content,
            ]);
        }
    }
}
