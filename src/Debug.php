<?php

namespace YusamHub\Debug;

if (!defined('YUSAM_HUB_IS_DEBUGGING')) {
    define('YUSAM_HUB_IS_DEBUGGING', false);
}

if (!defined('YUSAM_HUB_DEBUG_LOG_DIR')) {
    define('YUSAM_HUB_DEBUG_LOG_DIR', __DIR__);
}

if (!defined('YUSAM_HUB_DEBUG_FORMAT_DATETIME')) {
    define('YUSAM_HUB_DEBUG_FORMAT_DATETIME', 'Y-m-d H:i:s');
}

/**
 * Class Debug
 * @package YusamHub\Debug
 */
class Debug
{
    /**
     * @var Debug|null
     */
    private static ?Debug $instance = null;

    /**
     * @var bool
     */
    protected bool $isDebugging;

    /**
     * Debug constructor.
     */
    public function __construct()
    {
        $this->isDebugging = (bool) constant('YUSAM_HUB_IS_DEBUGGING');
    }

    /**
     * @return Debug
     */
    public static function instance(): Debug
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * @return int
     */
    public static function milliseconds(): int
    {
        return (int) round(microtime(true) * 1000, 0);
    }

    /**
     * @param bool $value
     */
    public function setIsDebugging(bool $value): void
    {
        $this->isDebugging = $value;
    }

    /**
     * @return bool
     */
    public function getIsDebugging(): bool
    {
        return $this->isDebugging;
    }

    /**
     * Pre print_r vars and not exit
     * @param mixed ...$vars
     */
    public function nddPrePrint(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        foreach ($vars as $v) {
            echo "<pre>";
            echo print_r($v, true);
            echo "</pre>";
        }
    }

    /**
     * Pre var_export and not exit
     * @param mixed ...$vars
     */
    public function nddPreExport(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        foreach ($vars as $v) {
            echo "<pre>";
            var_export($v);
            echo "</pre>";
        }
    }

    /**
     * Pre var_dump and not exit
     * @param mixed ...$vars
     */
    public function nddPreDump(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        foreach ($vars as $v) {
            echo "<pre>";
            var_dump($v);
            echo "</pre>";
        }
    }

    /**
     * print_r vars and not exit
     * @param mixed ...$vars
     */
    public function nddPrint(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        foreach ($vars as $v) {
            echo PHP_EOL;
            echo print_r($v, true);
            echo PHP_EOL;
        }
    }

    /**
     * var_export and not exit
     * @param mixed ...$vars
     */
    public function nddExport(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        foreach ($vars as $v) {
            echo PHP_EOL;
            var_export($v);
            echo PHP_EOL;
        }
    }

    /**
     * var_dump and not exit
     * @param mixed ...$vars
     */
    public function nddDump(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        foreach ($vars as $v) {
            echo PHP_EOL;
            var_dump($v);
            echo PHP_EOL;
        }
    }

    /**
     * Pre print_r vars and exit
     * @param mixed ...$vars
     */
    public function ddPrePrint(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        $this->nddPrePrint(...$vars);

        exit("exit in " . __METHOD__);
    }

    /**
     * Pre var_export and exit
     * @param mixed ...$vars
     */
    public function ddPreExport(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        $this->nddPreExport(...$vars);

        exit("exit in " . __METHOD__);
    }

    /**
     * Pre var_dump and exit
     * @param mixed ...$vars
     */
    public function ddPreDump(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        $this->nddPreDump(...$vars);

        exit("exit in " . __METHOD__);
    }

    /**
     * print_r vars and exit
     * @param mixed ...$vars
     */
    public function ddPrint(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        $this->nddPrint(...$vars);

        exit("exit in " . __METHOD__ . PHP_EOL);
    }

    /**
     * var_export and exit
     * @param mixed ...$vars
     */
    public function ddExport(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        $this->nddExport(...$vars);

        exit("exit in " . __METHOD__ . PHP_EOL);
    }

    /**
     * var_dump and exit
     * @param mixed ...$vars
     */
    public function ddDump(...$vars): void
    {
        if (!$this->getIsDebugging()) return;

        $this->nddDump(...$vars);

        exit("exit in " . __METHOD__ . PHP_EOL);
    }

    /**
     * @return string
     */
    protected function getSystemString(): string
    {
        return date(constant('YUSAM_HUB_DEBUG_FORMAT_DATETIME')) . " " . static::milliseconds() . " " . getmypid();
    }

    /**
     * @param string $shortName
     * @return string
     */
    protected function prepareFile(string $shortName): string
    {
        $file = constant('YUSAM_HUB_DEBUG_LOG_DIR') . DIRECTORY_SEPARATOR . $shortName . "-" . date("Y-m-d"). ".log";
        $directory = pathinfo($file, PATHINFO_DIRNAME);

        if (!file_exists($directory)) {
            @mkdir($directory, 0777, true);
        }

        return $file;
    }

    /**
     * @param string $shortName
     * @param mixed ...$vars
     */
    public function logPrint(string $shortName, ...$vars): void
    {
        if (empty($shortName)) {
            $shortName = 'debug-print';
        }
        $file = $this->prepareFile($shortName);
        @file_put_contents($file, $this->getSystemString() . PHP_EOL , FILE_APPEND);
        foreach ($vars as $v) {
            @file_put_contents($file, print_r($v, true) . PHP_EOL, FILE_APPEND);
        }
        @file_put_contents($file, PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $shortName
     * @param mixed ...$vars
     */
    public function logExport(string $shortName, ...$vars): void
    {
        if (empty($shortName)) {
            $shortName = 'debug-export';
        }
        $file = $this->prepareFile($shortName);
        @file_put_contents($file, $this->getSystemString() . PHP_EOL , FILE_APPEND);
        foreach ($vars as $v) {
            @file_put_contents($file, var_export($v, true) . PHP_EOL, FILE_APPEND);
        }
        @file_put_contents($file, PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $shortName
     * @param mixed ...$vars
     */
    public function logDump(string $shortName, ...$vars): void
    {
        if (empty($shortName)) {
            $shortName = 'debug-dump';
        }
        $file = $this->prepareFile($shortName);
        @file_put_contents($file, $this->getSystemString() . PHP_EOL , FILE_APPEND);
        foreach ($vars as $v) {
            ob_start();
            var_dump($v);
            $content = ob_get_contents();
            ob_end_clean();
            @file_put_contents($file, $content . PHP_EOL, FILE_APPEND);
        }
        @file_put_contents($file, PHP_EOL, FILE_APPEND);
    }

}