<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RedisRankingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private $users;

    private $keyName = 'recently-keyword';

    private $redis;

    private $userSize = 30;

    protected function setUp(): void
    {
        parent::setUp();

        $krFaker = \Faker\Factory::create('ko_KR');

        // 사용자 생성
        for($i = 0; $i < $this->userSize; $i++) {
            $this->users[] = $krFaker->name;
        }

        $this->redis = new \Redis();

        $this->redis->connect(config('database.redis.default.host'), config('database.redis.default.port'));
        $this->redis->auth(['secret']);
        // 기존 member 삭제

        $this->redis->zAdd($this->keyName, 1, 1);

        

        $allMembers = $this->redis->zRange($this->keyName, 0, -1);
        
        foreach ($allMembers as $member) {
            $this->redis->zRem($this->keyName, $member);
        }
    }

    protected function tearDown(): void
    {
        for($i = 0; $i < $this->userSize; $i++) {
            // test 데이타 삭제
            $this->redis->zRem($this->keyName, $this->users[$i]);
        }

        $this->redis->close();

        parent::tearDown();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $key = $this->keyName;

        for ($i = 0 ; $i < 10000; $i++)
        {
            $n = mt_rand(0, count($this->users) - 1);

            $e = $this->users[$n];

            $score = (int)mt_rand(1, 10);

            $this->redis->zIncrBy($key, $score, $e);
        }

        $memeber = $this->users[0];

        $rank = $this->redis->zRank($key, $memeber);
        $revRank = $this->redis->zRevRank($key, $memeber);

        // with score
        $range = $this->redis->zRange($key, 0, 10, true);

        // 마지막 파라미터는 with score
        // https://github.com/phpredis/phpredis#zrevrange
        $revrange = $this->redis->zRevRange($key, 0, 10, true);

        dump([
            'member' => $memeber,
            'rank' => $rank,
            'revRank' => $revRank,
            'revrange' => $revrange,
            'range' => $range,
            ]);

        $this->assertTrue(true);
    }
}
