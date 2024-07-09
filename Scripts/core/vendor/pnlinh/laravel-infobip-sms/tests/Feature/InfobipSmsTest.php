<?php

namespace Pnlinh\InfobipSms\Tests;

use Illuminate\Http\Response;
use Pnlinh\InfobipSms\InfobipSmsService;

class InfobipSmsTest extends TestCase
{
    /** @test */
    public function it_can_created()
    {
        $infobipSmsService = new InfobipSmsService('foo', 'bar', '123');

        $this->assertNotNull($infobipSmsService);
    }

    /** @test */
    public function it_can_un_authorized()
    {
        $infobipSmsService = new InfobipSmsService('foo', 'bar', '123');

        $response = $infobipSmsService->send('84123456789', 'la la la');

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response[0]);
    }
}
