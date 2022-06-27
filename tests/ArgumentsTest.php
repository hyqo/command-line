<?php

use Hyqo\Cli\Arguments;
use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{
    /** @var string[] */
    private $input = [
        'arg0',
        'arg1',
        'arg2',
        '-fa',
        '--l1=foo',
        '--l2=false',
        '--l3',
    ];

    /** @var Arguments */
    private $arguments;

    protected function setUp(): void
    {
        $this->arguments = new Arguments($this->input);
    }

    public function testGetAllArgument()
    {
        $this->assertEquals($this->input, $this->arguments->getAll());
    }

    public function testGetFirstArgument()
    {
        $this->assertEquals('arg1', $this->arguments->getFirst());
    }

    public function testGetArgument()
    {
        $this->assertEquals('arg1', $this->arguments->get(1));
        $this->assertEquals('arg2', $this->arguments->get(2));
    }

    public function testGetShortOptions()
    {
        $this->assertEquals(['f' => true, 'a' => true], $this->arguments->getShortOptions());
    }

    public function testGetLongOptions()
    {
        $this->assertEquals(
            ['l1' => 'foo', 'l2' => false, 'l3' => true],
            $this->arguments->getLongOptions()
        );
    }
}
