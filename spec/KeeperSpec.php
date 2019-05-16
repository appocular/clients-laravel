<?php

namespace spec\Appocular\Clients;

use Appocular\Clients\Keeper;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RuntimeException;

class KeeperSpec extends ObjectBehavior
{
    function it_is_initializable(Client $client)
    {
        $this->beConstructedWith($client);
        $this->shouldHaveType(Keeper::class);
    }

    function it_should_put_files_to_keeper(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn(json_encode(['sha' => 'the kid']));
        $client->post('image', ['body' => 'image data', 'timeout' => 5])->willReturn($response)->shouldBeCalled();
        $this->beConstructedWith($client);
        $this->store('image data')->shouldReturn('the kid');
    }

    function it_should_deal_with_bad_responses(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn(json_encode(['lala' => 'the kid']));
        $client->post('image', ['body' => 'image data', 'timeout' => 5])->willReturn($response)->shouldBeCalled();

        $this->beConstructedWith($client);
        $this->shouldThrow(new RuntimeException('Bad response from Keeper.'))->duringStore('image data');
    }

    function it_should_deal_with_bad_response_codes(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(300);
        $response->getBody()->willReturn(json_encode(['sha' => 'the kid']));
        $client->post('image', ['body' => 'image data', 'timeout' => 5])->willReturn($response)->shouldBeCalled();

        $this->beConstructedWith($client);
        $this->shouldThrow(new RuntimeException('Bad response from Keeper.'))->duringStore('image data');
    }

    function it_should_return_images_from_keeper(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn('<png data>');

        $client->get('image/somekid', ['timeout' => 5])->willReturn($response)->shouldBeCalled();

        $this->beConstructedWith($client);
        $this->get('somekid')->shouldReturn('<png data>');
    }

    function it_should_deal_with_missing_image(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(404);

        $client->get('image/somekid', ['timeout' => 5])->willReturn($response)->shouldBeCalled();

        $this->beConstructedWith($client);
        $this->get('somekid')->shouldReturn(null);
    }
}
