<?php


use Hyqo\CLI\Output;
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{
    public function testSend()
    {
        $tmp = tmpfile();

        Output::send('test', $tmp);

        $content = file_get_contents(stream_get_meta_data($tmp)['uri']);
        fclose($tmp);

        $this->assertEquals("test\n", $content);
    }
}
