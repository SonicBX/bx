<?php

//bx/modules/submodules/mq.bx.php
/*
require_once(__DIR__."/phpamqplib/Package.php");
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$bx["mq"]["connection"] = new AMQPStreamConnection(RABBITHOST, 5672, RABBITUSER, RABBITPASS);
$bx["mq"]["channel"] = $bx["mq"]["connection"]->channel();
*/
function bxmq_send($bxmq_queue,$bxmq_msg)
{
        global $bx;
        $bxmq_msg = json_encode($bxmq_msg,JSON_PRETTY_PRINT);
        $bxmq_channel->queue_declare($bxmq_queue, true, false, false, false);
        $bxmq_channel->basic_publish(new AMQPMessage($bxmq_msg), '',$bxmq_queue);
}

function bxmq_get($bxmq_queue)
{
        global $bx;
        $bxmq_channel ->queue_declare($bxmq_queue,true,false,false,false);

        $bxmq_callback = function($bxmq_msg) {
                if(handleMessage(json_decode($bxmq_msg->body,true)))
                {
                        $bxmq_msg->delivery_info['channel']->basic_ack($bxmq_msg->delivery_info['delivery_tag']);
                }
                else
                {
                        $bxmq_msg->delivery_info['channel']->basic_nack($bxmq_msg->delivery_info['delivery_tag'],false,true);
                }
        };
        $bxmq_channel->basic_qos(null, 1, null);
        $bxmq_channel->basic_consume($bxmq_queue, '', false, false, false, false, $bxmq_callback);
        while (count($bxmq_channel->callbacks)) {
                try { $bxmq_channel->wait(); }
                catch (Exception $bxmq_e)
                {
                        break;
                }
        }
        $bxmq_channel->close();
        $bxmq_connection->close();
}
