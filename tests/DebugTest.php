<?php

namespace YusamHub\Debug\Tests;

use YusamHub\Debug\Debug;

class DebugTest extends \PHPUnit\Framework\TestCase
{
    public function testLogMethods()
    {
        Debug::instance()->logPrint('', [
            'key1' => 'value1'
        ]);
        Debug::instance()->logExport('', [
            'key1' => 'value1'
        ]);
        Debug::instance()->logDump('', [
            'key1' => 'value1'
        ]);
        $this->assertTrue(true);
    }

    public function testNddMethods()
    {
        ob_start();
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertEmpty($content);

        /**
         * -------------------------------------------------------------------------------------------------------------
         */

        ob_start();
        Debug::instance()->nddPrint([
            'key1' => 'value1'
        ]);
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertNotEmpty($content);

        /**
         * -------------------------------------------------------------------------------------------------------------
         */

        ob_start();
        Debug::instance()->nddPrePrint([
            'key1' => 'value1'
        ]);
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertNotEmpty($content);

        /**
         * -------------------------------------------------------------------------------------------------------------
         */

        ob_start();
        Debug::instance()->nddExport([
            'key1' => 'value1'
        ]);
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertNotEmpty($content);

        /**
         * -------------------------------------------------------------------------------------------------------------
         */

        ob_start();
        Debug::instance()->nddPreExport([
            'key1' => 'value1'
        ]);
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertNotEmpty($content);

        /**
         * -------------------------------------------------------------------------------------------------------------
         */

        ob_start();
        Debug::instance()->nddDump([
            'key1' => 'value1'
        ]);
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertNotEmpty($content);

        /**
         * -------------------------------------------------------------------------------------------------------------
         */

        ob_start();
        Debug::instance()->nddPreDump([
            'key1' => 'value1'
        ]);
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertNotEmpty($content);
    }
}