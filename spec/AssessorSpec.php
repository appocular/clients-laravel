<?php

namespace spec\Appocular\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Appocular\Clients\Assessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RuntimeException;

class AssessorSpec extends ObjectBehavior
{

    function let(Client $client)
    {
        $this->beConstructedWith('mytoken', $client);
    }

    function commonHeaders()
    {
        return ['timeout' => 5, 'headers' => ['Authorization' => 'Bearer mytoken']];
    }

    function it_is_initializable(Client $client)
    {
        $this->shouldHaveType(Assessor::class);
    }

    function it_should_submit_diffs_to_assessor(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $expected_json = [
            'image_url' => 'image url',
            'baseline_url' => 'baseline url',
            'diff_url' => 'diff url',
            'different' => true,
        ];
        $client->post('diff', ['json' => $expected_json] + $this->commonHeaders())
            ->willReturn($response)->shouldBeCalled();
        $this->reportDiff('image url', 'baseline url', 'diff url', true)->shouldReturn(null);
    }

    function it_should_deal_with_bad_response_codes(Client $client, Response $response)
    {
        $response->getStatusCode()->willReturn(300);
        $expected_json = [
            'image_url' => 'image url',
            'baseline_url' => 'baseline url',
            'diff_url' => 'diff url',
            'different' => true,
        ];
        $client->post('diff', ['json' => $expected_json] + $this->commonHeaders())->willReturn($response);

        $this->shouldThrow(new RuntimeException('Bad response from Assessor.'))
            ->duringReportDiff('image url', 'baseline url', 'diff url', true);
    }
}
