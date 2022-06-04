<?php

namespace plugins;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use pukoframework\config\Config;

/**
 * Class MessageQueueRequest
 * @package plugins
 *
 * Example publish:
 * $data = MessageQueueRequest::Topics('stuff')->Publish($payload);
 *
 * Example consume:
 * $data = MessageQueueRequest::Topics('stuff')->Consume($callbacks);
 */
class MessageQueueRequest
{

    /**
     * @var null|object
     */
    protected $connection = null;

    /**
     * @var null|object
     */
    protected $channel = null;

    /**
     * @var string
     */
    protected $topics;

    /**
     * @var array
     */
    protected $payload;

    /**
     * MessageQueueRequest constructor.
     * @param $topics
     */
    protected function __construct($topics)
    {
        $config = Config::Data('mq');
        $this->connection = new AMQPStreamConnection($config['host'], $config['port'], $config['username'], $config['password']);
        $this->channel = $this->connection->channel();

        $this->channel->queue_declare($topics, false, true, false, false);

        $this->topics = $topics;
    }

    /**
     * @param $topics
     * @return MessageQueueRequest
     * @throws Exception
     */
    public static function Topics($topics)
    {
        return new MessageQueueRequest($topics);
    }

    /**
     * @param $payload
     * @return bool
     */
    public function Publish($payload)
    {
        $this->payload = json_encode($payload);
        $messages = new AMQPMessage($this->payload, [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
        $this->channel->basic_publish($messages, '', $this->topics);

        try {
            $this->channel->close();
            $this->connection->close();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param $callbacks
     * @return bool
     * @throws \ErrorException
     */
    public function Consume($callbacks)
    {
        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume(
            $this->topics,
            '',
            false,
            false,
            false,
            false,
            $callbacks
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

        try {
            $this->channel->close();
            $this->connection->close();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

}
