<?php

class MoreTestCases extends \PHPUnit_Framework_TestCase
{

/**
 * Retrieves a unique id from the long running server process in tools/tests/FunctionalTestProcessGenerator.php
 *
 * @param string $sBuildNumber The build number that should be used to get the process id
 * @param string $sTestSuite The test suite that will be requesting a build number
 *
 * @author Fungai Pamire <fungai.pamire@a24group.com>
 * @since  11 February 2014
 *
 * @return int
 */
protected function getUniqueNumber($sBuildNumber, $sTestSuite = '')
{

    if (!empty($sBuildNumber)) {
        $sAddress = '127.0.0.1';
        $iPort = 78787;

        $bConnectionOk = true;

        if (($objSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            $bConnectionOk = false;
        }

        if ($bConnectionOk && ($mResult = socket_connect($objSocket, $sAddress, $iPort)) === false ) {
            $bConnectionOk = false;
        }

        $sCommand = 'add ' . $sBuildNumber . ' ' . $sTestSuite;
        socket_write($objSocket, $sCommand, strlen($sCommand));

        $iUniqueId = null;
        $mOutput = socket_read($objSocket, 2048);
        if (strlen($mOutput) == 0) {
            echo "ERROR SOCKET SERVER DID NOT SEND CONTENT";
        }

        $iUniqueId = (int) $mOutput;
        socket_close($objSocket);

        if ($iUniqueId == -1 || strlen($mOutput) == 0) {
            sleep(10);
            return $this->getUniqueNumber($sBuildNumber, $sTestSuite);
        }
        return $iUniqueId;
    }
    return -1;
}

/**
 * @group test
 */
  public function testThisIsRandom()
  {
	print_r("THE NUMBER " . $this->getUniqueNumber(getenv("BUILD_NUMBER")));
	print_r("THE EXECUTOR" . getenv("EXECUTOR_NUMBER"));
	$this->assertTrue(true);
	//$this->fail('THIS IS A FAILURE');
  }	


}
