<?php
require_once dirname(__FILE__).'/../harness/DummyRequest.php';
require_once dirname(__FILE__).'/../harness/DummyMultiRequest.php';
require_once dirname(__FILE__).'/../harness/BasicResponse.php';

/**
 * Test class for verifying the operation of service tickets.
 *
 *
 * Generated by PHPUnit on 2010-09-07 at 13:33:53.
 */
class MultiRequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CAS_Client
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {

		/*********************************************************
		 * Enumerate our responses
		 *********************************************************/
		$response = new CAS_TestHarness_BasicResponse('http', 'www.jasig.org', '/some/path');
		$response->ensureIsGet();
		$response->setResponseHeaders(array(
			'HTTP/1.1 200 OK',
			'Date: Wed, 29 Sep 2010 19:20:57 GMT',
			'Server: Apache-Coyote/1.1',
			'Pragma: no-cache',
			'Expires: Thu, 01 Jan 1970 00:00:00 GMT',
			'Cache-Control: no-cache, no-store',
			'Content-Type: text/html;charset=UTF-8',
			'Content-Language: en-US',
			'Via: 1.1 cas.example.edu',
			'Connection: close',
			'Transfer-Encoding: chunked',
		));
		$response->setResponseBody(
"I am Jasig");
		CAS_TestHarness_DummyRequest::addResponse($response);
		
		$response = new CAS_TestHarness_BasicResponse('http', 'www.example.org', '/some/other/path');
		$response->ensureIsGet();
		$response->setResponseHeaders(array(
			'HTTP/1.1 200 OK',
			'Date: Wed, 29 Sep 2010 19:20:57 GMT',
			'Server: Apache-Coyote/1.1',
			'Pragma: no-cache',
			'Expires: Thu, 01 Jan 1970 00:00:00 GMT',
			'Cache-Control: no-cache, no-store',
			'Content-Type: text/html;charset=UTF-8',
			'Content-Language: en-US',
			'Via: 1.1 cas.example.edu',
			'Connection: close',
			'Transfer-Encoding: chunked',
		));
		$response->setResponseBody(
"I am Example");
		CAS_TestHarness_DummyRequest::addResponse($response);
		
		
		$response = new CAS_TestHarness_BasicResponse('http', 'www.educause.edu', '/path');
		$response->ensureIsGet();
		$response->setResponseHeaders(array(
			'HTTP/1.1 200 OK',
			'Date: Wed, 29 Sep 2010 19:20:57 GMT',
			'Server: Apache-Coyote/1.1',
			'Pragma: no-cache',
			'Expires: Thu, 01 Jan 1970 00:00:00 GMT',
			'Cache-Control: no-cache, no-store',
			'Content-Type: text/html;charset=UTF-8',
			'Content-Language: en-US',
			'Via: 1.1 cas.example.edu',
			'Connection: close',
			'Transfer-Encoding: chunked',
		));
		$response->setResponseBody(
"I am Educause");
		CAS_TestHarness_DummyRequest::addResponse($response);
		
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
		CAS_TestHarness_DummyRequest::clearResponses();
    }

    /**
     * Test a single request
     */
    public function test_single() {
		$request = new CAS_TestHarness_DummyRequest();
		$request->setUrl('http://www.example.org/some/other/path');
		$this->assertTrue($request->send());
		$this->assertEquals("I am Example", $request->getResponseBody());
    }
    
    /**
     * Test a multiple requests
     */
    public function test_multiple() {
    	$multi = new CAS_TestHarness_DummyMultiRequest();
    	
		$request1 = new CAS_TestHarness_DummyRequest();
		$request1->setUrl('http://www.jasig.org/some/path');
		$multi->addRequest($request1);
		
		$request2 = new CAS_TestHarness_DummyRequest();
		$request2->setUrl('http://www.example.org/some/other/path');
		$multi->addRequest($request2);
		
		$request3 = new CAS_TestHarness_DummyRequest();
		$request3->setUrl('http://www.educause.edu/path');
		$multi->addRequest($request3);
		
		$multi->send();
		
		$this->assertEquals("I am Jasig", $request1->getResponseBody());
		$this->assertEquals("I am Example", $request2->getResponseBody());
		$this->assertEquals("I am Educause", $request3->getResponseBody());
    }
}
?>
