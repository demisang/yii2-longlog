<?php
/**
 * @copyright Copyright (c) 2017 Ivan Orlov
 * @license   https://github.com/demisang/yii2-longlog/blob/master/LICENSE
 * @link      https://github.com/demisang/yii2-longlog#readme
 */

namespace longlog\yii2;

use longlog\LongLogClientWrapper;
use yii\base\InvalidConfigException;

/**
 * Yii2 LongLog API component
 *
 * @property-read \longlog\Client $client Client instance
 */
class Component extends \yii\base\Component
{
    /**
     * Endpoint API url
     *
     * @var string For example: http://api.longlog.ru
     */
    public $endpointUrl;
    /**
     * Project secret token
     *
     * @var string 32 characters
     */
    public $projectToken;
    /**
     * Max connection timeout
     *
     * @var integer Timeout seconds
     */
    public $timeout = 30;

    /**
     * API client instance
     *
     * @var \longlog\Client
     */
    protected $client;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        // Check config
        if (!$this->endpointUrl) {
            throw new InvalidConfigException('Endpoint URL required');
        }

        if (!$this->projectToken) {
            throw new InvalidConfigException('Project token required');
        } elseif (strlen($this->projectToken) !== 32) {
            throw new InvalidConfigException('Project token must be 32 characters length');
        }

        $client = new \longlog\Client($this->endpointUrl, $this->projectToken);
        $client->setTimeout($this->timeout);

        $this->client = $client;
    }

    /**
     * Get new log instance with client wrapper
     *
     * @param string $jobName      Custom job name, for example: "CRON_SEND_EMAILS"
     * @param string|null $payload Log payload, it is simple string, for example: "userIds: [1, 2, 3]"
     *
     * @return LongLogClientWrapper
     */
    public function newLog($jobName, $payload = null)
    {
        return LongLogClientWrapper::create($this->client, $jobName, $payload);
    }

    /**
     * Get client instance
     *
     * @return \longlog\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
