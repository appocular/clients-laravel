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
    function let(Client $client)
    {
        $this->beConstructedWith('mytoken', $client, 5);
    }

    function commonHeaders($timeout = 5)
    {
        return ['timeout' => $timeout, 'headers' => ['Authorization' => 'Bearer mytoken']];
    }

    function it_is_initializable(Client $client)
    {
        $this->shouldHaveType(Keeper::class);
    }

    function it_should_put_files_to_keeper(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(201);
        $response->getHeader('Location')->willReturn(['http://host/image/the_kid']);
        $client->post('image', ['body' => 'image data'] + $this->commonHeaders())
            ->willReturn($response)->shouldBeCalled();
        $this->store('image data')->shouldReturn('http://host/image/the_kid');
    }

    function it_should_deal_with_bad_responses(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $client->post('image', ['body' => 'image data'] + $this->commonHeaders())
            ->willReturn($response)->shouldBeCalled();
        $response->getHeader('Location')->willReturn([]);
        $this->shouldThrow(new RuntimeException('Bad response from Keeper.'))->duringStore('image data');
    }

    function it_should_deal_with_horrible_responses(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $response->getHeader('Location')->willReturn(['/image/the_kid', '/and/some/other']);
        $client->post('image', ['body' => 'image data'] + $this->commonHeaders())
            ->willReturn($response)->shouldBeCalled();

        $this->shouldThrow(new RuntimeException('Bad response from Keeper.'))->duringStore('image data');
    }

    function it_should_deal_with_bad_response_codes(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(300);
        $response->getHeader('Location')->willReturn(['/image/the_kid']);
        $client->post('image', ['body' => 'image data'] + $this->commonHeaders())
            ->willReturn($response)->shouldBeCalled();

        $this->shouldThrow(new RuntimeException('Bad response from Keeper.'))->duringStore('image data');
    }

    function it_should_return_images_from_keeper(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn('<png data>');

        $client->get('http://host/image/somekid', ['timeout' => 5])->willReturn($response)->shouldBeCalled();

        $this->get('http://host/image/somekid')->shouldReturn('<png data>');
    }

    function it_should_deal_with_missing_image(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(404);

        $client->get('http://host/image/somekid', ['timeout' => 5])->willReturn($response)->shouldBeCalled();

        $this->get('http://host/image/somekid')->shouldReturn(null);
    }

    function it_has_configurable_timeout(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(201);
        $response->getHeader('Location')->willReturn(['http://host/image/the_kid']);

        $client->post('image', ['body' => 'image data'] + $this->commonHeaders(30))
            ->willReturn($response)->shouldBeCalled();

        $this->beConstructedWith('mytoken', $client, 30);

        $this->store('image data')->shouldReturn('http://host/image/the_kid');
    }
}
