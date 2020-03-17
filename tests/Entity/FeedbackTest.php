<?php

namespace App\Tests\Entity;

use App\Entity\Feedback;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testForRestrictedWord1()
    {
        $feedback = new Feedback();
	$feedback->setMessage('test1');

	$result = $feedback->hasRestrictedMessage();

        $this->assertEquals(true, $result);
    }
    
    public function testForRestrictedWord2()
    {
        $feedback = new Feedback();
	$feedback->setMessage('test2');

	$result = $feedback->hasRestrictedMessage();

        $this->assertEquals(true, $result);
    }

    public function testForUncensoredWord()
    {
        $feedback = new Feedback();
	$feedback->setMessage('test');

	$result = $feedback->hasRestrictedMessage();

        $this->assertEquals(false, $result);
   }


}
