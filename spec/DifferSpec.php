<?php

namespace spec\Appocular\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Appocular\Clients\Differ;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RuntimeException;

class DifferSpec extends ObjectBehavior
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
        $this->shouldHaveType(Differ::class);
    }

    function it_should_submit_diffs_to_differ(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $expected_json = ['image_url' => 'image url', 'baseline_url' => 'baseline url'];
        $client->post('diff', ['json' => $expected_json] + $this->commonHeaders())
            ->willReturn($response)->shouldBeCalled();
        $this->submit('image url', 'baseline url')->shouldReturn(null);
    }

    function it_should_deal_with_bad_response_codes(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(300);
        $expected_json = ['image_url' => 'image url', 'baseline_url' => 'baseline url'];
        $client->post('diff', ['json' => $expected_json] + $this->commonHeaders())->willReturn($response);

        $this->shouldThrow(new RuntimeException('Bad response from Differ.'))
            ->duringSubmit('image url', 'baseline url');
    }

    function it_has_configurable_timeout(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $expected_json = ['image_url' => 'image url', 'baseline_url' => 'baseline url'];

        $client->post('diff', ['json' => $expected_json] + $this->commonHeaders(30))
            ->willReturn($response)->shouldBeCalled();

        $this->beConstructedWith('mytoken', $client, 30);

        $this->submit('image url', 'baseline url')->shouldReturn(null);
    }
}
