<?php

namespace Tests\Unit;

use App\Utils\StringUtils;
use PHPUnit\Framework\TestCase;

class SlugifyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_take_fewer_chunks_if_input_has_more()
    {
        $input = "two chunks";
        $output = StringUtils::slugify($input, 10);

        $this->assertEquals('two-chunks', $output);
    }


    public function test_stop_taking_chunks_after_limit()
    {
        $input = "has multiple chunks here but should only take 2";
        $output = StringUtils::slugify($input, 2);

        $this->assertEquals('has-multiple', $output);
    }
}
