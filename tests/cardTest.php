<?php

// phpunit tests/CardTest --repeat 10000

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\CardService\CardService;

class CardTest extends TestCase
{

    protected $repoMock;
    protected $service;

    public function setUp()
    {
        if (is_null($this->repoMock))
            $this->repoMock = Mockery::mock('App\Services\CardService\ICardService');

        if (is_null($this->service))
            $this->service = new CardService($this->repoMock);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testDrawCards()
    {
        $cardSuites = array('s', 'h', 'c', 'd');
        $cardRank = range(2, 10);
        $cardRank = array_merge($cardRank, array('a', 'j', 'q', 'k'));
        $result = $this->service->drawCards();


        $this->assertInternalType('array', $result);
        $this->assertCount(5, $result);
        $this->assertCount(5, array_unique($result));
        foreach ($result as $val) {
            $this->assertInternalType('string', $val);
            $this->assertGreaterThanOrEqual(2, strlen($val));
            $this->assertLessThanOrEqual(3, strlen($val));

            $chars = str_split($val);
            if (strlen($val) == 3) {
                $this->assertStringStartsWith('10', $val);
                $this->assertContains($chars[2], $cardSuites);
            } else {
                $this->assertContains($chars[0], $cardRank);
                $this->assertContains($chars[1], $cardSuites);
            }
        }
    }

    public function testIsCardStraight()
    {
        $this->assertTrue($this->service->isCardStraight(array('2h', '4h', '3h', 'ah', '5h')));
        $this->assertTrue($this->service->isCardStraight(array('8h', 'jc', 'qc', '10d', '9s')));
        $this->assertTrue($this->service->isCardStraight(array('ah', '10d', 'qh', 'jc', 'kd')));
        $this->assertTrue($this->service->isCardStraight(array('7h', '5s', '4s', '8d', '6h')));

        $this->assertFalse($this->service->isCardStraight(array('3h', 'js', '3h', '5d', '4h')));
        $this->assertFalse($this->service->isCardStraight(array('2h', '2s', '3h', '4d', '6h')));
        $this->assertFalse($this->service->isCardStraight(array('js', 'as', 'ks', '2s', 'qs')));
    }

}
